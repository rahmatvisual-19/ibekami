# Performance Optimization Fixes - PageSpeed Insights

Dokumentasi ini menjelaskan optimasi yang sudah diterapkan untuk meningkatkan skor PageSpeed Insights.

## ✅ Masalah yang Sudah Diperbaiki

### 1. Font Display (FOIT - Flash of Invisible Text)
**Masalah:** Font tidak menggunakan `font-display: swap`, menyebabkan teks tidak terlihat saat font loading.

**Solusi:**
- ✅ Tambahkan `&display=swap` di URL Google Fonts
- ✅ Tambahkan `font-display: swap` di critical CSS
- ✅ Preload font dengan `rel="preload"` dan `as="style"`

**File:** `resources/views/layout/WebLayout.blade.php`
```html
<!-- Preload font untuk loading lebih cepat -->
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">

<!-- Critical CSS -->
<style>
@font-face{font-family:'Open Sans';font-display:swap;src:local('Open Sans')}
@font-face{font-family:'Montserrat';font-display:swap;src:local('Montserrat')}
</style>
```

### 2. Render Blocking Resources
**Masalah:** CSS dan JS blocking render halaman.

**Solusi:**
- ✅ CSS kritis di-inline di `<head>`
- ✅ CSS non-kritis dimuat async dengan `media="print" onload="this.media='all'"`
- ✅ JS dimuat dengan `defer` attribute
- ✅ Analytics dimuat on interaction (scroll/click/touch)

**File:** `resources/views/layout/WebLayout.blade.php`
```html
<!-- CSS non-kritis async -->
<link rel="stylesheet" href="css/plugins/swiper-bundle.min.css" media="print" onload="this.media='all'">

<!-- JS defer -->
<script src="js/vendor/vendor.min.js" defer></script>
<script src="js/plugins/plugins.min.js" defer></script>
<script src="js/main.js" defer></script>
```

### 3. Lazy Loading Images
**Masalah:** Semua gambar dimuat sekaligus, memperlambat initial load.

**Solusi:**
- ✅ Gambar above-the-fold: `loading="eager"` + `fetchpriority="high"`
- ✅ Gambar below-the-fold: `loading="lazy"`
- ✅ LCP image di-preload

**File:** `resources/views/home.blade.php`
```html
<!-- 4 produk pertama: eager load -->
<img loading="eager" fetchpriority="high" src="product1.webp">

<!-- Produk lainnya: lazy load -->
<img loading="lazy" src="product5.webp">
```

### 4. Network Dependency Tree
**Masalah:** Resource saling bergantung, memperlambat loading.

**Solusi:**
- ✅ Preconnect ke domain eksternal
- ✅ DNS prefetch untuk analytics
- ✅ Minified JS/CSS (vendor.min.js, plugins.min.js)

**File:** `resources/views/layout/WebLayout.blade.php`
```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="dns-prefetch" href="https://www.googletagmanager.com">
```

### 5. Minimize Main-Thread Work
**Masalah:** JavaScript blocking main thread.

**Solusi:**
- ✅ Analytics dimuat on interaction (bukan langsung)
- ✅ JS dimuat dengan `defer`
- ✅ Fallback timeout 5 detik untuk analytics

**File:** `resources/views/layout/WebLayout.blade.php`
```javascript
// Load analytics on user interaction
['scroll','mousemove','touchstart','keydown','click'].forEach(function(evt) {
    window.addEventListener(evt, loadAnalytics, { once: true, passive: true });
});
// Fallback: load after 5 seconds
setTimeout(loadAnalytics, 5000);
```

### 6. Image Optimization
**Masalah:** Gambar terlalu besar dan format tidak optimal.

**Solusi:**
- ✅ Auto-resize gambar saat upload
- ✅ Konversi ke WebP (25-35% lebih kecil)
- ✅ Batasan ukuran:
  - Produk: 1200×1200 px, max 300 KB
  - Logo: 400×200 px, max 50 KB
  - Banner: 1440×600 px, max 150 KB

**File:** `app/Http/Controllers/ProductController.php`, dll
```php
private function resizeAndSaveWebp($sourcePath, $savePath, $maxWidth, $maxHeight, $quality)
{
    // Auto-resize dan save as WebP
}
```

### 7. Lazy Load Shimmer Effect Removed
**Masalah:** Shimmer loading menyebabkan layout shift dan forced reflow.

**Solui:**
- ✅ Hapus shimmer animation
- ✅ Background transparan untuk lazy images

**File:** `resources/views/home.blade.php`
```css
/* Sebelum: shimmer animation */
img[loading="lazy"] {
    background: #f0f0f0;
    animation: shimmer 1.5s infinite;
}

/* Sesudah: transparan */
img[loading="lazy"] {
    background: transparent;
}
```

## 📊 Optimasi Tambahan yang Sudah Ada

### 8. Batasan Jumlah Gambar di Homepage
- ✅ Produk: 8 per kategori (bukan semua produk)
- ✅ Logo mitra: 12 logo (6 BUMN + 6 Organization)

**File:** `app/Http/Controllers/Controller.php`

### 9. Video Lazy Load
- ✅ Video hero tidak autoplay
- ✅ Poster statis dimuat duluan
- ✅ Video dimuat saat masuk viewport

**File:** `resources/views/home.blade.php`

### 10. Pagination dengan Horizontal Scroll
- ✅ 12 produk per halaman (3×4 grid)
- ✅ Smooth scroll pagination
- ✅ Snap scroll untuk UX lebih baik

## 🚀 Rekomendasi Tambahan (Belum Diterapkan)

### A. Reduce Unused CSS
**Cara:**
1. Gunakan PurgeCSS untuk hapus CSS yang tidak dipakai
2. Split CSS per halaman (home.css, shop.css, dll)

**Command:**
```bash
npm install -D @fullhuman/postcss-purgecss
```

**Config:** `postcss.config.js`
```javascript
module.exports = {
  plugins: [
    require('@fullhuman/postcss-purgecss')({
      content: ['./resources/views/**/*.blade.php'],
      defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
    })
  ]
}
```

### B. Reduce Unused JavaScript
**Cara:**
1. Code splitting dengan Webpack/Vite
2. Dynamic import untuk fitur yang jarang dipakai
3. Tree shaking untuk hapus dead code

**Contoh:**
```javascript
// Sebelum: load semua
import Swiper from 'swiper';

// Sesudah: load on demand
const loadSwiper = () => import('swiper').then(module => module.default);
```

### C. Enable Text Compression (Server-side)
**Cara:** Aktifkan Gzip/Brotli di server

**Nginx:**
```nginx
gzip on;
gzip_types text/css application/javascript image/svg+xml;
gzip_min_length 1000;
```

**Apache (.htaccess):**
```apache
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/css application/javascript
</IfModule>
```

### D. Browser Caching
**Cara:** Set cache headers di server

**Nginx:**
```nginx
location ~* \.(jpg|jpeg|png|webp|gif|svg|css|js|woff2)$ {
    expires 1y;
    add_header Cache-Control "public, immutable";
}
```

**Apache (.htaccess):**
```apache
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/webp "access plus 1 year"
  ExpiresByType text/css "access plus 1 year"
  ExpiresByType application/javascript "access plus 1 year"
</IfModule>
```

### E. CDN untuk Static Assets
**Cara:** Upload CSS, JS, images ke CDN (Cloudflare, BunnyCDN, dll)

**Benefit:**
- Faster delivery (edge servers)
- Reduce server load
- Better caching

### F. HTTP/2 atau HTTP/3
**Cara:** Aktifkan di server hosting

**Benefit:**
- Multiplexing (parallel requests)
- Header compression
- Server push

## 📈 Expected Performance Improvement

Setelah optimasi ini:
- ✅ **LCP (Largest Contentful Paint):** < 2.5s
- ✅ **FID (First Input Delay):** < 100ms
- ✅ **CLS (Cumulative Layout Shift):** < 0.1
- ✅ **TBT (Total Blocking Time):** < 300ms
- ✅ **Speed Index:** < 3.4s

## 🔧 Testing Tools

1. **PageSpeed Insights:** https://pagespeed.web.dev/
2. **GTmetrix:** https://gtmetrix.com/
3. **WebPageTest:** https://www.webpagetest.org/
4. **Chrome DevTools:** Lighthouse tab

## 📝 Maintenance

### Regular Checks:
- ✅ Test PageSpeed setiap deploy
- ✅ Monitor image sizes (jangan upload gambar > 2MB)
- ✅ Jalankan `php artisan images:convert-webp` untuk gambar baru
- ✅ Clear cache setelah update CSS/JS

### Commands:
```bash
# Konversi gambar lama ke WebP
php artisan images:convert-webp

# Update database records
php artisan db:update-images-webp

# Clear cache
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

## ✅ Summary

**Sudah Diterapkan:**
1. ✅ Font display swap
2. ✅ Async CSS loading
3. ✅ Defer JS loading
4. ✅ Lazy load images
5. ✅ WebP conversion
6. ✅ Image resize
7. ✅ Analytics on interaction
8. ✅ Preconnect/DNS prefetch
9. ✅ Remove shimmer effect
10. ✅ Batasan jumlah gambar

**Perlu Diterapkan di Server:**
- ⏳ Text compression (Gzip/Brotli)
- ⏳ Browser caching headers
- ⏳ HTTP/2 atau HTTP/3

**Optional (Advanced):**
- ⏳ PurgeCSS untuk unused CSS
- ⏳ Code splitting untuk unused JS
- ⏳ CDN untuk static assets
