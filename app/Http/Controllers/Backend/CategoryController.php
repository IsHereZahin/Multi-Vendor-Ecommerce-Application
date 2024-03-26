<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function AllCategory()
    {
        $categories = Category::latest()->get();
        return view('admin.category.all_category', compact('categories'));
    }

    public function AddCategory(){
        return view('admin.category.add_category');
    }

    public function StoreCategory(Request $request)
    {
        $request->validate([
            'name'    =>'required',
            'image'   =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = null;
        if (!empty($request->image)){
            $image = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload/categories'), $image);
        }

        Category::query()->create([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'image' => $image,
        ]);

        $notification = array(
            'alert-type'=> 'success',
            'message'   => 'Category Added Successfully!'
        );

        return redirect()->route('all.category')->with($notification);
    }

    public function EditCategory($id)
    {
        $category = Category::findorfail($id);
        return view('admin.category.edit_category', compact('category'));
    }

    public function UpdateCategory(Request $request)
    {
        $request->validate([
            'name' =>'required|string|max:255',
            'image' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = Category::findorfail($request->id);

        // Check if a new image is uploaded
        if($request->hasFile('image')) {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/categories'), $image);

            // Delete old image if it exists
            if(File::exists(public_path('upload/categories/'.$category->image))) {
                File::delete(public_path('upload/categories/'.$category->image));
            }
        } else {
            // No new image uploaded, keep the old one
            $image = $category->image;
        }

        // Update Category details
        $category->update([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'image' => $image,
        ]);

        $notification = array(
            'alert-type'=> 'info',
            'message'   => 'Category Updated Successfully!'
        );

        return redirect()->route('all.category')->with($notification);
    }

    public function DeleteCategory($id)
    {
        $category = Category::findOrFail($id);

        // Delete associated image if it exists
        if(File::exists(public_path('upload/categories/'.$category->image))) {
            File::delete(public_path('upload/categories/'.$category->image));
        }

        $category->delete();

        $notification = array(
            'alert-type'=> 'warning',
            'message'   => 'Category Deleted Successfully!'
        );

        return redirect()->route('all.category')->with($notification);
    }
}
