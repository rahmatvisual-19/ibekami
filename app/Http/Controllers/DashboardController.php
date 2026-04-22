<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use App\Models\Partnership;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $clickCount = Type::withSum('products as total_clicks', 'click_count')
                    ->orderBy('total_clicks', 'desc')
                    ->get(['id', 'name', 'total_clicks']);
        
        $orderClickCount = Type::withSum('products as total_clicks', 'order_click_count')
                        ->orderBy('total_clicks', 'desc')
                        ->get(['id', 'name', 'total_clicks']);
                        
        $totalProduct = Product::count();
        $totalPartner = Partnership::count();

        return view('backend.pages.index', compact('clickCount', 'products', 'orderClickCount', 'totalProduct', 'totalPartner'));
    }
}