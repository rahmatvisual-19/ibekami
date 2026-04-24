<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Banner;

/**
 * Updates banner image_url fields from .mp4/.ogg to .webm
 * after the Node.js convert-videos-to-webm.cjs script has run.
 *
 * Usage:
 *   php artisan videos:update-db-to-webm [--dry-run]
 */
class UpdateVideosToWebm extends Command
{
    protected $signature   = 'videos:update-db-to-webm {--dry-run : Show changes without saving}';
    protected $description = 'Update banner image_url fields to use .webm extension';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('[DRY RUN] No changes will be saved.');
        }

        $updated = 0;
        $skipped = 0;

        $banners = Banner::whereNotNull('image_url')->get();
        $this->info("Checking {$banners->count()} banner record(s)...");

        foreach ($banners as $banner) {
            $original = $banner->image_url;
            $ext      = strtolower(pathinfo($original, PATHINFO_EXTENSION));

            // Only process video files
            if (!in_array($ext, ['mp4', 'ogg', 'mov'])) {
                $skipped++;
                continue;
            }

            $webmName = preg_replace('/\.(mp4|ogg|mov)$/i', '.webm', $original);
            $diskPath = storage_path('app/public/banner_picture/' . $webmName);

            if (!file_exists($diskPath)) {
                $this->warn("  ⚠  WebM not found on disk, skipping: {$webmName}");
                continue;
            }

            $this->line("  {$original} → {$webmName}");
            $updated++;

            if (!$dryRun) {
                $banner->image_url = $webmName;
                $banner->save();
            }
        }

        $this->newLine();
        $this->info("✅ Done — Updated: {$updated}, Skipped (non-video/already webm): {$skipped}");

        if ($dryRun && $updated > 0) {
            $this->warn('Run without --dry-run to apply changes.');
        }

        return Command::SUCCESS;
    }
}
