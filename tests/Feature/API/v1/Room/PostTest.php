<?php

namespace Tests\Feature\API\v1\Room;

use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatesRoomSuccessfully(): void
    {
        $data = [
            'room' => 'Sala 53'
        ];

        $response = $this->postJson(route('api.v1.rooms.store', $data, ['Accept' => 'application/json']));
        $parsedData = $response->getData();

        $response->assertCreated() // 201
            ->assertExactJson([
                'id' => $parsedData->id,
                'room' => $data['room'],
                'created_at' => $parsedData->created_at,
                'updated_at' => $parsedData->updated_at
            ]);
    }

    public function testFailsToCreateRoomWithoutRequiredValues(): void
    {
        $response = $this->postJson(route('api.v1.rooms.store'), [], ['Accept' => 'application/json']);

        $response->assertUnprocessable() // 422
            ->assertInvalid(['room']);
    }

    public function testUpdatesRoomSuccessfully(): void
    {
        $room = Room::factory()->create();
        $data = ['room' => 'Sala Ceres'];

        $response = $this->putJson(route('api.v1.rooms.update', $room), $data);

        $response->assertSuccessful()
            ->assertExactJson([
                'id' => $room->id,
                'room' => $data['room'],
                'created_at' => $room->created_at,
                'updated_at' => $room->updated_at,
            ]);
    }

    public function testFailsToUpdateRoomWithInvalidData(): void
    {
        $room = Room::factory()->create();
        $data = [];

        $response = $this->putJson(route('api.v1.rooms.update', $room), $data);

        $response->assertUnprocessable()
            ->assertInvalid(['room']);
    }

    public function testFailsToUpdateNonExistentRoom(): void
    {
        $roomId = 999;
        $data = ['room' => 'Sala Ceres'];

        $response = $this->putJson(route('api.v1.rooms.update', $roomId), $data);

        $response->assertNotFound();
    }

    public function testDeletesRoomSuccessfully(): void
    {
        $room = Room::factory()->create();

        $this->assertDatabaseHas('rooms', ['id' => $room->id]);
        $this->deleteJson(route('api.v1.rooms.destroy', $room))
            ->assertSuccessful();
        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }

    public function testFailsToDeleteNonExistentRoom(): void
    {
        $roomId = 999;

        $response = $this->deleteJson(route('api.v1.rooms.destroy', $roomId))
            ->assertNotFound();
    }
}
