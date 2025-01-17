<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home()
    {
        return view('frontend.index');
    }

    // Handle regular search request (form submission)
    public function ProductSearch(Request $request)
    {
        $request->validate([
            'search' => 'required',
        ]);

        $item = $request->input('search');
        $categoryId = $request->input('category');

        // Search and filter by category if selected
        $products = Product::where('status', 1)
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->where('product_name', 'LIKE', "%{$item}%")
            ->get();

        return view('frontend.product.search_results', compact('item', 'products'));
    }

    // Handle AJAX search request
    public function AjaxProductSearch(Request $request)
    {
        $request->validate([
            'search' => 'required',
        ]);

        $item = $request->input('search');
        $categoryId = $request->input('category');

        // Search and filter by category if selected
        $products = Product::where('status', 1)
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->where('product_name', 'LIKE', "%{$item}%")
            ->get();

        return response()->json($products);
    }

    public function ProductDetails($id, $slug)
    {
        $product = Product::where('status', 1)->findOrFail($id);

        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        $cat_id = $product->category_id;
        $relatedProducts = Product::where('category_id',$cat_id)->where('id','!=',$id)->where('status', 1)->orderBy('id','DESC')->limit(4)->get();

        return view('frontend.product.product_details', compact('product', 'product_size', 'product_color', 'relatedProducts'));
    }

    public function CategoryProduct($id)
    {
        $products = Product::where('category_id', $id)->where('status', 1)->latest()->get();
        $productCount = $products->count();
        return view('frontend.product.category_product',compact('products', 'productCount'));
    }

    public function SubCategoryProduct($id)
    {
        $products = Product::where('subcategory_id', $id)->where('status', 1)->latest()->get();
        $productCount = $products->count();
        return view('frontend.product.subcategory_product',compact('products', 'productCount'));
    }
}
