@extends('admin.components.master')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Blog Blog</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Blog Blog</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">

                                <!-- Form for creating a blog post -->
                                <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Category Dropdown -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Blog Category</h6>
                                        </div>
                                        <div class="form-group col-sm-9 text-secondary">
                                            <select name="category_id" class="form-select" id="inputVendor" required>
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->blog_category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Blog Title -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Blog Title</h6>
                                        </div>
                                        <div class="form-group col-sm-9 text-secondary">
                                            <input type="text" name="blog_title" class="form-control" required
                                                value="{{ old('blog_title') }}" />
                                            @if ($errors->has('blog_title'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('blog_title') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Short Description -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Blog Short Description</h6>
                                        </div>
                                        <div class="form-group col-sm-9 text-secondary">
                                            <textarea name="blog_short_description" class="form-control" rows="3" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Long Description -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Blog Long Description</h6>
                                        </div>
                                        <div class="form-group col-sm-9 text-secondary">
                                            <textarea id="mytextarea" name="blog_long_description" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Blog Blog Image</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="file" name="blog_image" class="form-control" id="image"
                                                required />
                                        </div>
                                    </div>

                                    <!-- Display Image Before Upload -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <img id="showImage" style="width:100px; height: 100px;">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <button type="submit" class="btn btn-primary px-4">Save Blog Blog</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            // Display selected image before uploading
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
@endsection
