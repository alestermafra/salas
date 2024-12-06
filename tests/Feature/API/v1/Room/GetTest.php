<?php

namespace Tests\Feature\API\v1\Room;

use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetTest extends TestCase
{
    use RefreshDatabase;

    public function testApiV1RoomsEndpointWithNoRooms(): void
    {
        $response = $this->get(route('api.v1.rooms.index'));

        $response->assertStatus(200)
            ->assertJsonIsArray()
            ->assertJsonCount(0);
    }

    public function testApiV1RoomsEndpointWith_2Rooms(): void
    {
        $room1 = Room::factory()->create();
        $room2 = Room::factory()->create();

        $response = $this->get(route('api.v1.rooms.index'));

        $response->assertStatus(200)
            ->assertJsonIsArray()
            ->assertJsonCount(2)
            ->assertExactJson([
                [
                    "id" => $room1->id,
                    "room" => $room1->room,
                    "created_at" => $room1->created_at,
                    "updated_at" => $room1->updated_at
                ],
                [
                    "id" => $room2->id,
                    "room" => $room2->room,
                    "created_at" => $room2->created_at,
                    "updated_at" => $room2->updated_at
                ],
            ]);
    }

    public function testApiV1RoomsEndpointWith_30Rooms(): void
    {
        Room::factory(30)->create();

        $response = $this->get(route('api.v1.rooms.index'));

        $response->assertStatus(200)
            ->assertJsonIsArray()
            ->assertJsonCount(30);
    }
}
