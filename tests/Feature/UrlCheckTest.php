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
    private $body;

    protected function setUp(): void
    {
        parent::setUp();

        $this->body = '<h1>Hello, from test!</h1>
            <meta name="description" content="The most popular HTML, CSS, and JS library in the world.">
            <meta name="keywords" content="HTML, CSS, JS, library">';
        $url = [
            'name' => 'https://test.com',
        ];
        $this->id = DB::table('urls')->insertGetId($url);
    }

    public function testStore()
    {
        Http::fake(function () {
            return Http::response($this->body, 200);
        });

        $response = $this->post(route('url_checks.store', [$this->id]));

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('url_checks', [
            'url_id'   => $this->id,
            'h1' => 'Hello, from test!',
            'keywords' => 'HTML, CSS, JS, library',
            'description' => 'The most popular HTML, CSS, and JS library in the world.',
            'status_code' => 200
        ]);
    }
}
