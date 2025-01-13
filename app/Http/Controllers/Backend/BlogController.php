<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->get();
        return view('backend.blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('backend.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:blog_categories,id',
            'blog_title' => 'required|string|max:255|unique:blogs,blog_title',
            'blog_short_description' => 'required|string|max:500',
            'blog_long_description' => 'required|string',
            'blog_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $slug = Str::slug($request->blog_title, '-');
        $slugCount = Blog::where('blog_slug', $slug)->count();
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }

        $imagePath = null;
        if ($request->hasFile('blog_image')) {
            $imageName = time() . '-' . Str::slug($request->blog_title, '-') . '.' . $request->blog_image->extension();
            $imagePath = $request->file('blog_image')->move(public_path('upload/blog_images'), $imageName);
        }

        Blog::create([
            'category_id' => $request->category_id,
            'blog_title' => $request->blog_title,
            'blog_slug' => $slug,
            'blog_short_description' => $request->blog_short_description,
            'blog_long_description' => $request->blog_long_description,
            'blog_image' => 'upload/blog_images/' . $imageName,
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Blog Created Successfully!');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::all();
        return view('backend.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:blog_categories,id',
            'blog_title' => 'required|string|max:255|unique:blogs,blog_title,' . $id,
            'blog_short_description' => 'required|string|max:500',
            'blog_long_description' => 'required|string',
            'blog_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $blog = Blog::findOrFail($id);
        $slug = Str::slug($request->blog_title, '-');
        $slugCount = Blog::where('blog_slug', $slug)->where('id', '!=', $id)->count();
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }

        if ($request->hasFile('blog_image')) {
            if ($blog->blog_image && File::exists(public_path($blog->blog_image))) {
                File::delete(public_path($blog->blog_image));
            }

            $imageName = time() . '-' . Str::slug($request->blog_title, '-') . '.' . $request->blog_image->extension();
            $imagePath = $request->file('blog_image')->move(public_path('upload/blog_images'), $imageName);
            $blog->blog_image = 'upload/blog_images/' . $imageName;
        }

        $blog->update([
            'category_id' => $request->category_id,
            'blog_title' => $request->blog_title,
            'blog_slug' => $slug,
            'blog_short_description' => $request->blog_short_description,
            'blog_long_description' => $request->blog_long_description,
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Blog Updated Successfully!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->blog_image && File::exists(public_path($blog->blog_image))) {
            File::delete(public_path($blog->blog_image));
        }

        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog Deleted Successfully!');
    }
}
