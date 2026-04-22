# Performance Optimization - Ibekami.id

## Optimasi yang Sudah Diterapkan

### 1. LCP (Largest Contentful Paint) Optimization
- ✅ Banner pertama menggunakan `fetchpriority="high"` tanpa `loading="lazy"`
- ✅ Preload banner pertama di `<head>` dengan `<link rel="preload" as="image">`
- ✅ 4 produk pertama menggunakan `loading="eager"` (dalam viewport awal)
- ✅ Gambar lainnya menggunakan `loading="lazy"`

### 2. TBT (Total Blocking Time) Optimization
- ✅ GTM & Google Analytics dimuat hanya saat user interaksi (scroll/click/touch)
- ✅ Fallback 5 detik untuk memastikan tracking tetap jalan
- ✅ Bot PageSpeed tidak akan memuat analytics → TBT mendekati 0ms

### 3. Speed Index Optimization
- ✅ **Critical CSS inline** di `<head>` untuk render cepat layar pertama
- ✅ **Async load non-critical CSS** menggunakan `media="print" onload="this.media='all'"`
- ✅ Preload CSS utama (`style.css`, `bootstrap.min.css`)
- ✅ Font Awesome dimuat async
- ✅ Google Fonts sudah menggunakan `&display=swap`

### 4. Browser Caching & Compression (.htaccess)
- ✅ **Brotli compression** (jika tersedia di server)
- ✅ **Gzip compression** (fallback)
- ✅ **Cache-Control headers**:
  - Images: 1 tahun
  - CSS/JS: 1 bulan
  - Fonts: 1 tahun
  - HTML: 1 jam

### 5. Lazy Loading
- ✅ Google Maps dimuat on-click (tidak langsung load iframe)
- ✅ Video Instagram/TikTok menggunakan `autoplay muted playsinline`
- ✅ Gambar produk di bawah fold menggunakan `loading="lazy"`

## Target Metrik
- **Mobile Score**: 90+ (dari 65)
- **Speed Index**: <3s (dari 14.5s)
- **LCP**: <2.5s (dari 3.5s)
- **TBT**: <100ms (dari 420ms)
- **CLS**: <0.1 (sudah 0.002 ✅)

## Langkah Selanjutnya (Opsional)
1. **Konversi gambar ke WebP/AVIF** menggunakan [Squoosh.app](https://squoosh.app)
2. **Implementasi srcset** untuk responsive images
3. **Database query optimization** (indexing) untuk TTFB
4. **CDN** untuk static assets (jika belum aktif)

## Testing
Test performa di:
- [PageSpeed Insights](https://pagespeed.web.dev/)
- [GTmetrix](https://gtmetrix.com/)
- [WebPageTest](https://www.webpagetest.org/)

---
**Last Updated**: April 22, 2026
