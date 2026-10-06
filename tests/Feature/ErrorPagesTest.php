<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * HTTP errors must render the branded Inertia `Error` page — never the
 * framework's default grey Symfony page. JSON/API callers still get JSON.
 */
class ErrorPagesTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private function abortingRoute(int $status): string
    {
        Route::get("/__test-abort-{$status}", fn () => abort($status));

        return "/__test-abort-{$status}";
    }

    private function assertBrandedError($response, int $status, string $text): void
    {
        $response->assertStatus($status)
            ->assertSee('"component":"Error"', false)
            ->assertSee('"status":'.$status, false)
            ->assertSee('content="noindex"', false)
            ->assertSee($text);
    }

    #[Test]
    public function missing_page_renders_branded_404(): void
    {
        $this->assertBrandedError($this->get('/this-page-does-not-exist'), 404, 'Page not found');
    }

    #[Test]
    public function forbidden_renders_branded_403(): void
    {
        $this->assertBrandedError($this->get($this->abortingRoute(403)), 403, 'Access restricted');
    }

    #[Test]
    public function expired_session_renders_branded_419(): void
    {
        $this->assertBrandedError($this->get($this->abortingRoute(419)), 419, 'Session expired');
    }

    #[Test]
    public function throttled_renders_branded_429(): void
    {
        $this->assertBrandedError($this->get($this->abortingRoute(429)), 429, 'Too many requests');
    }

    #[Test]
    public function server_error_renders_branded_500(): void
    {
        $this->assertBrandedError($this->get($this->abortingRoute(500)), 500, 'Something went wrong');
    }

    #[Test]
    public function unhandled_error_statuses_fall_back_to_branded_blade(): void
    {
        // 500s from non-HTTP exceptions (or when Inertia render fails, e.g. DB down)
        // must still be branded — the errors/500.blade.php self-contained fallback.
        config(['app.debug' => false]);
        Route::get('/__test-boom', fn () => throw new \RuntimeException('boom'));

        $response = $this->get('/__test-boom');
        $response->assertStatus(500)
            ->assertSee('Nymak Pharma', false)
            ->assertSee('Something went wrong');
    }

    #[Test]
    public function json_requests_still_get_json_errors(): void
    {
        $response = $this->getJson('/this-page-does-not-exist');
        $response->assertStatus(404)->assertJsonStructure(['message']);
        $this->assertStringNotContainsString('<!DOCTYPE', $response->getContent());
    }
}
