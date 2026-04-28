<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ConvertImagesToWebp extends Command
{
    protected $signature = 'images:convert-webp {--force : Overwrite existing WebP files} {--delete-original : Hapus file JPG/PNG asli setelah konversi}';
    
    protected $description = 'Konversi semua gambar PNG/JPG ke WebP untuk optimasi performa';

    public function handle()
    {
        $this->info('🚀 Memulai konversi gambar ke WebP...');
        $this->newLine();

        // Folder yang akan diproses
        $folders = [
            'gambar_produk',
            'gambar_jenis',
            'gambar_partner',
            'banner_picture',
        ];

        $totalConverted = 0;
        $totalSkipped = 0;
        $totalFailed = 0;
        $totalSaved = 0;

        foreach ($folders as $folder) {
            $this->line("📁 Memproses folder: <fg=cyan>{$folder}</>");
            
            $files = Storage::disk('public')->files($folder);
            
            if (empty($files)) {
                $this->warn("   Folder kosong, skip.");
                $this->newLine();
                continue;
            }

            foreach ($files as $file) {
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                // Skip jika bukan gambar atau sudah WebP
                if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                    continue;
                }

                $sourcePath = Storage::disk('public')->path($file);
                $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $sourcePath);

                // Skip jika WebP sudah ada (kecuali --force)
                if (file_exists($webpPath) && !$this->option('force')) {
                    $this->line("   ⏭️  Skip (sudah ada): " . basename($file));
                    $totalSkipped++;
                    continue;
                }

                try {
                    $result = $this->convertToWebp($sourcePath, $webpPath, $ext);
                    
                    if ($result['success']) {
                        $saved = $result['saved_bytes'];
                        $savedPercent = $result['saved_percent'];
                        $totalSaved += $saved;
                        
                        $this->info("   ✓ " . basename($file) . " → hemat {$savedPercent}% (" . $this->formatBytes($saved) . ")");
                        $totalConverted++;
                    } else {
                        $this->error("   ✗ Gagal: " . basename($file) . " — " . $result['error']);
                        $totalFailed++;
                    }
                } catch (\Exception $e) {
                    $this->error("   ✗ Error: " . basename($file) . " — " . $e->getMessage());
                    $totalFailed++;
                }
            }

            $this->newLine();
        }

        // Summary
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('📊 RINGKASAN KONVERSI');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line("✓ Berhasil dikonversi: <fg=green>{$totalConverted}</> file");
        $this->line("⏭️  Dilewati (sudah ada): <fg=yellow>{$totalSkipped}</> file");
        $this->line("✗ Gagal: <fg=red>{$totalFailed}</> file");
        $this->line("💾 Total hemat: <fg=cyan>" . $this->formatBytes($totalSaved) . "</>");
        $this->newLine();

        if ($totalConverted > 0) {
            $this->info('✨ Konversi selesai! Website sekarang lebih cepat.');
        }

        return Command::SUCCESS;
    }

    /**
     * Konversi gambar ke WebP menggunakan GD
     */
    private function convertToWebp(string $sourcePath, string $webpPath, string $ext): array
    {
        if (!function_exists('imagewebp')) {
            return [
                'success' => false,
                'error' => 'GD library tidak support WebP. Install php-gd dengan WebP support.'
            ];
        }

        // Load gambar berdasarkan tipe
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $image = @imagecreatefromjpeg($sourcePath);
                break;
            case 'png':
                $image = @imagecreatefrompng($sourcePath);
                // Preserve transparency
                imagealphablending($image, false);
                imagesavealpha($image, true);
                break;
            default:
                return ['success' => false, 'error' => 'Format tidak didukung'];
        }

        if (!$image) {
            return ['success' => false, 'error' => 'Gagal membaca gambar'];
        }

        // Konversi ke WebP dengan kualitas 82 (sweet spot antara ukuran & kualitas)
        $success = imagewebp($image, $webpPath, 82);
        imagedestroy($image);

        if (!$success) {
            return ['success' => false, 'error' => 'Gagal menyimpan WebP'];
        }

        // Hitung penghematan
        $originalSize = filesize($sourcePath);
        $webpSize = filesize($webpPath);
        $savedBytes = $originalSize - $webpSize;
        $savedPercent = round((1 - $webpSize / $originalSize) * 100);

        return [
            'success' => true,
            'saved_bytes' => $savedBytes,
            'saved_percent' => $savedPercent
        ];
    }

    /**
     * Format bytes ke KB/MB
     */
    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
