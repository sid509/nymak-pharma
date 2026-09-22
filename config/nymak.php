<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nymak Pharma — site identity & NAP
    |--------------------------------------------------------------------------
    |
    | Single source of truth for company facts used across pages, schema.org
    | structured data, llms.txt, and the footer. Keep this accurate: it feeds
    | directly into Organization/LocalBusiness schema and SEO metadata.
    |
    */

    'name' => 'Nymak Pharma Pvt. Ltd.',
    'short_name' => 'Nymak Pharma',
    'tagline' => 'Efficacy-Driven Lifecare, Exported Worldwide',
    'legal_name' => 'Nymak Pharma Private Limited',
    'founded' => 1998,
    'founder' => 'Mr. Ranjit Advani',

    'description' => 'Nymak Pharma is a WHO-GMP certified pharmaceutical manufacturer and Government of India '
        .'recognised Star Export House, supplying IV fluids, finished formulations, medical devices, '
        .'rapid diagnostic kits and vaccines to more than 24 countries.',

    'phone' => '+91 98252 25567',
    'phone_href' => '+919825225567',
    'whatsapp' => '919825225567',
    'email' => 'info@nymakpharma.com',

    'address' => [
        'street' => 'Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Bhadreshwar',
        'city' => 'Mundra (Kutch)',
        'region' => 'Gujarat',
        'postal_code' => '370421',
        'country' => 'India',
        'country_code' => 'IN',
    ],

    'branch_address' => 'A-802, Money Plant High Street, Near BSNL Office, Jagatpur Road, SG Highway, Ahmedabad, Gujarat, India',

    /*
    |--------------------------------------------------------------------------
    | Overseas offices / authorised distributors
    |--------------------------------------------------------------------------
    */
    'offices' => [
        [
            'name' => 'Nymak Pharma — United Kingdom',
            'address' => '39, Moat Drive, Harrow, Middlesex, HA1 4RY, United Kingdom',
            'phone' => '+44 7943 534797',
            'email' => 'paresh.wadhwani@nymakpharma.com',
            'country_code' => 'GB',
        ],
        [
            'name' => 'Core Africa — Sierra Leone',
            'address' => '1st Floor, 39 Liverpool Street (UP), Off Pademba Road, Freetown, Sierra Leone',
            'phone' => '+232 90855049',
            'email' => 'sierraleone@coreafrica.net',
            'country_code' => 'SL',
        ],
        [
            'name' => 'Core Africa Liberia Inc.',
            'address' => 'Omega, Kakata Highway, Paynesville, Montserrado County, Liberia',
            'phone' => '+231 555 188 288',
            'phone_alt' => '+231 777 736 498',
            'email' => 'liberia@coreafrica.net',
            'country_code' => 'LR',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Social profiles (linked only when active — requirement #26)
    |--------------------------------------------------------------------------
    */
    'socials' => [
        'linkedin' => 'https://www.linkedin.com/company/nymak-pharma',
        'instagram' => 'https://www.instagram.com/nymakpharma',
        'x' => 'https://x.com/nymakpharma',
        'youtube' => null,
        'facebook' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Analytics & verification (requirement #2)
    |--------------------------------------------------------------------------
    | Set via environment. When unset, no tracking code is emitted.
    */
    'analytics' => [
        'ga4_id' => env('NYMAK_GA4_ID'),
        'gsc_verification' => env('NYMAK_GSC_VERIFICATION'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Enquiry handling
    |--------------------------------------------------------------------------
    */
    'enquiry' => [
        // Where enquiry notifications are sent. Falls back to the public email.
        'notify_to' => env('NYMAK_ENQUIRY_NOTIFY_TO', 'info@nymakpharma.com'),
        // Honeypot field name (must stay non-obvious).
        'honeypot' => 'website_url',
        // Minimum seconds a human needs to plausibly fill the form.
        'min_seconds' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Stats shown on marketing pages (kept factual — brochure/audit sourced)
    |--------------------------------------------------------------------------
    */
    'stats' => [
        'years' => '25+',
        'countries' => '24+',
        'containers_fy' => '200+',
        'products' => '150+',
    ],

];
