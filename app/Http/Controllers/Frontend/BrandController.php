<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function brands(Request $request)
    {
        $search = $request->input('search');

        // Fetch brands based on the search query
        $brands = Brand::when($search, function($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%");
        })->get();

        return view('frontend.brands.index', compact('brands'));
    }

    public function brand_show($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            abort(404);
        }

        $products = $brand->products()->where('status', 1)->latest()->get();
        $productCount = $products->count();

        return view("frontend.brands.brand", compact('brand', 'products', 'productCount'));
    }
}
