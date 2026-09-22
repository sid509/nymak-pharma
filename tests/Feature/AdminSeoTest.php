<?php

namespace Tests\Feature;

use App\Models\Market;
use App\Models\TeamMember;
use App\Models\PageMeta;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminSeoTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    #[Test]
    public function page_meta_override_replaces_public_title_and_description(): void
    {
        PageMeta::create([
            'key' => 'products.index',
            'meta_title' => 'Custom Product Page Title',
            'meta_description' => 'A custom description for the products index.',
        ]);

        $response = $this->get('/products')->assertOk();
        $response->assertSee('<title>Custom Product Page Title | Nymak Pharma</title>', false);
        $response->assertSee('A custom description for the products index.', false);
    }

    #[Test]
    public function empty_page_meta_falls_back_to_defaults(): void
    {
        PageMeta::create(['key' => 'home']); // row exists, fields null

        $this->get('/')->assertOk()
            ->assertSee('Pharmaceutical Manufacturer', false);
    }

    #[Test]
    public function seo_pages_admin_lists_known_pages_and_saves(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->get('/admin/seo-pages')
            ->assertOk()
            ->assertInertia(fn ($p) => $p->component('Admin/Seo/Index')->has('pages', count(PageMeta::PAGES)));

        $meta = PageMeta::where('key', 'home')->firstOrFail();
        $this->actingAs($admin)->put("/admin/seo-pages/{$meta->id}", [
            'meta_title' => 'Overridden Home Title',
            'meta_description' => 'Overridden home description.',
        ])->assertRedirect('/admin/seo-pages');

        $this->assertEquals('Overridden Home Title', $meta->fresh()->meta_title);
        $this->get('/')->assertSee('Overridden Home Title', false);
    }

    #[Test]
    public function seo_page_og_image_uploads(): void
    {
        $admin = User::factory()->create();
        $this->actingAs($admin)->get('/admin/seo-pages'); // materialize rows
        $meta = PageMeta::where('key', 'about')->firstOrFail();

        $this->actingAs($admin)->put("/admin/seo-pages/{$meta->id}", [
            'meta_title' => 'About override',
            'og_image' => UploadedFile::fake()->image('og.png', 1200, 630),
        ]);

        $path = $meta->fresh()->og_image;
        $this->assertStringStartsWith('images/og/', $path);
        $this->assertFileExists(public_path($path));
        unlink(public_path($path));
    }

    #[Test]
    public function team_member_meta_fields_drive_public_profile(): void
    {
        $admin = User::factory()->create();
        $member = TeamMember::whereNotNull('bio')->firstOrFail();

        $this->actingAs($admin)->put("/admin/team-members/{$member->id}", [
            'name' => $member->name,
            'slug' => $member->slug,
            'role' => $member->role,
            'bio' => $member->bio,
            'meta_title' => 'Custom profile title',
            'meta_description' => 'Custom profile description.',
        ])->assertRedirect();

        $this->get("/team/{$member->slug}")
            ->assertSee('Custom profile title', false)
            ->assertSee('Custom profile description.', false);
    }

    #[Test]
    public function post_cover_image_uploads_and_serves_in_schema(): void
    {
        $admin = User::factory()->create();
        $post = \App\Models\Post::firstOrFail();

        $this->actingAs($admin)->put("/admin/posts/{$post->slug}", [
            'title' => $post->title,
            'slug' => $post->slug,
            'cover_image' => UploadedFile::fake()->image('cover.jpg', 1200, 630),
        ]);

        $cover = $post->fresh()->cover_image;
        $this->assertStringStartsWith('images/covers/', $cover);
        $this->assertFileExists(public_path($cover));

        // Article schema exposes the cover image.
        $this->get("/blog/{$post->slug}")->assertSee(url($cover), false);

        unlink(public_path($cover));
    }
}
