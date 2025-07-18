<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Livewire\Calendar\Index as CalendarIndex;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Tests\TestCase;

class CalendarNavigationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
        public function test_booking_reappears_after_next_and_prev_navigation()
    {
        // ── 1. Create minimal tenant context ───────────────

        if (! Schema::hasTable('teams')) {
            Schema::create('teams', function ($table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }


        $team = Team::forceCreate([
            'name'           => 'Test Team',
            'slug'           => 'test-team',
        ]);

        $user = User::forceCreate([
            'name'              => 'Tester',
            'email'             => 'tester@example.com',
            'password'          => bcrypt('password'),
            'team_id'   => $team->id,
        ]);

        $this->actingAs($user);

        // ── 2. Create RoomType, Room, Guest ────────────────
        $roomType = RoomType::create([
            'team_id'     => $team->id,
            'name'        => 'Deluxe',
            'base_price'  => 200,
        ]);

        $room = Room::create([
            'team_id'       => $team->id,
            'room_type_id'  => $roomType->id,
            'room_number'   => '101',
            'status'        => 'available',
        ]);

        $guest = Guest::create([
            'team_id'        => $team->id,
            'full_name'      => 'John Doe',
            'nationality'    => 'US',
            'type' => 'foreign'
        ]);

        $newguest = Guest::create([
            'team_id'        => $team->id,
            'full_name'      => 'Mark Smith',
            'nationality'    => 'US',
            'type' => 'foreign'
        ]);

        // ── 3. Create Booking and BookingRoom 10–15 July 2025 ─
        $booking = Booking::create([
            'team_id' => $team->id,
            'status'  => 'reserved',
        ]);
        $booking->guests()->attach($guest);

        BookingRoom::create([
            'booking_id' => $booking->id,
            'room_id'    => $room->id,
            'check_in'   => '2025-07-10',
            'check_out'  => '2025-07-15',
            'status'     => 'reserved',
        ]);

        $newbooking = Booking::create([
            'team_id' => $team->id,
            'status'  => 'reserved',
        ]);
        $newbooking->guests()->attach($newguest);

        BookingRoom::create([
            'booking_id' => $newbooking->id,
            'room_id'    => $room->id,
            'check_in'   => '2025-08-10',
            'check_out'  => '2025-08-15',
            'status'     => 'reserved',
        ]);


        // ── 4. Livewire test sequence ──────────────────────
        Livewire::test(CalendarIndex::class)
            // force calendar to July 2025
            ->set('month', '2025-07')
            ->assertSee('John Doe')
            ->assertDontSee('Mark Smith')  // booking bar rendered
            ->call('nextMonth')               // ► August 2025
            ->assertDontSee('John Doe')       // bar disappears
            ->assertSee('Mark Smith')
            ->call('prevMonth')               // ◄ back to July
            ->assertSee('John Doe')         // bar visible again
            ->assertDontSee('Mark Smith');
    }
}
