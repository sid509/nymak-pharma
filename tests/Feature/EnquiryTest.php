<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Notifications\EnquiryReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EnquiryTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Amina Sesay',
            'company' => 'Freetown Medical Supplies',
            'email' => 'amina@freetownmeds.example',
            'phone' => '+232 76 000 000',
            'country' => 'Sierra Leone',
            'subject' => 'Distribution enquiry',
            'message' => 'We would like to discuss distribution of your IV fluids range for Sierra Leone.',
            'privacy' => true,
            'form_started_at' => now()->subMinutes(2)->timestamp,
        ], $overrides);
    }

    #[Test]
    public function valid_enquiry_is_stored_and_notification_sent(): void
    {
        Notification::fake();

        $this->post('/contact', $this->payload())
            ->assertRedirect('/contact')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('enquiries', [
            'email' => 'amina@freetownmeds.example',
            'country' => 'Sierra Leone',
        ]);

        $enquiry = Enquiry::first();
        Notification::assertSentOnDemand(EnquiryReceived::class,
            fn ($n) => $n->enquiry->is($enquiry));
    }

    #[Test]
    public function required_fields_are_validated(): void
    {
        $this->post('/contact', [])
            ->assertSessionHasErrors(['name', 'email', 'message', 'privacy', 'form_started_at']);

        $this->assertDatabaseCount('enquiries', 0);
    }

    #[Test]
    public function honeypot_submissions_get_fake_success_without_storing(): void
    {
        Notification::fake();
        $honeypot = config('nymak.enquiry.honeypot');

        $this->post('/contact', $this->payload([$honeypot => 'http://spam.example']))
            ->assertRedirect('/contact')
            ->assertSessionHas('success');

        $this->assertDatabaseCount('enquiries', 0);
        Notification::assertNothingSent();
    }

    #[Test]
    public function submissions_too_fast_are_treated_as_bots(): void
    {
        Notification::fake();

        $this->post('/contact', $this->payload(['form_started_at' => now()->timestamp]))
            ->assertRedirect('/contact')
            ->assertSessionHas('success');

        $this->assertDatabaseCount('enquiries', 0);
    }

    #[Test]
    public function malformed_input_is_rejected(): void
    {
        $this->post('/contact', $this->payload([
            'email' => 'not-an-email',
            'message' => 'short',
        ]))->assertSessionHasErrors(['email', 'message']);

        $this->post('/contact', $this->payload(['product_id' => 999999]))
            ->assertSessionHasErrors(['product_id']);

        $this->assertDatabaseCount('enquiries', 0);
    }

    #[Test]
    public function enquiry_can_be_linked_to_a_product(): void
    {
        Notification::fake();
        $product = \App\Models\Product::firstOrFail();

        $this->post('/contact', $this->payload(['product_id' => $product->id]))
            ->assertSessionHas('success');

        $this->assertEquals($product->id, Enquiry::first()->product_id);
    }

    #[Test]
    public function product_query_param_preselects_the_product(): void
    {
        $product = \App\Models\Product::where('has_detail_page', true)->firstOrFail();

        $this->get("/contact?product={$product->slug}")
            ->assertOk()
            ->assertInertia(fn ($page) => $page->where('selectedProduct', $product->id));

        $this->get('/contact?product=nonexistent-slug')
            ->assertOk()
            ->assertInertia(fn ($page) => $page->where('selectedProduct', null));
    }
}
