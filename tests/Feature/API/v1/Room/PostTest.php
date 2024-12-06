<?php

namespace Tests\Feature\API\v1\Room;

use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testRoomCreation(): void
    {
        $data = [
            'room' => 'Sala 53'
        ];

        $response = $this->post(route('api.v1.rooms.store', $data, ['Accept' => 'application/json']));
        $parsedData = $response->getData();

        $response->assertCreated() // 201
            ->assertExactJson([
                'id' => $parsedData->id,
                'room' => $data['room'],
                'created_at' => $parsedData->created_at,
                'updated_at' => $parsedData->updated_at
            ]);
    }

    public function testRoomCreationWithoutRequiredValues(): void
    {
        $response = $this->post(route('api.v1.rooms.store'), [], ['Accept' => 'application/json']);

        $response->assertUnprocessable() // 422
            ->assertInvalid(['room']);
    }

    public function testRoomEditing(): void
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

    public function testRoomEditingWithoutRequiredValues(): void
    {
        $room = Room::factory()->create();
        $data = [];

        $response = $this->putJson(route('api.v1.rooms.update', $room), $data);

        $response->assertUnprocessable()
            ->assertInvalid(['room']);
    }
}
