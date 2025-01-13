@extends('admin.components.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Blog Categories</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page">All Blog Categories (<span style="color: rgb(0, 119, 255);">{{ count($categories) }}</span>)</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Blog Category</button>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        @if(session('message'))
            <div class="alert alert-{{ session('alert-type') }} mt-3">
                {{ session('message') }}
            </div>
        @endif

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Category Name</th>
                                <th>Category Slug</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $category->blog_category_name }}</td>
                                    <td>{{ $category->blog_category_slug }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                                data-id="{{ $category->id }}"
                                                data-name="{{ $category->blog_category_name }}"
                                                data-slug="{{ $category->blog_category_slug }}">
                                            Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.blog.category.delete', $category->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the category: {{ $category->blog_category_name }}?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Blog Category -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Blog Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.blog.category.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="blog_category_name" value="{{ old('blog_category_name') }}" required>
                            @error('blog_category_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Blog Category -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Blog Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="editCategoryForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="edit_category_name" name="blog_category_name" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle dynamic loading of category data when editing
        const editCategoryModal = document.getElementById('editCategoryModal');
        editCategoryModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var categoryId = button.getAttribute('data-id');
            var categoryName = button.getAttribute('data-name');

            // Set the values in the edit modal form
            document.getElementById('edit_category_name').value = categoryName;

            // Set the form action URL to the update route
            var form = document.getElementById('editCategoryForm');
            form.action = '{{ route('admin.blog.category.update', ['id' => '__ID__']) }}'.replace('__ID__', categoryId);
        });
    </script>
@endsection
