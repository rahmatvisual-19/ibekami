# Video Poster Guide - Hero Banner

## Masalah
Poster video hero banner tidak tampil di website hosting karena file poster tidak ditemukan.

## Solusi yang Sudah Diterapkan

### Fallback Hierarchy (3 Level)

Sistem sekarang mencari poster dengan urutan prioritas:

#### 1. Poster dengan Nama File yang Sama (Priority 1)
Jika video bernama `69eb18f6001c0.webm`, sistem akan mencari:
- `storage/banner_picture/69eb18f6001c0.webp`
- `storage/banner_picture/69eb18f6001c0.jpg`
- `storage/banner_picture/69eb18f6001c0.png`

#### 2. Poster Default di Storage (Priority 2)
Jika tidak ditemukan, cari:
- `storage/banner_picture/poster.webp`

#### 3. Poster Default di Public (Priority 3)
Jika masih tidak ditemukan, cari di `public/images/hero/`:
- `heroes.webp`
- `hero-poster.webp`
- `poster.webp`
- `hero.jpg`

#### 4. SVG Placeholder (Priority 4 - Last Resort)
Jika semua tidak ada, gunakan SVG placeholder warna solid (#EFE9DA)

## Cara Upload Poster

### Opsi A: Upload via Dashboard (Recommended)
1. Login ke dashboard admin
2. Buka menu Banner
3. Upload gambar poster dengan nama yang sama dengan video
   - Video: `69eb18f6001c0.webm`
   - Poster: `69eb18f6001c0.jpg` atau `69eb18f6001c0.webp`

### Opsi B: Upload Manual via FTP/File Manager

#### Untuk Poster Spesifik per Video:
```
storage/app/public/banner_picture/
├── 69eb18f6001c0.webm          (video)
└── 69eb18f6001c0.webp          (poster dengan nama sama)
```

#### Untuk Poster Default (Semua Video):
```
storage/app/public/banner_picture/
└── poster.webp                  (poster default untuk semua video)
```

#### Untuk Poster Fallback Global:
```
public/images/hero/
└── heroes.webp                  (poster fallback jika storage kosong)
```

### Opsi C: Extract Frame dari Video

Gunakan FFmpeg untuk extract frame dari video sebagai poster:

```bash
# Extract frame di detik ke-1 sebagai JPG
ffmpeg -i 69eb18f6001c0.webm -ss 00:00:01 -vframes 1 -q:v 2 69eb18f6001c0.jpg

# Konversi ke WebP untuk ukuran lebih kecil
ffmpeg -i 69eb18f6001c0.jpg -c:v libwebp -quality 85 69eb18f6001c0.webp
```

Atau gunakan VLC:
1. Buka video di VLC
2. Video → Snapshot (atau tekan Shift+S)
3. Rename file sesuai nama video
4. Upload ke `storage/banner_picture/`

## Rekomendasi Ukuran Poster

| Aspek | Spesifikasi |
|-------|-------------|
| **Resolusi** | 1440 × 600 px (sama dengan banner) |
| **Format** | WebP (recommended), JPG, PNG |
| **Ukuran File** | < 150 KB |
| **Aspect Ratio** | 2.4:1 (landscape) |

## Troubleshooting

### Poster Tidak Tampil di Hosting

**Cek 1: Apakah file poster ada?**
```bash
# Via SSH
ls -la storage/app/public/banner_picture/

# Via File Manager
Buka: storage/app/public/banner_picture/
```

**Cek 2: Apakah symbolic link sudah dibuat?**
```bash
php artisan storage:link
```

**Cek 3: Apakah permission file benar?**
```bash
chmod 644 storage/app/public/banner_picture/*.webp
chmod 755 storage/app/public/banner_picture/
```

**Cek 4: Apakah path benar di browser?**
Buka browser console (F12) dan cek error 404:
```
https://ibekami.id/storage/banner_picture/69eb18f6001c0.webp
```

### Quick Fix: Upload Poster Default

Jika tidak punya poster spesifik, upload satu poster default:

1. Buat/download gambar poster (1440×600 px)
2. Rename menjadi `poster.webp`
3. Upload ke `storage/app/public/banner_picture/poster.webp`
4. Atau upload ke `public/images/hero/heroes.webp`

Semua video akan menggunakan poster ini.

## Testing

### Test di Local:
```bash
# Cek apakah poster ada
php artisan tinker
>>> file_exists(storage_path('app/public/banner_picture/poster.webp'))
=> true

# Cek URL poster
>>> asset('storage/banner_picture/poster.webp')
=> "http://localhost/storage/banner_picture/poster.webp"
```

### Test di Browser:
1. Buka website
2. Klik kanan → Inspect Element (F12)
3. Cek tab Network
4. Filter: Images
5. Lihat apakah poster.webp dimuat (status 200)

## File yang Dimodifikasi

- ✅ `resources/views/home.blade.php` - Tambah 3 level fallback untuk poster

## Summary

**Sebelum:**
- ❌ Poster hanya dicari dengan nama file yang sama
- ❌ Jika tidak ada, tidak ada fallback
- ❌ Poster tidak tampil di hosting

**Sesudah:**
- ✅ 3 level fallback (nama sama → default storage → public hero → SVG)
- ✅ Selalu ada poster (minimal SVG placeholder)
- ✅ Lebih robust dan tidak error

Upload poster dengan salah satu cara di atas, dan poster akan tampil!
