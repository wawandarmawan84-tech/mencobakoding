<?php

namespace Tests\Feature;

use Tests\TestCase;

class LayoutTest extends TestCase
{
    public function test_dashboard_layout_has_mobile_sidebar_toggle_and_overlay(): void
    {
        $response = $this->get('/dashboard');

        $response->assertOk();
        $response->assertSee('data-sidebar-toggle', false);
        $response->assertSee('data-sidebar-overlay', false);
    }
}
