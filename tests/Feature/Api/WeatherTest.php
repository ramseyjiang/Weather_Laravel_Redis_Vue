<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class WeatherTest extends TestCase
{
    /**
     * Test for input city exists
     *
     * @return void
     */
    public function testWeatherSuccess()
    {
        $this->call('get', '/api/weather/city/' . 'Auckland')
        ->assertStatus(Response::HTTP_OK)
        ->assertJson([ 'status' => Response::HTTP_OK])
        ->assertJsonStructure([ 
            'status', 'data' => ['city', 'country', 'list']
        ]);
    }

    /**
     * Test for input city does not exist
     *
     * @return void
     */
    public function testWeatherFail()
    {
        $this->call('get', '/api/weather/city/' . 'sss')
        ->assertStatus(Response::HTTP_OK)
        ->assertJson([ 
            'status' => Response::HTTP_NOT_FOUND,
            'message' => 'city not found',
        ]);
    }
}
