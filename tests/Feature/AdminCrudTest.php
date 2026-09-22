<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\Market;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    #[Test]
    public function guests_cannot_reach_any_admin_module(): void
    {
        foreach (['/admin/dashboard', '/admin/enquiries', '/admin/products', '/admin/categories',
            '/admin/markets', '/admin/posts', '/admin/faqs', '/admin/testimonials',
            '/admin/certifications', '/admin/team-members', '/admin/users', '/admin/profile'] as $url) {
            $this->get($url)->assertRedirect('/admin/login');
        }
    }

    #[Test]
    public function dashboard_renders_with_stats(): void
    {
        $this->actingAs($this->admin)->get('/admin/dashboard')
            ->assertOk()
            ->assertInertia(fn ($p) => $p->component('Admin/Dashboard')->has('stats')->has('recentEnquiries'));
    }

    #[Test]
    public function products_index_lists_and_searches(): void
    {
        $this->actingAs($this->admin)->get('/admin/products')
            ->assertOk()->assertInertia(fn ($p) => $p->component('Admin/Products/Index')->has('products.data', 25));

        // Assert the search result equals the real DB count for the term.
        $expected = Product::where('name', 'like', '%Alumak%')->count();
        $this->actingAs($this->admin)->get('/admin/products?q=Alumak')
            ->assertInertia(fn ($p) => $p->where('filters.q', 'Alumak')
                ->where('products.total', $expected));
    }

    #[Test]
    public function product_can_be_created_with_generated_slug(): void
    {
        $category = ProductCategory::firstOrFail();

        $this->actingAs($this->admin)->post('/admin/products', [
            'name' => 'Testmak 5/500 Tablets',
            'product_category_id' => $category->id,
            'strength' => '5mg/500mg',
            'has_detail_page' => true,
        ])->assertRedirect('/admin/products');

        $this->assertDatabaseHas('products', ['name' => 'Testmak 5/500 Tablets', 'slug' => 'testmak-5-500-tablets']);
    }

    #[Test]
    public function product_slug_must_be_unique(): void
    {
        $product = Product::firstOrFail();
        $category = ProductCategory::firstOrFail();

        $this->actingAs($this->admin)->post('/admin/products', [
            'name' => 'Duplicate',
            'slug' => $product->slug,
            'product_category_id' => $category->id,
        ])->assertSessionHasErrors('slug');
    }

    #[Test]
    public function product_image_upload_converts_to_webp(): void
    {
        $product = Product::firstOrFail();
        $file = UploadedFile::fake()->image('shot.png', 200, 200);

        $this->actingAs($this->admin)->put("/admin/products/{$product->slug}", [
            'name' => $product->name,
            'slug' => $product->slug,
            'product_category_id' => $product->product_category_id,
            'image' => $file,
        ]);

        $fresh = $product->fresh();
        $this->assertStringStartsWith('images/products/', $fresh->image);
        $this->assertStringEndsWith('.webp', $fresh->image);
        $this->assertFileExists(public_path($fresh->image));

        unlink(public_path($fresh->image)); // cleanup
    }

    #[Test]
    public function non_image_upload_is_rejected(): void
    {
        $product = Product::firstOrFail();

        $this->actingAs($this->admin)->put("/admin/products/{$product->slug}", [
            'name' => $product->name,
            'product_category_id' => $product->product_category_id,
            'image' => UploadedFile::fake()->create('evil.php', 10, 'application/x-php'),
        ])->assertSessionHasErrors('image');
    }

    #[Test]
    public function product_delete_blocked_when_enquiries_reference_it(): void
    {
        $product = Product::firstOrFail();
        \App\Models\Enquiry::create([
            'name' => 'X', 'email' => 'x@x.test', 'message' => 'msg', 'product_id' => $product->id,
        ]);

        $this->actingAs($this->admin)->delete("/admin/products/{$product->slug}")
            ->assertStatus(422);
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    #[Test]
    public function market_crud_and_delete_guard(): void
    {
        $this->actingAs($this->admin)->post('/admin/markets', [
            'name' => 'Rwanda', 'iso_code' => 'RW', 'region' => 'East Africa', 'show_in_portfolio' => true,
        ])->assertRedirect('/admin/markets');
        $this->assertDatabaseHas('markets', ['slug' => 'rwanda', 'show_in_portfolio' => true]);

        $used = Market::whereHas('products')->firstOrFail();
        $this->actingAs($this->admin)->delete("/admin/markets/{$used->slug}")->assertStatus(422);

        $unused = Market::whereDoesntHave('products')->firstOrFail();
        $this->actingAs($this->admin)->delete("/admin/markets/{$unused->slug}")->assertRedirect();
    }

    #[Test]
    public function post_crud_and_publish_flow(): void
    {
        $this->actingAs($this->admin)->post('/admin/posts', [
            'title' => 'New export milestone',
            'body' => 'Some body text',
            'published_at' => now()->toDateTimeString(),
        ])->assertRedirect('/admin/posts');
        $post = Post::where('slug', 'new-export-milestone')->firstOrFail();
        $this->assertNotNull($post->published_at);

        // Published post is now publicly reachable.
        $this->get("/blog/{$post->slug}")->assertOk();
    }

    #[Test]
    public function faq_crud_via_shared_controller(): void
    {
        $this->actingAs($this->admin)->get('/admin/faqs')->assertOk()
            ->assertInertia(fn ($p) => $p->component('Admin/Crud/Index')->where('module.route', 'faqs'));

        $this->actingAs($this->admin)->post('/admin/faqs', [
            'question' => 'New question?', 'answer' => 'New answer.', 'sort_order' => 99,
        ])->assertRedirect('/admin/faqs');
        $faq = Faq::where('question', 'New question?')->firstOrFail();

        $this->actingAs($this->admin)->put("/admin/faqs/{$faq->id}", [
            'question' => 'Edited?', 'answer' => 'Edited answer.', 'sort_order' => 1,
        ]);
        $this->assertEquals('Edited?', $faq->fresh()->question);

        $this->actingAs($this->admin)->delete("/admin/faqs/{$faq->id}");
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }

    #[Test]
    public function faq_validation_rejects_empty(): void
    {
        $this->actingAs($this->admin)->post('/admin/faqs', ['question' => '', 'answer' => ''])
            ->assertSessionHasErrors(['question', 'answer']);
    }

    #[Test]
    public function category_is_editable_but_not_slug(): void
    {
        $category = ProductCategory::firstOrFail();

        $this->actingAs($this->admin)->put("/admin/categories/{$category->slug}", [
            'name' => 'Renamed Category',
            'slug' => 'hacker-slug',
            'intro' => 'New intro',
        ]);

        $fresh = $category->fresh();
        $this->assertEquals('Renamed Category', $fresh->name);
        $this->assertEquals($category->slug, $fresh->slug); // slug immutable
    }

    #[Test]
    public function team_member_crud(): void
    {
        $this->actingAs($this->admin)->post('/admin/team-members', [
            'name' => 'Test Person', 'role' => 'QA', 'is_leadership' => false,
        ])->assertRedirect('/admin/team-members');
        $this->assertDatabaseHas('team_members', ['name' => 'Test Person', 'is_leadership' => false]);
    }

    #[Test]
    public function admin_user_management_and_self_delete_guard(): void
    {
        $this->actingAs($this->admin)->post('/admin/users', [
            'name' => 'Second Admin',
            'email' => 'second@example.test',
            'password' => 'long-enough-password',
            'password_confirmation' => 'long-enough-password',
        ])->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', ['email' => 'second@example.test']);

        // Cannot delete yourself.
        $this->actingAs($this->admin)->delete("/admin/users/{$this->admin->id}")->assertStatus(422);

        // Weak password rejected.
        $this->actingAs($this->admin)->post('/admin/users', [
            'name' => 'Weak', 'email' => 'weak@example.test', 'password' => '123', 'password_confirmation' => '123',
        ])->assertSessionHasErrors('password');
    }

    #[Test]
    public function password_change_requires_current_password(): void
    {
        $user = User::factory()->create(['password' => 'old-password-123']);

        $this->actingAs($user)->put('/admin/profile/password', [
            'current_password' => 'wrong',
            'password' => 'new-password-456',
            'password_confirmation' => 'new-password-456',
        ])->assertSessionHasErrors('current_password');

        $this->actingAs($user)->put('/admin/profile/password', [
            'current_password' => 'old-password-123',
            'password' => 'new-password-456',
            'password_confirmation' => 'new-password-456',
        ]);

        $this->assertTrue(Hash::check('new-password-456', $user->fresh()->password));
    }

    #[Test]
    public function enquiry_search_and_unread_filter(): void
    {
        \App\Models\Enquiry::create(['name' => 'Amina Sesay', 'email' => 'a@a.test', 'message' => 'x', 'country' => 'Sierra Leone']);
        \App\Models\Enquiry::create(['name' => 'Bob K', 'email' => 'b@b.test', 'message' => 'x', 'read_at' => now()]);

        $this->actingAs($this->admin)->get('/admin/enquiries?q=Amina')
            ->assertInertia(fn ($p) => $p->has('enquiries.data', 1));

        $this->actingAs($this->admin)->get('/admin/enquiries?status=unread')
            ->assertInertia(fn ($p) => $p->has('enquiries.data', 1));
    }
}
