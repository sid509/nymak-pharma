<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private function admin(): User
    {
        return User::factory()->create([
            'email' => 'admin@example.test',
            'password' => Hash::make('secret-password'),
        ]);
    }

    #[Test]
    public function enquiry_inbox_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    #[Test]
    public function admin_can_log_in_and_view_enquiries(): void
    {
        $admin = $this->admin();
        Enquiry::create([
            'name' => 'Test Buyer', 'email' => 'buyer@example.test',
            'message' => 'Interested in IV fluids range for East Africa.',
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@example.test',
            'password' => 'secret-password',
        ])->assertRedirect('/admin/dashboard');

        $this->actingAs($admin)->get('/admin/enquiries')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Admin/Enquiries/Index')
                ->has('enquiries.data', 1)
            );
    }

    #[Test]
    public function wrong_credentials_are_rejected(): void
    {
        $this->admin();

        $this->post('/admin/login', [
            'email' => 'admin@example.test',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    #[Test]
    public function admin_can_mark_enquiry_read_and_delete(): void
    {
        $admin = $this->admin();
        $enquiry = Enquiry::create([
            'name' => 'Test Buyer', 'email' => 'buyer@example.test',
            'message' => 'Test message body.',
        ]);

        $this->assertNull($enquiry->read_at);

        $this->actingAs($admin)->patch("/admin/enquiries/{$enquiry->id}/read");
        $this->assertNotNull($enquiry->fresh()->read_at);

        $this->actingAs($admin)->delete("/admin/enquiries/{$enquiry->id}");
        $this->assertDatabaseMissing('enquiries', ['id' => $enquiry->id]);
    }

    #[Test]
    public function guests_cannot_modify_enquiries(): void
    {
        $enquiry = Enquiry::create([
            'name' => 'T', 'email' => 't@t.test', 'message' => 'Message text here.',
        ]);

        $this->patch("/admin/enquiries/{$enquiry->id}/read")->assertRedirect('/admin/login');
        $this->delete("/admin/enquiries/{$enquiry->id}")->assertRedirect('/admin/login');
    }
}
