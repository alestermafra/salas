<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    public function testStatusEndpointReturningHealthData(): void
    {
        $response = $this->getJson('/status')
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
        //$this->assertTrue($decodedJson["mysql"]["max_connections"] === 151);
        //$this->assertTrue($decodedJson["mysql"]["threads_connected"] === 1);
    }
}