<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminUIComponentsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un utilisateur administrateur
        $this->admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
    }

    /** @test */
    public function admin_layout_includes_notification_component()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('id="notification-container"', false);
    }

    /** @test */
    public function admin_layout_includes_confirm_modal_component()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('id="confirm-modal"', false);
    }

    /** @test */
    public function admin_layout_includes_loading_component()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('id="loading-overlay"', false);
    }

    /** @test */
    public function flash_messages_trigger_notifications()
    {
        $response = $this->actingAs($this->admin)
                         ->withSession(['success' => 'Test de notification réussi'])
                         ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('showNotification(', false);
        $response->assertSee('Test de notification réussi', false);
    }

    /** @test */
    public function data_table_component_renders_correctly()
    {
        $view = $this->blade(
            '@include("admin.components.data-table", ["title" => "Test Table", "search" => true])',
            ['title' => 'Test Table', 'search' => true]
        );

        $view->assertSee('Test Table');
        $view->assertSee('table-search');
        $view->assertSee('Aucune donnée disponible');
    }

    /** @test */
    public function confirm_modal_component_renders_correctly()
    {
        $view = $this->blade('@include("admin.components.confirm-modal")');

        $view->assertSee('confirm-modal');
        $view->assertSee('Confirmer');
        $view->assertSee('Annuler');
    }

    /** @test */
    public function notification_component_renders_correctly()
    {
        $view = $this->blade('@include("admin.components.notification")');

        $view->assertSee('notification-container');
    }

    /** @test */
    public function loading_component_renders_correctly()
    {
        $view = $this->blade('@include("admin.components.loading")');

        $view->assertSee('loading-overlay');
        $view->assertSee('Chargement en cours');
    }
}