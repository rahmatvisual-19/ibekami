<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    /**
     * Clear homepage related caches
     */
    public static function clearHomepageCache(): void
    {
        Cache::forget('homepage.products');
        Cache::forget('homepage.categories');
        Cache::forget('homepage.types');
        Cache::forget('homepage.partners');
        Cache::forget('homepage.banners');
        Cache::forget('homepage.testimonies');
        
        // Clear full page cache untuk homepage (semua locale)
        $locales = ['id', 'en'];
        foreach ($locales as $locale) {
            Cache::forget('page.' . $locale . '.' . sha1(url('/')));
        }
    }

    /**
     * Clear product related caches
     */
    public static function clearProductCache(): void
    {
        Cache::forget('homepage.products');
        Cache::forget('homepage.categories');
        
        // Clear full page cache
        self::clearFullPageCache();
    }

    /**
     * Clear partner related caches
     */
    public static function clearPartnerCache(): void
    {
        Cache::forget('homepage.partners');
        self::clearFullPageCache();
    }

    /**
     * Clear banner related caches
     */
    public static function clearBannerCache(): void
    {
        Cache::forget('homepage.banners');
        self::clearFullPageCache();
    }

    /**
     * Clear type/category related caches
     */
    public static function clearTypeCache(): void
    {
        Cache::forget('homepage.types');
        Cache::forget('homepage.categories');
        self::clearFullPageCache();
    }

    /**
     * Clear review/testimony related caches
     */
    public static function clearReviewCache(): void
    {
        Cache::forget('homepage.testimonies');
        self::clearFullPageCache();
    }

    /**
     * Clear all full page caches
     */
    public static function clearFullPageCache(): void
    {
        // Clear semua cache yang dimulai dengan 'page.'
        $locales = ['id', 'en'];
        $urls = [
            url('/'),
            url('/catalogue'),
            url('/machine'),
            url('/privacy-policy'),
        ];

        foreach ($locales as $locale) {
            foreach ($urls as $url) {
                Cache::forget('page.' . $locale . '.' . sha1($url));
            }
        }
    }

    /**
     * Clear all application caches
     */
    public static function clearAllCache(): void
    {
        Cache::flush();
    }
}
