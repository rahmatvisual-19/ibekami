<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Type;
use App\Models\Machine;
use App\Models\Partnership;
use App\Models\Banner;

/**
 * Updates all database image_url fields from .jpg/.jpeg/.png to .webp
 * after the Node.js convert-to-webp.js script has run.
 *
 * Usage:
 *   php artisan images:update-db-to-webp [--dry-run]
 */
class UpdateImagesToWebp extends Command
{
    protected $signature   = 'images:update-db-to-webp {--dry-run : Show changes without saving}';
    protected $description = 'Update all image_url database fields to use .webp extension';

    private int $updated = 0;
    private int $skipped = 0;

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('[DRY RUN] No changes will be saved.');
        }

        $this->info('Updating image records to .webp...');
        $this->newLine();

        $this->updateSingleImageModels($dryRun);
        $this->updateProductImages($dryRun);

        $this->newLine();
        $this->info("✅ Done — Updated: {$this->updated}, Skipped (already webp): {$this->skipped}");

        if ($dryRun && $this->updated > 0) {
            $this->warn('Run without --dry-run to apply changes.');
        }

        return Command::SUCCESS;
    }

    // ─── Single-image models ──────────────────────────────────────────────────

    private function updateSingleImageModels(bool $dryRun): void
    {
        $models = [
            ['model' => Type::class,        'label' => 'Type (jenis)',   'folder' => 'gambar_jenis'],
            ['model' => Machine::class,     'label' => 'Machine',        'folder' => 'machine_picture'],
            ['model' => Partnership::class, 'label' => 'Partnership',    'folder' => 'gambar_partner'],
            ['model' => Banner::class,      'label' => 'Banner',         'folder' => 'banner_picture'],
        ];

        foreach ($models as $cfg) {
            $records = $cfg['model']::whereNotNull('image_url')->get();
            $this->line("  [{$cfg['label']}] {$records->count()} record(s)");

            foreach ($records as $record) {
                $original = $record->image_url;
                $webp     = $this->toWebpName($original);

                if ($original === $webp) {
                    $this->skipped++;
                    continue;
                }

                // Only update if the .webp file actually exists on disk
                $diskPath = storage_path("app/public/{$cfg['folder']}/{$webp}");
                if (!file_exists($diskPath)) {
                    $this->warn("    ⚠  WebP file not found on disk, skipping: {$webp}");
                    continue;
                }

                $this->line("    {$original} → {$webp}");
                $this->updated++;

                if (!$dryRun) {
                    $record->image_url = $webp;
                    $record->save();
                }
            }
        }
    }

    // ─── Product (JSON array of images) ──────────────────────────────────────

    private function updateProductImages(bool $dryRun): void
    {
        $products = Product::whereNotNull('image_url')->get();
        $this->line("  [Product] {$products->count()} record(s)");

        foreach ($products as $product) {
            $images  = $product->image_url; // cast to array via model
            $changed = false;
            $updated = [];

            foreach ($images as $img) {
                $webp = $this->toWebpName($img);

                if ($img === $webp) {
                    $updated[] = $img;
                    $this->skipped++;
                    continue;
                }

                $diskPath = storage_path("app/public/gambar_produk/{$webp}");
                if (!file_exists($diskPath)) {
                    $this->warn("    ⚠  WebP not found, keeping original: {$img}");
                    $updated[] = $img;
                    continue;
                }

                $this->line("    [{$product->product_id}] {$img} → {$webp}");
                $updated[] = $webp;
                $changed   = true;
                $this->updated++;
            }

            if ($changed && !$dryRun) {
                $product->image_url = $updated;
                $product->save();
            }
        }
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    private function toWebpName(string $filename): string
    {
        return preg_replace('/\.(jpe?g|png)$/i', '.webp', $filename);
    }
}
