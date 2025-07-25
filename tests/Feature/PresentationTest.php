<?php

namespace Tests\Feature;

use App\Models\PresentationCompletion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PresentationTest extends TestCase
{
    use RefreshDatabase;

    public function test_presentation_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('presentation')
            ->has('completionCount')
        );
    }

    public function test_presentation_shows_completion_count(): void
    {
        // Create some completed presentations
        PresentationCompletion::factory()->count(5)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->where('completionCount', 5)
        );
    }

    public function test_presentation_completion_is_tracked(): void
    {
        $sessionId = 'test-session-123';

        $response = $this->post('/presentation/complete', [
            'session_id' => $sessionId,
        ]);

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('presentation_completions', [
            'session_id' => $sessionId,
        ]);
    }

    public function test_duplicate_completion_is_not_created(): void
    {
        $sessionId = 'test-session-123';

        // First completion
        $this->post('/presentation/complete', [
            'session_id' => $sessionId,
        ]);

        // Second completion with same session
        $this->post('/presentation/complete', [
            'session_id' => $sessionId,
        ]);

        // Should only have one completion
        $this->assertEquals(1, PresentationCompletion::where('session_id', $sessionId)->count());
    }

    public function test_completion_requires_session_id(): void
    {
        $response = $this->post('/presentation/complete', []);

        $response->assertSessionHasErrors(['session_id']);
    }

    public function test_completion_count_updates_after_completion(): void
    {
        // Initial count should be 0
        $response = $this->get('/');
        $response->assertInertia(fn ($page) => $page->where('completionCount', 0));

        // Complete a presentation
        $this->post('/presentation/complete', [
            'session_id' => 'test-session-123',
        ]);

        // Count should be updated
        $response = $this->get('/');
        $response->assertInertia(fn ($page) => $page->where('completionCount', 1));
    }
}