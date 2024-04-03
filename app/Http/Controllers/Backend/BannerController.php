<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function AllBanner()
    {
        $banners = Banner::latest()->get();
        return view('backend.banner.all_banner', compact('banners'));
    }

    public function AddBanner(){
        return view('backend.banner.add_banner');
    }

    public function StoreBanner(Request $request)
    {
        $request->validate([
            'title'    =>'required',
            'url' =>'required',
            'image'   =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = null;
        if (!empty($request->image)){
            $image = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload/banners'), $image);
        }

        Banner::query()->create([
            'title' => $request->title,
            'url' => $request->url,
            'image' => $image,
        ]);

        $notification = array(
            'alert-type'=> 'success',
            'message'   => 'Banner Added Successfully!'
        );

        return redirect()->route('all.banner')->with($notification);
    }

    public function Editbanner($id)
    {
        $banner = banner::findorfail($id);
        return view('backend.banner.edit_banner', compact('banner'));
    }

    public function UpdateBanner(Request $request)
    {
        $request->validate([
            'title' =>'required',
            'url' =>'required',
            'image' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $banner = Banner::findorfail($request->id);

        // Check if a new image is uploaded
        if($request->hasFile('image')) {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/banners'), $image);

            // Delete old image if it exists
            if(File::exists(public_path('upload/banners/'.$banner->image))) {
                File::delete(public_path('upload/banners/'.$banner->image));
            }
        } else {
            // No new image uploaded, keep the old one
            $image = $banner->image;
        }

        // Update banner details
        $banner->update([
            'title' => $request->title,
            'url' => $request->url,
            'image' => $image,
        ]);

        $notification = array(
            'alert-type'=> 'info',
            'message'   => 'Banner Updated Successfully!'
        );

        return redirect()->route('all.banner')->with($notification);
    }

    public function DeleteBanner($id)
    {
        $banner = Banner::findOrFail($id);

        // Delete associated image if it exists
        if(File::exists(public_path('upload/banners/'.$banner->image))) {
            File::delete(public_path('upload/banners/'.$banner->image));
        }

        $banner->delete();

        $notification = array(
            'alert-type'=> 'warning',
            'message'   => 'Banner Deleted Successfully!'
        );

        return redirect()->route('all.banner')->with($notification);
    }

}
