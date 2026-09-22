<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Admin-editable SEO overrides for static/list pages, keyed by page id.
 * Used by Seo::override() — empty fields fall back to controller defaults.
 */
class PageMeta extends Model
{
    protected $fillable = ['key', 'meta_title', 'meta_description', 'og_image'];

    /** The public pages admins may edit. key => label. */
    public const PAGES = [
        'home' => 'Home',
        'about' => 'About Us',
        'manufacturing' => 'Manufacturing',
        'quality' => 'Quality & Certifications',
        'products.index' => 'Products (overview)',
        'markets.index' => 'Global Presence',
        'posts.index' => 'Blog / Resources',
        'faqs' => 'FAQs',
        'contact' => 'Contact Us',
        'privacy' => 'Privacy Policy',
        'terms' => 'Terms of Use',
    ];
}
