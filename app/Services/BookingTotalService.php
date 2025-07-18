<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingRoom;
use Illuminate\Support\Carbon;

class BookingTotalService
{
    public static function calculate(Booking $booking): array
    {
        $roomTotal = 0;

        foreach ($booking->rooms as $room) {
            $nights = Carbon::parse($room->check_in)->diffInDays(Carbon::parse($room->check_out));
            $price  = $room->price ?? $room->room->roomType->base_price * $nights;
            $roomTotal += $price;
        }

        // taxes
        $service   = $roomTotal * 0.10;      // 10 %
        $subTotal  = $roomTotal + $service;
        $tgst      = $subTotal  * 0.12;      // 12 %
        $greenTax  = self::greenTax($booking); // $6 p p n foreign

        $discount  = $booking->discount_amount ?? 0; // future UI
        $grand     = $subTotal + $tgst + $greenTax - $discount;

        return [
            'room_total'     => $roomTotal,
            'service_charge' => $service,
            'tgst'           => $tgst,
            'green_tax'      => $greenTax,
            'discount_amount'=> $discount,
            'total_amount'   => $grand,
            'balance_due'    => max($grand - $booking->total_paid, 0),
        ];
    }

    protected static function greenTax(Booking $booking): float
    {
        $foreignGuests = $booking->guests->where('type','foreign')->count();
        $nights = $booking->rooms->sum(fn(BookingRoom $br) =>
        Carbon::parse($br->check_in)->diffInDays(Carbon::parse($br->check_out))
        );

        return $foreignGuests * $nights * 12; // $12
    }
}
