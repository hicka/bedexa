<div>

    <x-page-heading title="Reservations"/>

    {{-- Legend --}}
    <div class="flex gap-4 mb-4 text-sm">
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-yellow-400"></span> Reserved</span>
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-green-500"></span> Checked-in/out</span>
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-blue-500"></span> Occupied</span>
    </div>

    {{-- Grid wrapper allows horizontal scroll --}}
    <div class="overflow-x-auto">
        <table class="border-collapse min-w-[900px]">
            <thead class="sticky top-0 bg-white dark:bg-slate-900 z-10">
            <tr>
                <th class="w-36 border-r"></th>
                @foreach ($dates as $d)
                    <th class="w-28 text-xs py-2 border-r text-center">
                        {{ $d->format('d') }}<br><span class="text-gray-500">{{ $d->format('D') }}</span>
                    </th>
                @endforeach
            </tr>
            </thead>

            <tbody>
            @php $currentType = null; @endphp
            @foreach ($rooms as $room)
                {{-- Room type heading row --}}
                @if ($currentType !== $room->room_type_id)
                    <tr><td colspan="{{ $dates->count()+1 }}" class="bg-slate-100 dark:bg-slate-800 font-semibold px-2">
                            {{ $room->type->name }}
                        </td></tr>
                    @php $currentType = $room->room_type_id; @endphp
                @endif

                {{-- Room row --}}
                <tr class="border-b">
                    {{-- Left label col --}}
                    <td class="w-36 px-2 py-1 border-r text-sm">{{ $room->room_number }}</td>

                    {{-- Date cells --}}
                    @foreach ($dates as $date)
                        @php
                            $roomBookings = $bookings[$room->id] ?? collect();
                                $cellKey = $date->toDateString();
                                $booking = $roomBookings->first(fn($b) =>
                $date->between($b->check_in, $b->check_out->subDay())
            ) ?? null;

                        @endphp
                        <td class="w-28 h-12 relative border-r border-dashed">
                            @if($booking && $date->isSameDay($booking->check_in))
                                @php
                                    $nights = $booking->nights;
                                    $width  = $nights * 7;
                                    $colors = [
                                        'reserved'   => 'bg-yellow-200 text-yellow-900',
                                        'checked_in' => 'bg-green-200 text-green-900',
                                        'checked_out'=> 'bg-green-200 text-green-900',
                                        'occupied'   => 'bg-blue-200 text-blue-900',
                                    ];
                                    $barClass = $colorMap[$booking->status] ?? 'bg-slate-200 text-gray-800';
                                @endphp
                                <a  href="{{ route('bookings.edit',$booking->booking) }}"
                                    class="absolute left-0 top-0 h-full px-2 py-1 text-xs overflow-hidden rounded {{ $barClass }}"
                                    style="width: {{ $width }}rem">
                                    {{ $booking->booking->guests->pluck('full_name')->implode(', ') }}
                                    <span class="block mt-1">
                                        @switch($booking->payment_state)
                                            @case('paid')      <span class="bg-green-600 text-white px-1 rounded">Paid</span> @break
                                            @case('part-paid') <span class="bg-pink-600 text-white px-1 rounded">Part-paid</span> @break
                                            @default           <span class="bg-orange-600 text-white px-1 rounded">Unpaid</span>
                                        @endswitch
                                    </span>
                                </a>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
