<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function AllBlog()
    {
        $categories = BlogCategory::with('blogs')->latest()->get();
        $blogs = Blog::latest()->paginate(6);
        return view('frontend.blog.all_blog', compact('categories', 'blogs'));
    }

    public function CategoryBlogs($categoryslug)
    {
        $category = BlogCategory::where('blog_category_slug', $categoryslug)->first();

        if ($category) {
            $categories = BlogCategory::with('blogs')->latest()->get();
            $blogs = $category->blogs()->latest()->paginate(6);
            return view('frontend.blog.all_blog', compact('categories', 'category', 'blogs'));
        }

        return redirect()->route('all.blogs')->with('error', 'Category not found.');
    }

    // Method to display a single blog's details
    public function BlogDetails($categoryslug, $blogslug)
    {
        $category = BlogCategory::where('blog_category_slug', $categoryslug)->first();

        $blog = Blog::where('blog_slug', $blogslug)->where('category_id', $category->id)->first();

        if ($blog) {
            return view('frontend.blog.blog_details', compact('blog', 'category'));
        }

        return redirect()->route('all.blogs')->with('error', 'Blog not found.');
    }
}
