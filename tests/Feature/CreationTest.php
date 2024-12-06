<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreationTest extends TestCase
{
    use RefreshDatabase;

    public function testRoomPersistsInDatabase(): void
    {
        $data = ['room' => 'Meeting room'];
        $room = Room::factory()->create($data);

        $this->assertDatabaseHas('rooms', $data);
    }

    public function testReservationPersistsInDatabase(): void
    {
        $room = Room::factory()->create();
        $data = [
            'room_id' => $room->id,
            'description' => 'Team meeting'
        ];
        Reservation::factory()->create($data);

        $this->assertDatabaseHas('reservations', $data);
    }

    public function testRoomRelationshipWithMultiplesReservations()
    {
        $room = Room::factory()->hasReservations(3)->create();

        $this->assertCount(3, $room->reservations);
    }

    public function testReservationBelongsToARoom()
    {
        $room = Room::factory()->create();
        $reservation = Reservation::factory()->create(['room_id' => $room->id]);

        $this->assertEquals($room->id, $reservation->room->id);
    }
}
