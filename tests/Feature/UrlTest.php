<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

class UrlTest extends TestCase
{

    public function testWelcomePage()
    {
        $response = $this->get(route('home'));
        $response->assertSee('Home Page');
        $response->assertOk();
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertSee('Urls List');
        $response->assertOk();
    }

//    private $domainId;
//
//    const DOMAIN_NAME = 'https://google.ru';
//    const PAGE_TITLE  = 'Page Analyzer';
//
//    protected function setUp(): void
//    {
//        parent::setUp();
//        $data           = [
//            'name'       => self::DOMAIN_NAME,
//            'created_at' => Carbon::now()
//        ];
//        $this->domainId = DB::table('domains')->insertGetId($data);
//    }
//
//    public function testRoot()
//    {
//        $response = $this->get(route('root'));
//        $response->assertSee(self::PAGE_TITLE);
//        $response->assertOk();
//    }
//
//    public function testIndex()
//    {
//        $response = $this->get(route('domains.index'));
//        $response->assertSee(self::DOMAIN_NAME);
//        $response->assertOk();
//    }
//
//    public function testStore()
//    {
//        $data     = [
//            'name' => self::DOMAIN_NAME
//        ];
//        $response = $this->post(route('domains.store'), $data);
//        $response->assertSessionHasNoErrors();
//        $response->assertRedirect();
//        $this->assertDatabaseHas('domains', $data);
//    }
//
//    public function testShow()
//    {
//        $response = $this->get(route('domains.show', $this->domainId));
//        $response->assertSee(self::DOMAIN_NAME);
//        $response->assertOk();
//    }
}
