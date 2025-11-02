<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\PromotionBanner;
use App\Utils\ImageHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    public function index()
    {
        $banner = Banner::getActiveBanner();
        $promotionBanners = PromotionBanner::ordered()->get();
        
        $data = [
            'banner' => $banner,
            'hasBanner' => $banner !== null,
            'promotionBanners' => $promotionBanners,
        ];

        return view('admin.banners', $data);
    }

    // Main Banner Methods
    public function storeBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ImageHandler::getValidationRules(2048, true),
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if a banner already exists
        $existingBanner = Banner::first();
        if ($existingBanner) {
            return redirect()->back()->with('error', 'A banner already exists. Please update the existing banner instead.');
        }

        $data = $request->only(['status']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = ImageHandler::uploadImage(
                $request->file('image'),
                'uploads/banners'
            );
        }

        Banner::create($data);

        Log::info('Banner created');

        return redirect()->route('admin.banners')->with('success', 'Banner created successfully!');
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'image' => ImageHandler::getValidationRules(2048, false),
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['status']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = ImageHandler::uploadImage(
                $request->file('image'),
                'uploads/banners',
                $banner->image
            );
        }

        $banner->update($data);

        Log::info('Banner updated', ['banner_id' => $banner->id]);

        return redirect()->route('admin.banners')->with('success', 'Banner updated successfully!');
    }

    public function deleteBanner($id)
    {
        $banner = Banner::findOrFail($id);
        
        // Delete image file if exists
        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }

        Log::info('Banner deleted', ['banner_id' => $banner->id]);
        
        $banner->delete();

        return redirect()->route('admin.banners')->with('success', 'Banner deleted successfully!');
    }

    public function toggleBannerStatus($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update(['status' => !$banner->status]);

        $status = $banner->status ? 'activated' : 'deactivated';
        Log::info('Banner status toggled', ['banner_id' => $banner->id, 'status' => $banner->status]);
        
        return redirect()->route('admin.banners')->with('success', "Banner {$status} successfully!");
    }

    // Promotion Banner Methods
    public function storePromotionBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => ImageHandler::getValidationRules(2048, true),
            'alt_text' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'status' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['title', 'alt_text', 'link', 'status', 'sort_order']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = ImageHandler::uploadImage(
                $request->file('image'),
                'uploads/promotion-banners'
            );
        }

        // Set default sort order if not provided
        if (!isset($data['sort_order'])) {
            $maxOrder = PromotionBanner::max('sort_order') ?? 0;
            $data['sort_order'] = $maxOrder + 1;
        }

        PromotionBanner::create($data);

        Log::info('Promotion banner created');

        return redirect()->route('admin.banners')->with('success', 'Promotion banner created successfully!');
    }

    public function updatePromotionBanner(Request $request, $id)
    {
        $promotionBanner = PromotionBanner::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => ImageHandler::getValidationRules(2048, false),
            'alt_text' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'status' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['title', 'alt_text', 'link', 'status', 'sort_order']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = ImageHandler::uploadImage(
                $request->file('image'),
                'uploads/promotion-banners',
                $promotionBanner->image
            );
        }

        $promotionBanner->update($data);

        Log::info('Promotion banner updated', ['banner_id' => $promotionBanner->id]);

        return redirect()->route('admin.banners')->with('success', 'Promotion banner updated successfully!');
    }

    public function deletePromotionBanner($id)
    {
        $promotionBanner = PromotionBanner::findOrFail($id);
        
        // Delete image file if exists
        if ($promotionBanner->image && file_exists(public_path($promotionBanner->image))) {
            unlink(public_path($promotionBanner->image));
        }

        Log::info('Promotion banner deleted', ['banner_id' => $promotionBanner->id]);
        
        $promotionBanner->delete();

        return redirect()->route('admin.banners')->with('success', 'Promotion banner deleted successfully!');
    }

    public function togglePromotionBannerStatus($id)
    {
        $promotionBanner = PromotionBanner::findOrFail($id);
        $promotionBanner->update(['status' => !$promotionBanner->status]);

        $status = $promotionBanner->status ? 'activated' : 'deactivated';
        Log::info('Promotion banner status toggled', ['banner_id' => $promotionBanner->id, 'status' => $promotionBanner->status]);
        
        return redirect()->route('admin.banners')->with('success', "Promotion banner {$status} successfully!");
    }
}
