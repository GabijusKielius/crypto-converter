<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    /** @test */
    public function test_welcome_page_returns_status_200()
    {
        $this->get('/')->assertStatus(200);
    }

    /** @test */
    public function welcome_page_displays_welcome_component()
    {
        $response = $this->get('/');

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Welcome')
                ->has('laravelVersion')
                ->has('phpVersion')
                ->where('laravelVersion', app()->version())
                ->where('phpVersion', PHP_VERSION);
        });
    }
}
