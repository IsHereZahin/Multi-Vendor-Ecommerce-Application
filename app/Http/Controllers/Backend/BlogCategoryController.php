<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    // Show all blog categories
    public function index()
    {
        $categories = BlogCategory::all();  // Get all blog categories
        return view('backend.blog.categories.index', compact('categories'));
    }

    // Store a new blog category
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'blog_category_name' => 'required|string|max:255|unique:blog_categories,blog_category_name',
        ]);

        // Generate a slug from the category name
        $slug = Str::slug($request->blog_category_name, '-');

        // Create the new category with the auto-generated slug
        BlogCategory::create([
            'blog_category_name' => $validatedData['blog_category_name'],
            'blog_category_slug' => $slug,
        ]);

        // Redirect with a success message
        return redirect()->route('admin.blog.category.index')
            ->with('message', 'Category added successfully!')
            ->with('alert-type', 'success');
    }

    // Update an existing blog category
    public function update(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);

        // Validate the incoming request
        $validatedData = $request->validate([
            'blog_category_name' => 'required|string|max:255|unique:blog_categories,blog_category_name,' . $id,
        ]);

        // Generate a slug from the updated category name
        $slug = Str::slug($request->blog_category_name, '-');

        // Update the category with the new name and slug
        $category->update([
            'blog_category_name' => $validatedData['blog_category_name'],
            'blog_category_slug' => $slug,
        ]);

        // Redirect with a success message
        return redirect()->route('admin.blog.category.index')
            ->with('message', 'Category updated successfully!')
            ->with('alert-type', 'success');
    }

    // Delete a blog category
    public function destroy($id)
    {
        $category = BlogCategory::findOrFail($id);

        // Delete the category
        $category->delete();

        // Redirect with a success message
        return redirect()->route('admin.blog.category.index')
            ->with('message', 'Category deleted successfully!')
            ->with('alert-type', 'success');
    }
}
