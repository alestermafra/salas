<?php

namespace Tests\Feature\API\v1\status;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetTest extends TestCase
{
    public function testStatusApiEndpointShouldReturn_200(): void
    {
        $response = $this->getJson(route('api.v1.status'))
            ->assertStatus(200)
            ->assertJsonStructure([
                "updated_at",
                "mysql" => [
                    "version",
                    "max_connections",
                    "threads_connected"
                ]
            ]);

        $decodedJson = $response->decodeResponseJson()->json();
        $parsedUpdatedAt = Carbon::create($decodedJson["updated_at"])->toISOString();
        $this->assertTrue($parsedUpdatedAt === $decodedJson["updated_at"]);
        $this->assertTrue($decodedJson["mysql"]["version"] === "8.0.40");
        $this->assertTrue($decodedJson["mysql"]["max_connections"] === 151);
        $this->assertTrue($decodedJson["mysql"]["threads_connected"] === 1);
    }
}
