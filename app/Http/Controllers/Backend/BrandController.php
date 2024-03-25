<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Image;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function AllBrand()
    {
        $brands = Brand::latest()->get();
        return view('admin.brand.all_brand', compact('brands'));
    }

    public function AddBrand(){
        return view('admin.brand.add_brand');
    }

    public function StoreBrand(Request $request)
    {
        $request->validate([
            'name'    =>'required',
            'image'   =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = null;
        if (!empty($request->image)){
            $image = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload/brands'), $image);
        }

        Brand::query()->create([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'image' => $image,
        ]);

        $notification = array(
            'alert-type'=> 'success',
            'message'   => 'Brand Added Successfully!'
        );

        return redirect()->route('all.brand')->with($notification);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
