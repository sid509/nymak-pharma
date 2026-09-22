<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Converts an uploaded image to WebP and stores it under public/images/.
 *
 * Matches the site's existing asset convention (committed WebP files served
 * directly from public/). Width is capped for performance; EXIF orientation
 * is honoured via Imagick when available.
 */
class ImageUpload
{
    public const MAX_WIDTH = 1200;

    /**
     * @return string web-relative path, e.g. "images/products/foo.webp"
     */
    public static function store(UploadedFile $file, string $subdir, ?string $name = null): string
    {
        $dir = public_path("images/{$subdir}");
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $slug = Str::slug(str_replace('/', '-', $name ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)));
        $filename = $slug.'-'.Str::random(6).'.webp';
        $path = $dir.'/'.$filename;

        self::toWebp($file->getRealPath(), $path);

        return "images/{$subdir}/{$filename}";
    }

    public static function delete(?string $webPath): void
    {
        if ($webPath && str_starts_with($webPath, 'images/')) {
            $abs = public_path($webPath);
            if (is_file($abs)) {
                unlink($abs);
            }
        }
    }

    private static function toWebp(string $src, string $dest): void
    {
        if (extension_loaded('imagick')) {
            $img = new \Imagick($src);
            $img->autoOrient();
            $img->setImageFormat('webp');
            $img->setImageCompressionQuality(82);
            if ($img->getImageWidth() > self::MAX_WIDTH) {
                $img->resizeImage(self::MAX_WIDTH, 0, \Imagick::FILTER_LANCZOS, 1);
            }
            $img->writeImage($dest);
            $img->destroy();

            return;
        }

        // GD fallback.
        $srcImg = match (mime_content_type($src)) {
            'image/jpeg' => imagecreatefromjpeg($src),
            'image/png' => imagecreatefrompng($src),
            'image/webp' => imagecreatefromwebp($src),
            default => null,
        };
        if (! $srcImg) {
            throw new \RuntimeException('Unsupported image type');
        }
        $w = imagesx($srcImg);
        $h = imagesy($srcImg);
        if ($w > self::MAX_WIDTH) {
            $h = (int) ($h * self::MAX_WIDTH / $w);
            $w = self::MAX_WIDTH;
            $resized = imagescale($srcImg, $w, $h);
            imagedestroy($srcImg);
            $srcImg = $resized;
        }
        imagewebp($srcImg, $dest, 82);
        imagedestroy($srcImg);
    }
}
