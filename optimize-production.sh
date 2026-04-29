#!/bin/bash

# Script untuk optimasi Laravel di production
# Jalankan setiap kali deploy kode baru

echo "🚀 Starting Laravel Production Optimization..."
echo ""

# Clear semua cache lama
echo "📦 Clearing old caches..."
php artisan optimize:clear
echo "✅ Old caches cleared"
echo ""

# Cache routes
echo "🛣️  Caching routes..."
php artisan route:cache
echo "✅ Routes cached"
echo ""

# Cache config
echo "⚙️  Caching config..."
php artisan config:cache
echo "✅ Config cached"
echo ""

# Cache views
echo "👁️  Caching views..."
php artisan view:cache
echo "✅ Views cached"
echo ""

# Cache events
echo "📡 Caching events..."
php artisan event:cache
echo "✅ Events cached"
echo ""

# Optimize autoloader
echo "🔧 Optimizing autoloader..."
composer install --optimize-autoloader --no-dev --no-interaction
echo "✅ Autoloader optimized"
echo ""

# Clear OPcache (jika tersedia)
if command -v php-fpm &> /dev/null; then
    echo "🔄 Restarting PHP-FPM to clear OPcache..."
    sudo systemctl restart php8.2-fpm 2>/dev/null || sudo systemctl restart php-fpm 2>/dev/null || echo "⚠️  Could not restart PHP-FPM (may need manual restart)"
fi

echo ""
echo "✨ Optimization complete!"
echo ""
echo "📊 Cache status:"
php artisan about --only=cache
