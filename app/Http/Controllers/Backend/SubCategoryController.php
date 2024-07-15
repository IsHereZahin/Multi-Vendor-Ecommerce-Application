<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function Allsubcategory()
    {
        $subcategories = SubCategory::latest()->get();
        return view('admin.category.sub_category.all_subcategory', compact('subcategories'));
    }

    public function Addsubcategory(){
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('admin.category.sub_category.add_subcategory', compact('categories'));
    }

    public function Storesubcategory(Request $request)
    {
        $request->validate([
            'category_id'   => 'required',
            'name'          =>'required',
        ]);


        SubCategory::query()->create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
        ]);

        $notification = array(
            'alert-type'=> 'success',
            'message'   => 'SubCategory Added Successfully!'
        );

        return redirect()->route('all.subcategory')->with($notification);
    }

    public function Editsubcategory($id)
    {
        $subcategory = SubCategory::findorfail($id);
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('admin.category.sub_category.edit_subcategory', compact('subcategory', 'categories'));
    }

    public function Updatesubcategory(Request $request)
    {
        $request->validate([
            'category_id'   => 'required',
            'name'          =>'required',
        ]);

        $subcategory = SubCategory::findorfail($request->id);


        // Update subcategory details
        $subcategory->update([
            'category_id'   => $request->category_id,
            'name'          => $request->name,
            'slug'          => strtolower(str_replace(' ', '-', $request->name)),
        ]);

        $notification = array(
            'alert-type'=> 'info',
            'message'   => 'SubCategory Updated Successfully!'
        );

        return redirect()->route('all.subcategory')->with($notification);
    }

    public function Deletesubcategory($id)
    {
        $subcategory = SubCategory::findorfail($id);
        $subcategory->delete();

        $notification = array(
            'alert-type'=> 'warning',
            'message'   => 'SubCategory Deleted Successfully!'
        );

        return redirect()->route('all.subcategory')->with($notification);
    }


    public function getSubcategories($categoryId) {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }
}
