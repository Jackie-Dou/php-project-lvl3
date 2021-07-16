<?php

namespace Tests\Feature;

use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Carbon\Carbon;

class UrlTest extends TestCase
{
    private array $data;
    private const URL_NAME = "https://google.ru";

    protected function setUp(): void
    {
        parent::setUp();
        $this->data = ['url' => ['name' => 'http://google.com']];
    }

    public function testIndex(): void
    {
        $response = $this->get(route('urls.index'));
        $response->assertSee('Urls List');
        $response->assertOk();
    }

    public function testStore(): void
    {
        $response = $this->post(route('urls.store'), $this->data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('urls', $this->data['url']);
    }

    public function testShow(): void
    {
        $id = DB::table('urls')->insertGetId($this->data['url']);
        $this->assertDatabaseHas('urls', $this->data['url']);
        $response = $this->get(route('urls.show', $id));
        $response->assertOk();
    }
}
