<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSEO;
use Illuminate\Http\Request;

class SiteSEOController extends Controller
{
        // Display SEO settings form
    public function AdminSeoSetting()
    {
        $seo = SiteSEO::first();

        if (!$seo) {
            // Create default SEO settings if not present
            $seo = SiteSEO::create([
                'meta_title' => 'Default Meta Title',
                'meta_author' => 'Default Author',
                'meta_keyword' => 'E-commerce Website, Online Shopping, Buy Products Online, Best Deals Online, Affordable Products, Shop Now, Free Shipping, Discounted Products, Online Store, Top Quality Products, Buy Electronics Online, Fashion and Apparel, Home Goods Store, Affordable Clothing, Tech Gadgets for Sale, Beauty and Skincare Products, Grocery Delivery, Pet Supplies Online, Home Appliances Store, Luxury Watches for Sale, Customer Reviews, Fast Delivery, Secure Payment Options, Worldwide Shipping, Shop Now and Save, Exclusive Offers, Best Online Deals, Shop Top Brands, Premium Quality Products, Best Price Guarantee',
                'meta_description' => 'Default Meta Description',
                'og_type' => 'website',
                'og_url' => url('/'),
                'og_image' => url('default_image.jpg'),
            ]);
        }

        return view('backend.seo.index', compact('seo'));
    }

    // Update SEO settings
    public function UpdateSeoSetting(Request $request)
    {
        $seo = SiteSEO::first();

        if (!$seo) {
            return redirect()->route('admin.seo.setting')->with('error', 'No SEO settings found to update.');
        }

        $seo->meta_title = $request->meta_title ?? $seo->meta_title;
        $seo->meta_author = $request->meta_author ?? $seo->meta_author;
        $seo->meta_keyword = $request->meta_keyword ?? $seo->meta_keyword;
        $seo->meta_description = $request->meta_description ?? $seo->meta_description;
        $seo->og_type = $request->og_type ?? $seo->og_type;
        $seo->og_url = $request->og_url ?? $seo->og_url;
        $seo->og_image = $request->og_image ?? $seo->og_image;

        // Save updated SEO settings
        $seo->save();

        $notification = array(
            'alert-type' => 'success',
            'message' => 'SEO settings updated successfully.'
        );

        return redirect()->route('admin.seo.setting')->with($notification);
    }

    // Reset SEO settings to default values
    public function ResetSeoSetting()
    {
        $defaultSettings = [
            'meta_title' => 'Default Meta Title',
            'meta_author' => 'Default Author',
            'meta_keyword' => 'E-commerce Website, Online Shopping, Buy Products Online, Best Deals Online, Affordable Products, Shop Now, Free Shipping, Discounted Products, Online Store, Top Quality Products, Buy Electronics Online, Fashion and Apparel, Home Goods Store, Affordable Clothing, Tech Gadgets for Sale, Beauty and Skincare Products, Grocery Delivery, Pet Supplies Online, Home Appliances Store, Luxury Watches for Sale, Customer Reviews, Fast Delivery, Secure Payment Options, Worldwide Shipping, Shop Now and Save, Exclusive Offers, Best Online Deals, Shop Top Brands, Premium Quality Products, Best Price Guarantee',
            'meta_description' => 'Default Meta Description',
            'og_type' => 'website',
            'og_url' => url('/'),
            'og_image' => url('default_image.jpg'),
        ];

        $seo = SiteSEO::first();

        if (!$seo) {
            // Create the default SEO settings if none exist
            SiteSEO::create($defaultSettings);
        } else {
            // Reset to default values
            $seo->update($defaultSettings);
        }
        $notification = array(
            'alert-type' => 'info',
            'message' => 'SEO settings have been reset to default values.'
        );
        return redirect()->route('admin.seo.setting')->with($notification);
    }
}

