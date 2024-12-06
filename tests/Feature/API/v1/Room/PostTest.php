<?php

namespace Tests\Feature\API\v1\Room;

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
}
