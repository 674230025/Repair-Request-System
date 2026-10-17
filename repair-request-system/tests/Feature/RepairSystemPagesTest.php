<?php

namespace Tests\Feature;

use Tests\TestCase;

class RepairSystemPagesTest extends TestCase
{
    public function test_homepage_redirects_to_login_when_guest(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_login_page_is_available(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('เข้าสู่ระบบ');
    }

    public function test_registration_page_is_available(): void
    {
        $response = $this->get('/register');

        $response->assertOk();
        $response->assertSee('สมัครสมาชิก');
    }
}
