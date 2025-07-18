<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected int $teamId = 1;   // <-- hard-coded team

    public function run(): void
    {
        // ───── Helper closure ─────
        $makeRooms = function (RoomType $type, array $numbers) {
            foreach ($numbers as $num) {
                Room::firstOrCreate(
                    ['room_number' => $num, 'team_id' => $this->teamId],
                    [
                        'room_type_id' => $type->id,
                        'status'       => 'available',
                        'team_id'      => $this->teamId,
                    ]
                );
            }
        };

        // 1️⃣  Deluxe Double – Balcony & Sea View  (8 rooms)
        $seaView = RoomType::firstOrCreate(
            ['team_id' => $this->teamId, 'name' => 'Deluxe Double Room With Balcony and Sea View'],
            ['base_price' => 250, 'description' => 'Deluxe double, balcony, sea view']
        );
        $makeRooms($seaView, [101, 102, 103, 104, 201, 202, 203, 204]);

        // 2️⃣  Deluxe Double – Balcony  (2 rooms)
        $deluxeBalcony = RoomType::firstOrCreate(
            ['team_id' => $this->teamId, 'name' => 'Deluxe Double Room With Balcony'],
            ['base_price' => 230, 'description' => 'Deluxe double, balcony']
        );
        $makeRooms($deluxeBalcony, [105, 205]);

        // 3️⃣  Deluxe Triple – Balcony & City View  (2 rooms)
        $tripleCity = RoomType::firstOrCreate(
            ['team_id' => $this->teamId, 'name' => 'Deluxe Triple Room With Balcony and City View'],
            ['base_price' => 280, 'description' => 'Deluxe triple, balcony, city view']
        );
        $makeRooms($tripleCity, [106, 206]);

        // 4️⃣  Standard Double  (2 rooms)
        $standard = RoomType::firstOrCreate(
            ['team_id' => $this->teamId, 'name' => 'Standard Double Room'],
            ['base_price' => 180, 'description' => 'Standard double']
        );
        $makeRooms($standard, [107, 207]);
    }
}
