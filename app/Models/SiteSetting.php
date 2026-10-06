<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Company facts editable from /admin/settings. Rows are flat dotted keys that
 * override config('nymak') — SiteSetting::merged() is the single source used
 * by Inertia shared props, schema.org output and controllers.
 */
class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /** Admin-editable fields: dotted key => [label, type, help]. */
    public const FIELDS = [
        'tagline' => ['Tagline', 'text', 'Used in header/footer and schema.'],
        'phone' => ['Phone (display)', 'text', 'e.g. +91 98252 25567'],
        'phone_href' => ['Phone (tel: link)', 'text', 'Digits only, e.g. +919825225567'],
        'whatsapp' => ['WhatsApp number', 'text', 'International format, no symbols — e.g. 919825225567'],
        'tawk_property' => ['Tawk.to property/widget ID', 'text', 'From Tawk.to → Administration → Channels → Chat Widget, e.g. 6652e0f1a1b2c3/1iu4xyzab. Enables the live-chat launcher (bottom right); blank falls back to WhatsApp.'],
        'email' => ['Public email', 'email', null],
        'founded' => ['Founded year', 'text', null],
        'founder' => ['Founder name', 'text', null],
        'description' => ['Company description', 'textarea', 'Feeds Organization schema and llms.txt.'],
        'address.street' => ['HQ street', 'textarea', null],
        'address.city' => ['HQ city', 'text', null],
        'address.region' => ['HQ region/state', 'text', null],
        'address.postal_code' => ['HQ postal code', 'text', null],
        'address.country' => ['HQ country', 'text', null],
        'branch_address' => ['Branch address', 'textarea', null],
        'stats.years' => ['Stat: years', 'text', 'e.g. 25+'],
        'stats.countries' => ['Stat: countries', 'text', 'e.g. 24+'],
        'stats.containers_fy' => ['Stat: containers FY', 'text', 'e.g. 200+'],
        'stats.products' => ['Stat: products', 'text', 'e.g. 150+'],
        'socials.linkedin' => ['LinkedIn URL', 'text', 'Blank hides the icon.'],
        'socials.instagram' => ['Instagram URL', 'text', 'Blank hides the icon.'],
        'socials.x' => ['X (Twitter) URL', 'text', 'Blank hides the icon.'],
        'socials.facebook' => ['Facebook URL', 'text', 'Blank hides the icon.'],
        'socials.youtube' => ['YouTube URL', 'text', 'Blank hides the icon.'],
        'logo' => ['Logo image', 'image', 'PNG/JPG — replaces the built-in SVG wordmark in header/footer and feeds schema.org. Blank keeps the SVG.'],
        'brochure' => ['Product brochure', 'file', 'PDF up to 10 MB — linked from Home, Contact and footer.'],
        'offices' => ['Overseas offices (JSON)', 'json', 'Array of {name, address, phone, phone_alt?, email?, country_code}.'],
    ];

    /** config('nymak') merged with stored overrides. */
    public static function merged(): array
    {
        $config = config('nymak');

        foreach (static::all() as $row) {
            if ($row->value === null || $row->value === '') {
                continue;
            }
            $value = $row->value;
            if (isset(static::FIELDS[$row->key]) && static::FIELDS[$row->key][1] === 'json') {
                $value = json_decode($value, true);
            }
            Arr::set($config, $row->key, $value);
        }

        return $config;
    }

    public static function get(string $key, $default = null)
    {
        return Arr::get(static::merged(), $key, $default);
    }
}
