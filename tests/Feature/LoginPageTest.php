<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginPageTest extends TestCase
{
    public function test_halaman_login_dapat_diakses_dengan_form_yang_lengkap(): void
    {
        $response = $this->get('/login');

        $response->assertOk();

        $html = (string) $response->getContent();

        $this->assertStringContainsString('action="'.route('login.attempt').'"', $html);
        $this->assertStringContainsString('name="_token"', $html);
        $this->assertStringContainsString('name="email"', $html);
        $this->assertStringContainsString('name="password"', $html);
        $this->assertStringContainsString('name="remember"', $html);
        $this->assertStringContainsString('autocomplete="username"', $html);
        $this->assertStringContainsString('autocomplete="current-password"', $html);
        $this->assertStringContainsString('Masuk ke Datanet', $html);
        $this->assertStringContainsString('>Masuk</span>', $html);
    }

    public function test_halaman_login_memakai_tema_indigo_violet_fuchsia(): void
    {
        $html = (string) $this->get('/login')->getContent();

        $this->assertStringContainsString('from-indigo-600', $html);
        $this->assertStringContainsString('via-violet-600', $html);
        $this->assertStringContainsString('to-fuchsia-500', $html);
        $this->assertStringContainsString('content="#4f46e5"', $html);

        $this->assertStringNotContainsString('#1b2d4a', $html);
        $this->assertStringNotContainsString('#f68b1e', $html);
    }
}
