<?php

namespace Tests\Unit;

use App\Support\ImageUpload;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ImageUploadTest extends TestCase
{
    #[Test]
    public function delete_preserves_committed_seed_assets(): void
    {
        ImageUpload::delete('images/hero/facility-aerial.webp');

        $this->assertFileExists(public_path('images/hero/facility-aerial.webp'));
    }

    #[Test]
    public function delete_removes_uploaded_pattern_files(): void
    {
        $path = public_path('images/test-upload-Ab12Cd.webp');
        touch($path);

        ImageUpload::delete('images/test-upload-Ab12Cd.webp');

        $this->assertFileDoesNotExist($path);
    }

    #[Test]
    public function delete_ignores_paths_outside_managed_dirs_and_nulls(): void
    {
        ImageUpload::delete(null);
        ImageUpload::delete('../secret.webp');
        ImageUpload::delete('other/foo.webp');

        $this->addToAssertionCount(1);
    }
}
