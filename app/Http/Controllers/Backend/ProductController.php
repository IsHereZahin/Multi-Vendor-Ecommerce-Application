<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function AllProduct()
    {
        $products = Product::latest()->get();
        return view('backend.product.product_all',compact('products'));
    } // End Method

    public function AddProduct()
    {
        return view('backend.product.product_add');
    } // End Method
}
