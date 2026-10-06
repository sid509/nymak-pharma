<?php

namespace Tests\Feature;

use App\Models\Market;
use App\Models\User;
use App\Support\Html;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GlobalPresenceMapTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    #[Test]
    public function map_page_exposes_every_market_with_map_placement_data(): void
    {
        $this->get('/global-presence')->assertOk()
            ->assertInertia(fn (Assert $p) => $p
                ->component('Markets/Index')
                ->has('markets', Market::count())
                ->has('markets.0', fn (Assert $m) => $m
                    ->hasAll(['name', 'slug', 'iso_code', 'region', 'description', 'content', 'latitude', 'longitude', 'featured', 'office', 'products']))
                ->where('markets.0.slug', 'sierra-leone')
                ->where('markets.0.iso_code', 'SL')
                ->where('markets.0.featured', true)
                ->has('content.map_title')
                ->has('content.footprint_stats')
            );
    }

    #[Test]
    public function multi_country_regions_are_pinned_by_coordinates(): void
    {
        $this->get('/global-presence')
            ->assertInertia(fn (Assert $p) => $p
                ->where('markets.10.slug', 'south-pacific')
                ->where('markets.10.iso_code', null)
                ->where('markets.10.latitude', fn ($v) => abs($v - -17.7) < 0.0001)
                ->where('markets.10.longitude', fn ($v) => abs($v - 178.0) < 0.0001)
            );
    }

    #[Test]
    public function rich_content_reaches_the_page_as_sanitised_html(): void
    {
        $this->get('/global-presence')
            ->assertInertia(fn (Assert $p) => $p
                ->where('markets.0.content', fn ($html) => str_contains($html, '<h3>What we do here</h3>')
                    && str_contains($html, '<strong>Alumak</strong>'))
                ->where('markets.3.content', null));
    }

    #[Test]
    public function wysiwyg_content_is_sanitised_on_save(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post('/admin/markets', [
            'name' => 'Rwanda', 'iso_code' => 'rw', 'region' => 'East Africa',
            'content' => '<h2>Work</h2><p onclick="steal()">Hospitals <a href="javascript:alert(1)">bad</a> '
                .'<a href="https://example.com/partner">good</a></p><script>evil()</script><img src=x onerror=evil()>'
                .'<ul><li><strong>IV fluids</strong></li></ul>',
        ])->assertRedirect('/admin/markets');

        $market = Market::where('slug', 'rwanda')->firstOrFail();

        $this->assertSame('RW', $market->iso_code);
        $this->assertStringContainsString('<h2>Work</h2>', $market->content);
        $this->assertStringContainsString('<li><strong>IV fluids</strong></li>', $market->content);
        $this->assertStringContainsString('href="https://example.com/partner"', $market->content);
        $this->assertStringContainsString('rel="noopener noreferrer"', $market->content);
        $this->assertStringNotContainsString('<script', $market->content);
        $this->assertStringNotContainsString('onclick', $market->content);
        $this->assertStringNotContainsString('onerror', $market->content);
        $this->assertStringNotContainsString('<img', $market->content);
        $this->assertStringNotContainsString('javascript:', $market->content);
    }

    #[Test]
    public function empty_editor_output_is_stored_as_null(): void
    {
        $this->assertNull(Html::sanitize('<p></p>'));
        $this->assertNull(Html::sanitize("<p></p>\n<p><br></p>"));
        $this->assertNull(Html::sanitize(null));
        $this->assertSame('<p>Hi</p>', Html::sanitize('<p>Hi</p>'));
    }

    #[Test]
    public function iso_code_and_pin_coordinates_are_validated(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->from('/admin/markets/create')->post('/admin/markets', [
            'name' => 'Bad', 'iso_code' => 'XYZ',
        ])->assertSessionHasErrors('iso_code');

        $this->actingAs($admin)->from('/admin/markets/create')->post('/admin/markets', [
            'name' => 'Bad', 'latitude' => 95, 'longitude' => 10,
        ])->assertSessionHasErrors('latitude');

        $this->actingAs($admin)->from('/admin/markets/create')->post('/admin/markets', [
            'name' => 'Bad', 'latitude' => 10,
        ])->assertSessionHasErrors('longitude');

        $this->actingAs($admin)->post('/admin/markets', [
            'name' => 'Caribbean Islands', 'latitude' => '15.5', 'longitude' => '-61.2',
        ])->assertRedirect('/admin/markets');
        $this->assertDatabaseHas('markets', ['slug' => 'caribbean-islands', 'iso_code' => null]);
        $this->assertEqualsWithDelta(15.5, Market::where('slug', 'caribbean-islands')->value('latitude'), 0.0001);
    }

    #[Test]
    public function admin_edit_screen_loads_rich_content_for_the_editor(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->get('/admin/markets/sierra-leone/edit')->assertOk()
            ->assertInertia(fn (Assert $p) => $p
                ->component('Admin/Markets/Form')
                ->has('market.content')
                ->has('market.latitude')
                ->where('market.iso_code', 'SL'));
    }
}
