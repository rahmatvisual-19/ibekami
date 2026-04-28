<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Type;
use App\Models\Partnership;
use App\Models\Banner;

class UpdateImagesToWebp extends Command
{
    protected $signature = 'db:update-images-webp {--dry-run : Preview changes without updating database}';
    
    protected $description = 'Update database records untuk pakai file WebP yang sudah dikonversi';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->warn('🔍 DRY RUN MODE - Tidak ada perubahan yang disimpan ke database');
        } else {
            $this->info('🚀 Memulai update database...');
        }
        
        $this->newLine();

        $totalUpdated = 0;

        // Update Products
        $this->line('📦 Memproses Products...');
        $products = Product::all();
        foreach ($products as $product) {
            $updated = false;
            $imageUrls = $product->image_url;
            
            if (is_array($imageUrls)) {
                $newUrls = array_map(function($url) {
                    return preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $url);
                }, $imageUrls);
                
                if ($newUrls !== $imageUrls) {
                    if (!$isDryRun) {
                        $product->image_url = $newUrls;
                        $product->save();
                    }
                    $this->info("   ✓ Product: {$product->name}");
                    $updated = true;
                    $totalUpdated++;
                }
            }
        }

        // Update Types
        $this->newLine();
        $this->line('🏷️  Memproses Types...');
        $types = Type::all();
        foreach ($types as $type) {
            if ($type->image_url && preg_match('/\.(jpg|jpeg|png)$/i', $type->image_url)) {
                $newUrl = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $type->image_url);
                if (!$isDryRun) {
                    $type->image_url = $newUrl;
                    $type->save();
                }
                $this->info("   ✓ Type: {$type->name}");
                $totalUpdated++;
            }
        }

        // Update Partnerships
        $this->newLine();
        $this->line('🤝 Memproses Partnerships...');
        $partnerships = Partnership::all();
        foreach ($partnerships as $partner) {
            if ($partner->image_url && preg_match('/\.(jpg|jpeg|png)$/i', $partner->image_url)) {
                $newUrl = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $partner->image_url);
                if (!$isDryRun) {
                    $partner->image_url = $newUrl;
                    $partner->save();
                }
                $this->info("   ✓ Partner: {$partner->name}");
                $totalUpdated++;
            }
        }

        // Update Banners
        $this->newLine();
        $this->line('🎨 Memproses Banners...');
        $banners = Banner::all();
        foreach ($banners as $banner) {
            if ($banner->image_url && preg_match('/\.(jpg|jpeg|png)$/i', $banner->image_url)) {
                $newUrl = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $banner->image_url);
                if (!$isDryRun) {
                    $banner->image_url = $newUrl;
                    $banner->save();
                }
                $this->info("   ✓ Banner: {$banner->title}");
                $totalUpdated++;
            }
        }

        // Summary
        $this->newLine();
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        if ($isDryRun) {
            $this->warn("📊 PREVIEW: {$totalUpdated} record akan diupdate");
            $this->line("Jalankan tanpa --dry-run untuk apply perubahan.");
        } else {
            $this->info("✅ Selesai! {$totalUpdated} record berhasil diupdate");
        }
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        return Command::SUCCESS;
    }
}
