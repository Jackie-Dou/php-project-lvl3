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
    private $data;
    private const URL_NAME = "https://google.ru";

    protected function setUp(): void
    {
        parent::setUp();
        $this->data = [
            'name' => self::URL_NAME,
        ];
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertSee('Urls List');
        $response->assertOk();
    }

//    public function testStore()
//    {
//        $response = $this->post(route('urls.store'), $this->data);
//        $response->assertSessionHasNoErrors();
//        $this->assertDatabaseHas('urls', $this->data);
//    }

    public function testShow()
    {
        $id = DB::table('urls')->insertGetId($this->data);
        $this->assertDatabaseHas('urls', $this->data);
        $response = $this->get(route('urls.show', $id));
        $response->assertOk();
    }
}
