<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_profile_and_both_projects(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Imran Hasan')
            ->assertSee('IBL CART 24')
            ->assertSee('Image Caption Generator')
            ->assertSee('application/ld+json', false);
    }

    public function test_each_project_has_a_case_study_page(): void
    {
        foreach (config('portfolio.projects') as $project) {
            $this->get('/projects/' . $project['slug'])
                ->assertOk()
                ->assertSee($project['title']);
        }
    }

    public function test_unknown_project_is_404(): void
    {
        $this->get('/projects/does-not-exist')->assertNotFound();
    }

    public function test_cv_route_redirects_to_the_pdf(): void
    {
        $this->get('/cv')->assertRedirect(config('portfolio.profile.cv'));
    }

    public function test_contact_form_stores_a_message(): void
    {
        $this->post('/contact', [
            'name'    => 'Test Visitor',
            'email'   => 'visitor@example.com',
            'type'    => 'freelance',
            'message' => 'I would like a Laravel store for my business in Dhaka.',
        ])->assertRedirect(route('home') . '#contact')->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'visitor@example.com',
            'type'  => 'freelance',
        ]);
    }

    public function test_contact_form_validates_input(): void
    {
        $this->from('/')->post('/contact', [
            'name'    => '',
            'email'   => 'not-an-email',
            'type'    => 'invalid',
            'message' => 'short',
        ])->assertSessionHasErrors(['name', 'email', 'type', 'message']);

        $this->assertSame(0, ContactMessage::count());
    }

    public function test_honeypot_blocks_bots(): void
    {
        $this->post('/contact', [
            'name'    => 'Bot',
            'email'   => 'bot@example.com',
            'type'    => 'other',
            'message' => 'This is an automated message that is long enough.',
            'website' => 'http://spam.example',
        ])->assertSessionHasErrors('website');

        $this->assertSame(0, ContactMessage::count());
    }
}
