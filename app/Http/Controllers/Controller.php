<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Partnership;
use App\Models\Product;
use App\Models\Review;
use App\Models\Machine;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    public function home()
    {
        // Cache types - jarang berubah (24 jam)
        $types = Cache::remember('homepage.types', 60 * 1440, function () {
            return Type::all();
        });

        // Cache banners - update manual via admin (12 jam)
        $banners = Cache::remember('homepage.banners', 60 * 720, function () {
            return Banner::all();
        });
        
        // Cache partners - maksimal 12 logo (24 jam)
        $partners = Cache::remember('homepage.partners', 60 * 1440, function () {
            return Partnership::take(12)->get();
        });

        $bumnPartner = $partners->where('category', 'BUMN')->take(6);
        $orgPartner  = $partners->where('category', 'Organization')->take(6);

        // Cache categories yang punya produk aktif (6 jam)
        $homeCategories = Cache::remember('homepage.categories', 60 * 360, function () {
            return Category::whereHas('products', function ($q) {
                $q->where('status', 'Aktif')->whereNotNull('activated_at');
            })->orderBy('name')->get();
        });

        // Cache products - 8 per kategori (3 jam)
        $product = Cache::remember('homepage.products', 60 * 180, function () use ($homeCategories) {
            $products = collect();
            foreach ($homeCategories as $category) {
                $categoryProducts = Product::where('status', 'Aktif')
                    ->whereNotNull('activated_at')
                    ->where('category_type', $category->id)
                    ->orderBy('activated_at', 'desc')
                    ->select('product_id', 'name', 'image_url', 'product_type', 'category_type', 'status', 'activated_at')
                    ->take(8)
                    ->get();
                
                $products = $products->merge($categoryProducts);
            }
            return $products;
        });

        // Cache testimonies (12 jam)
        $testimonies = Cache::remember('homepage.testimonies', 60 * 720, function () {
            return Review::all()->map(function ($testimony) {
                $testimony->initial       = strtoupper(substr($testimony->name, 0, 1));
                $testimony->formattedDate = \Illuminate\Support\Carbon::parse($testimony->review_date)->diffForHumans();
                return $testimony;
            });
        });

        return view('home', compact('product', 'types', 'testimonies', 'banners', 'bumnPartner', 'orgPartner', 'homeCategories'));
    }

    public function product($product_id)
    {
        $product = Product::find($product_id);
        $types = Type::all();

        $related_products = Product::where('product_id', '!=', $product_id)
            ->inRandomOrder()
            ->take(10)
            ->get();

        $product->increment('click_count');

        $type_name = Type::find($product->product_type)->name;

        $related_products_count = $related_products->count();

        return view('frontend.page.product', compact('product', 'related_products', 'related_products_count', 'types', 'type_name'));
    }

    public function shop(Request $request)
    {
        $query = Product::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('type')) {
            $query->where('product_type', $request->input('type'));
        }

        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'time_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'time_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->latest();
        }

        $types = Type::all();

        $categories = Category::where('type_id', $request->input('type'))->get();

        $categoryCount = [];
        foreach ($categories as $category) {
            $countQuery = clone $query;

            $countQuery->where('category_type', $category->id);

            $categoryCount[$category->id] = $countQuery->count();
        }

        if ($request->has('category')) {
            $query->where('category_type', $request->input('category'));
        }

        $products = $query->paginate(12);

        $productCount = $products->total();

        return view('frontend.page.shop', compact('products', 'productCount', 'types', 'categories', 'categoryCount'));
    }
    
    public function machine()
    {
        $machine = Machine::all();
        $types = Type::all();

        return view('frontend.page.machine', compact('machine','types'));
    }

    public function privacyPolicy()
    {
        $types = Type::all();
        return view('frontend.page.privacy-policy', compact('types'));
    }
}