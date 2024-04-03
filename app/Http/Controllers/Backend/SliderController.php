<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public function AllSlider()
    {
        $sliders = Slider::latest()->get();
        return view('backend.slider.all_Slider', compact('sliders'));
    }

    public function AddSlider(){
        return view('backend.slider.add_Slider');
    }

    public function StoreSlider(Request $request)
    {
        $request->validate([
            'title'    =>'required',
            'short_title' =>'required',
            'image'   =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = null;
        if (!empty($request->image)){
            $image = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload/sliders'), $image);
        }

        Slider::query()->create([
            'title' => $request->title,
            'short_title' => $request->short_title,
            'image' => $image,
        ]);

        $notification = array(
            'alert-type'=> 'success',
            'message'   => 'Slider Added Successfully!'
        );

        return redirect()->route('all.slider')->with($notification);
    }

    public function EditSlider($id)
    {
        $slider = Slider::findorfail($id);
        return view('backend.slider.edit_Slider', compact('slider'));
    }

    public function UpdateSlider(Request $request)
    {
        $request->validate([
            'title' =>'required',
            'short_title' =>'required',
            'image' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $slider = Slider::findorfail($request->id);

        // Check if a new image is uploaded
        if($request->hasFile('image')) {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/sliders'), $image);

            // Delete old image if it exists
            if(File::exists(public_path('upload/sliders/'.$slider->image))) {
                File::delete(public_path('upload/sliders/'.$slider->image));
            }
        } else {
            // No new image uploaded, keep the old one
            $image = $slider->image;
        }

        // Update Slider details
        $slider->update([
            'title' => $request->title,
            'short_title' => $request->short_title,
            'image' => $image,
        ]);

        $notification = array(
            'alert-type'=> 'info',
            'message'   => 'Slider Updated Successfully!'
        );

        return redirect()->route('all.slider')->with($notification);
    }

    public function DeleteSlider($id)
    {
        $slider = Slider::findOrFail($id);

        // Delete associated image if it exists
        if(File::exists(public_path('upload/sliders/'.$slider->image))) {
            File::delete(public_path('upload/sliders/'.$slider->image));
        }

        $slider->delete();

        $notification = array(
            'alert-type'=> 'warning',
            'message'   => 'Slider Deleted Successfully!'
        );

        return redirect()->route('all.slider')->with($notification);
    }

}
