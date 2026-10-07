<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    | IPs of reverse proxies (ngrok, load balancer, CDN) whose X-Forwarded-*
    | headers the app should honor. '*' or '**' trusts every proxy — use for
    | tunnels with dynamic IPs. Comma-separate specific IPs/CIDRs otherwise.
    |
    */

    'proxies' => env('TRUSTED_PROXIES'),

];
