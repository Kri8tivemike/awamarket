<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\PromotionBanner;
use App\Models\WhatsAppSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch the single active banner
        $banner = Banner::getActiveBanner();
        
        // Fetch active promotion banners for the homepage
        $promotionBanners = PromotionBanner::where('status', 1)
                                          ->orderBy('sort_order')
                                          ->get();
        
        // Fetch active categories for the homepage
        $categories = Category::where('is_active', true)
                             ->orderBy('name')
                             ->get();

        // Fetch featured products for the homepage (limit to 8 products)
        $products = Product::with('category')
                          ->where('featured', true)
                          ->orderBy('created_at', 'desc')
                          ->limit(8)
                          ->get();

        return view('pages.home', compact('banner', 'categories', 'products', 'promotionBanners'));
    }

    /**
     * Get WhatsApp settings for API consumption
     */
    public function getWhatsAppSettings()
    {
        $settings = WhatsAppSetting::getSettings();
        
        return response()->json([
            'phone_number' => $settings->phone_number,
            'business_name' => $settings->business_name,
            'welcome_message' => $settings->welcome_message,
            'enable_chat_widget' => $settings->enable_chat_widget
        ]);
    }
}