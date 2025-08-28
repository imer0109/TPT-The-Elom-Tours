<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Review;
use App\Models\Circuit;
use App\Models\Destination;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
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
    public function admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function admin_can_view_reviews_list()
    {
        // Créer quelques avis pour les tests
        $circuit = Circuit::factory()->create();
        $reviews = Review::factory()->count(3)->create([
            'circuit_id' => $circuit->id,
        ]);

        $response = $this->actingAs($this->admin)
                         ->get(route('admin.reviews.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.reviews.index');
        $response->assertViewHas('reviews');
    }

    /** @test */
    public function admin_can_approve_review()
    {
        // Créer un avis non approuvé
        $circuit = Circuit::factory()->create();
        $review = Review::factory()->create([
            'circuit_id' => $circuit->id,
            'is_approved' => false,
        ]);

        $response = $this->actingAs($this->admin)
                         ->post(route('admin.reviews.toggle-approval', $review));

        $response->assertRedirect(route('admin.reviews.index'));
        $this->assertTrue(Review::find($review->id)->is_approved);
    }

    /** @test */
    public function admin_can_edit_review()
    {
        // Créer un avis
        $circuit = Circuit::factory()->create();
        $review = Review::factory()->create([
            'circuit_id' => $circuit->id,
        ]);

        $response = $this->actingAs($this->admin)
                         ->get(route('admin.reviews.edit', $review));

        $response->assertStatus(200);
        $response->assertViewIs('admin.reviews.edit');
        $response->assertViewHas('review');
    }

    /** @test */
    public function admin_can_update_review()
    {
        // Créer un avis
        $circuit = Circuit::factory()->create();
        $review = Review::factory()->create([
            'circuit_id' => $circuit->id,
            'comment' => 'Ancien commentaire',
        ]);

        $updatedData = [
            'name' => 'Nom Mis à Jour',
            'email' => 'email@example.com',
            'rating' => 5,
            'comment' => 'Nouveau commentaire',
            'is_approved' => true,
        ];

        $response = $this->actingAs($this->admin)
                         ->put(route('admin.reviews.update', $review), $updatedData);

        $response->assertRedirect(route('admin.reviews.edit', $review));
        $this->assertEquals('Nouveau commentaire', Review::find($review->id)->comment);
    }

    /** @test */
    public function admin_can_delete_review()
    {
        // Créer un avis
        $circuit = Circuit::factory()->create();
        $review = Review::factory()->create([
            'circuit_id' => $circuit->id,
        ]);

        $response = $this->actingAs($this->admin)
                         ->delete(route('admin.reviews.destroy', $review));

        $response->assertRedirect(route('admin.reviews.index'));
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }

    /** @test */
    public function admin_can_view_destinations_list()
    {
        // Créer quelques destinations pour les tests
        $destinations = Destination::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
                         ->get(route('admin.destinations.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.destinations.index');
        $response->assertViewHas('destinations');
    }

    /** @test */
    public function admin_can_create_destination()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.destinations.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.destinations.create');
    }

    /** @test */
    public function admin_can_store_destination()
    {
        $destinationData = [
            'name' => 'Paris',
            'country' => 'France',
            'city' => 'Paris',
            'description' => 'La ville lumière',
            'is_active' => true,
            'is_popular' => true,
            'meta_title' => 'Visiter Paris',
            'meta_description' => 'Découvrez Paris, la ville lumière',
            'meta_keywords' => 'paris, france, tour eiffel',
        ];

        $response = $this->actingAs($this->admin)
                         ->post(route('admin.destinations.store'), $destinationData);

        $response->assertRedirect(route('admin.destinations.index'));
        $this->assertDatabaseHas('destinations', ['name' => 'Paris']);
    }

    /** @test */
    public function admin_can_edit_destination()
    {
        $destination = Destination::factory()->create();

        $response = $this->actingAs($this->admin)
                         ->get(route('admin.destinations.edit', $destination));

        $response->assertStatus(200);
        $response->assertViewIs('admin.destinations.edit');
        $response->assertViewHas('destination');
    }

    /** @test */
    public function admin_can_update_destination()
    {
        $destination = Destination::factory()->create([
            'name' => 'Ancien Nom',
            'description' => 'Ancienne description',
        ]);

        $updatedData = [
            'name' => 'Nouveau Nom',
            'country' => $destination->country,
            'city' => $destination->city,
            'description' => 'Nouvelle description',
            'is_active' => true,
            'is_popular' => true,
        ];

        $response = $this->actingAs($this->admin)
                         ->put(route('admin.destinations.update', $destination), $updatedData);

        $response->assertRedirect(route('admin.destinations.index'));
        $this->assertEquals('Nouveau Nom', Destination::find($destination->id)->name);
    }

    /** @test */
    public function admin_can_delete_destination()
    {
        $destination = Destination::factory()->create();

        $response = $this->actingAs($this->admin)
                         ->delete(route('admin.destinations.destroy', $destination));

        $response->assertRedirect(route('admin.destinations.index'));
        $this->assertDatabaseMissing('destinations', ['id' => $destination->id]);
    }
}