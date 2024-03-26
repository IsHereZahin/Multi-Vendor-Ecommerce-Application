<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Support\Facades\File;
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

    public function EditBrand($id)
    {
        $brand = Brand::findorfail($id);
        return view('admin.brand.edit_brand', compact('brand'));
    }

    public function UpdateBrand(Request $request)
    {
        $request->validate([
            'name' =>'required|string|max:255',
            'image' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = Brand::findorfail($request->id);

        // Check if a new image is uploaded
        if($request->hasFile('image')) {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/brands'), $image);

            // Delete old image if it exists
            if(File::exists(public_path('upload/brands/'.$brand->image))) {
                File::delete(public_path('upload/brands/'.$brand->image));
            }
        } else {
            // No new image uploaded, keep the old one
            $image = $brand->image;
        }

        // Update brand details
        $brand->update([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'image' => $image,
        ]);

        $notification = array(
            'alert-type'=> 'info',
            'message'   => 'Brand Updated Successfully!'
        );

        return redirect()->route('all.brand')->with($notification);
    }

    public function DeleteBrand($id)
    {
        $brand = Brand::findOrFail($id);

        // Delete associated image if it exists
        if(File::exists(public_path('upload/brands/'.$brand->image))) {
            File::delete(public_path('upload/brands/'.$brand->image));
        }

        $brand->delete();

        $notification = array(
            'alert-type'=> 'warning',
            'message'   => 'Brand Deleted Successfully!'
        );

        return redirect()->route('all.brand')->with($notification);
    }
}
