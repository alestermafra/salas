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
            ->assertSuccessful();

        $parsedData = $response->getData();
        $parsedUpdatedAt = Carbon::create($parsedData->updated_at);

        $response->assertExactJson([
            'updated_at' => $parsedUpdatedAt,
            'mysql' => [
                'version' => '8.0.40',
                'max_connections' => 151,
                'threads_connected' => 1
            ]
        ]);
    }
}
