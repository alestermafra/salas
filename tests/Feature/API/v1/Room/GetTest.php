<?php

namespace Tests\Feature\API\v1\Room;

use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnsEmptyListWhenNoRoomsExist(): void
    {
        $this->getJson(route('api.v1.rooms.index'))
            ->assertSuccessful()
            ->assertJsonIsArray()
            ->assertJsonCount(0);
    }

    public function testReturnsListWithTwoRooms(): void
    {
        $room1 = Room::factory()->create();
        $room2 = Room::factory()->create();

        $this->getJson(route('api.v1.rooms.index'))
            ->assertSuccessful(200)
            ->assertJsonIsArray()
            ->assertJsonCount(2)
            ->assertExactJson([
                [
                    'id' => $room1->id,
                    'room' => $room1->room,
                    'created_at' => $room1->created_at,
                    'updated_at' => $room1->updated_at
                ],
                [
                    'id' => $room2->id,
                    'room' => $room2->room,
                    'created_at' => $room2->created_at,
                    'updated_at' => $room2->updated_at
                ],
            ]);
    }

    public function testReturnsListWithThirtyRooms(): void
    {
        Room::factory(30)->create();

        $this->getJson(route('api.v1.rooms.index'))
            ->assertSuccessful()
            ->assertJsonIsArray()
            ->assertJsonCount(30);
    }

    public function testReturnsRoomDetailsForExistingRoom(): void
    {
        $room = Room::factory()->create();

        $this->getJson(route('api.v1.rooms.show', $room))
            ->assertSuccessful()
            ->assertExactJson([
                'id' => $room->id,
                'room' => $room->room,
                'created_at' => $room->created_at->toISOString(),
                'updated_at' => $room->updated_at->toISOString()
            ]);
    }

    public function testFailsToShowNonExistentRoom(): void
    {
        $nonExistingRoomId = 999;

        $this->getJson(route('api.v1.rooms.show', $nonExistingRoomId))
            ->assertNotFound();
    }
}
