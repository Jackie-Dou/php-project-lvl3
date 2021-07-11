<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlCheckTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private $id;

    protected function setUp(): void
    {
        parent::setUp();

        $url = [
            'name' => 'https://test.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $this->id = DB::table('urls')->insertGetId($url);
    }

    public function testStore()
    {
        Http::fake(function () {
            $body = '<h1>Hello, from test!</h1>
            <meta name="description" content="The most popular HTML, CSS, and JS library in the world.">
            <meta name="keywords" content="HTML, CSS, JS, library">';

            return Http::response($body, 200);
        });

        $response = $this->post(route('url_checks.store', [$this->id]));
        $response->assertSessionHasNoErrors();
        // $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', [
            'url_id'   => $this->id,
            'h1'          => 'Hello, world!',
            'keywords'    => 'key,key1,key2,key3',
            'description' => 'website description',
            'status_code' => 200
        ]);
    }
}
