<?php

namespace Tests\Feature\FanPage;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FanPageTest extends TestCase
{
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function a_user_can_visit_site()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
