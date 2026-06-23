<?php

namespace Tests\Feature;

use Tests\TestCase;

class SmokeTest extends TestCase
{
    public function test_home_redirects_to_projects(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/projects');
    }
}
