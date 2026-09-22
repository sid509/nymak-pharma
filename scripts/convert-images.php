#!/usr/bin/env php
<?php

/**
 * Convert provided PNG/JPG resources to optimized WebP under public/images/.
 *
 * Usage: php scripts/convert-images.php [source_dir] [max_width]
 *
 * Source defaults to the sibling Resources directory. Produces slugified,
 * descriptive filenames and reports before/after sizes. Requires `cwebp`.
 */

$source = $argv[1] ?? dirname(__DIR__, 2).'/Resources';
$dest = dirname(__DIR__).'/public/images';
$maxWidth = (int) ($argv[2] ?? 1200);

if (! is_dir($source)) {
    fwrite(STDERR, "Source not found: {$source}\n");
    exit(1);
}
if (! trim(shell_exec('command -v cwebp 2>/dev/null') ?: '')) {
    fwrite(STDERR, "cwebp not found. Install with: brew install webp\n");
    exit(1);
}

$map = [
    // Map source subpaths → public/images subpaths. Add new folders here.
    'Nymak Product Pictures/Liberia Products' => 'products/liberia',
    'Nymak Product Pictures/Sierra Leone Products' => 'products/sierra-leone',
    'Certifications' => 'certifications',
    'Clients' => 'clients',
];

$total = ['in' => 0, 'out' => 0, 'count' => 0];

foreach ($map as $srcSub => $dstSub) {
    $srcDir = $source.'/'.$srcSub;
    $dstDir = $dest.'/'.$dstSub;
    if (! is_dir($srcDir)) {
        echo "skip (missing): {$srcSub}\n";
        continue;
    }
    if (! is_dir($dstDir)) {
        mkdir($dstDir, 0755, true);
    }

    foreach (glob($srcDir.'/*.{png,jpg,jpeg,PNG,JPG,JPEG}', GLOB_BRACE) as $file) {
        $base = pathinfo($file, PATHINFO_FILENAME);
        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $base), '-'));
        $out = $dstDir.'/'.$slug.'.webp';

        $in = filesize($file);
        // -resize width 0 keeps aspect; -q 82 balances fidelity/size for packshots.
        $cmd = sprintf('cwebp -q 82 -resize %d 0 %s -o %s 2>/dev/null',
            $maxWidth, escapeshellarg($file), escapeshellarg($out));
        exec($cmd, $_, $code);

        if ($code === 0 && file_exists($out)) {
            $total['in'] += $in;
            $total['out'] += filesize($out);
            $total['count']++;
            echo "{$slug}.webp  ".round($in / 1024)."KB → ".round(filesize($out) / 1024)."KB\n";
        } else {
            echo "FAILED: {$file}\n";
        }
    }
}

printf("\n%d files · %s → %s (%.0f%% smaller)\n",
    $total['count'],
    round($total['in'] / 1048576, 1).'MB',
    round($total['out'] / 1048576, 1).'MB',
    $total['in'] ? (1 - $total['out'] / $total['in']) * 100 : 0
);
