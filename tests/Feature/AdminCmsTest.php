<?php

namespace Tests\Feature;

use App\Models\ClientLogo;
use App\Models\PageContent;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCmsTest extends TestCase
{
    use RefreshDatabase;

    // migrate:fresh --seed is decided by the first test class in the run —
    // every suite in this project must declare $seed or it starves the rest.
    protected $seed = true;

    private function admin(): User
    {
        return User::factory()->create();
    }

    public function test_page_content_index_lists_editable_pages(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/pages')
            ->assertOk()
            ->assertInertia(fn ($p) => $p->component('Admin/Pages/Index')
                ->has('pages', count(PageContent::PAGE_LABELS)));
    }

    public function test_page_content_edit_renders_fields_and_resolved_values(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/pages/home/edit')
            ->assertOk()
            ->assertInertia(fn ($p) => $p->component('Admin/Pages/Form')
                ->has('fields')
                ->where('values.hero_title', '25+ years of Efficacy-Driven lifecare'));
    }

    public function test_page_content_update_overrides_public_page(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->put('/admin/pages/home', [
            'hero_title' => 'Custom headline from admin',
        ])->assertRedirect();

        $this->get('/')
            ->assertOk()
            ->assertSee('Custom headline from admin', false);
    }

    public function test_blank_page_content_restores_default(): void
    {
        PageContent::create(['page' => 'home', 'key' => 'hero_title', 'value' => 'Override']);

        $this->actingAs($this->admin())->put('/admin/pages/home', [
            'hero_title' => '',
        ]);

        $this->get('/')->assertSee('25+ years of Efficacy-Driven lifecare', false);
    }

    public function test_page_content_json_field_validates_and_renders(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->put('/admin/pages/about', [
            'timeline' => 'not-json{',
        ])->assertSessionHasErrors('timeline');

        $this->actingAs($admin)->put('/admin/pages/about', [
            'timeline' => json_encode([['year' => '1998', 'title' => 'T', 'text' => 'X']]),
        ])->assertRedirect();

        $this->get('/about')->assertOk()->assertSee('X');
    }

    public function test_page_content_image_slot_uploads_webp(): void
    {
        $this->actingAs($this->admin())->put('/admin/pages/home', [
            'hero_image' => UploadedFile::fake()->image('hero.jpg', 800, 600),
        ])->assertRedirect();

        $path = PageContent::where('page', 'home')->where('key', 'hero_image')->value('value');
        $this->assertStringStartsWith('images/pages/', $path);
        $this->assertStringEndsWith('.webp', $path);
        $this->assertFileExists(public_path($path));
        unlink(public_path($path));
    }

    public function test_site_settings_edit_and_override_propagate(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/admin/settings')
            ->assertOk()->assertInertia(fn ($p) => $p->component('Admin/Settings/Form')->has('fields'));

        $this->actingAs($admin)->put('/admin/settings', [
            'phone' => '+91 00000 00000',
            'socials_instagram' => 'https://instagram.com/new',
        ])->assertRedirect();

        $this->assertEquals('+91 00000 00000', SiteSetting::get('phone'));
        $this->assertEquals('https://instagram.com/new', SiteSetting::get('socials.instagram'));

        // Propagates to public pages via shared props
        $this->get('/contact')->assertSee('+91 00000 00000');
    }

    public function test_settings_blank_restores_config_default(): void
    {
        SiteSetting::create(['key' => 'phone', 'value' => 'x']);
        $this->actingAs($this->admin())->put('/admin/settings', ['phone' => '']);

        $this->assertEquals(config('nymak.phone'), SiteSetting::get('phone'));
    }

    public function test_client_logo_crud_with_image_upload(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/clients', [
            'name' => 'Test Distributor',
            'image' => UploadedFile::fake()->image('logo.png', 400, 200),
            'sort_order' => 5,
        ])->assertRedirect();

        $logo = ClientLogo::where('name', 'Test Distributor')->first();
        $this->assertStringEndsWith('.webp', $logo->image);
        $this->assertFileExists(public_path($logo->image));
        unlink(public_path($logo->image));

        // Logo reaches the home page via the clients prop
        $this->get('/')->assertInertia(fn ($p) => $p->component('Home')
            ->where('clients', fn ($c) => collect($c)->contains('image', $logo->image)));
    }

    public function test_client_logo_requires_image_on_create(): void
    {
        $this->actingAs($this->admin())->post('/admin/clients', [
            'name' => 'No Logo Inc',
            'sort_order' => 1,
        ])->assertSessionHasErrors('image');
    }

    public function test_team_member_photo_upload(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/team-members', [
            'name' => 'Ms. Test Person',
            'role' => 'Analyst',
            'is_leadership' => true,
            'photo' => UploadedFile::fake()->image('face.jpg', 300, 300),
            'sort_order' => 1,
        ])->assertRedirect();

        $member = \App\Models\TeamMember::where('name', 'Ms. Test Person')->first();
        $this->assertNotNull($member->photo);
        $this->assertFileExists(public_path($member->photo));
        unlink(public_path($member->photo));

        // Photo reaches the About page via the leadership prop
        $this->get('/about')->assertInertia(fn ($p) => $p->component('About')
            ->where('leadership', fn ($l) => collect($l)->contains('photo', $member->photo)));
    }

    public function test_certification_image_upload_via_crud(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/certifications', [
            'name' => 'Test Cert',
            'issuer' => 'Body',
            'image' => UploadedFile::fake()->image('cert.jpg', 400, 400),
            'sort_order' => 99,
        ])->assertRedirect();

        $cert = \App\Models\Certification::where('name', 'Test Cert')->first();
        $this->assertStringEndsWith('.webp', $cert->image);
        unlink(public_path($cert->image));
        $this->get('/quality-certifications')->assertInertia(fn ($p) => $p->component('Quality')
            ->where('certifications', fn ($c) => collect($c)->contains('image', $cert->image)));
    }

    public function test_guest_cannot_access_cms_endpoints(): void
    {
        $this->get('/admin/pages')->assertRedirect('/admin/login');
        $this->get('/admin/settings')->assertRedirect('/admin/login');
        $this->get('/admin/clients')->assertRedirect('/admin/login');
    }
}
