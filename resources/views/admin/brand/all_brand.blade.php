@extends('admin.components.master')
@section('content')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Brand</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All Brand</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.brand') }}">
                    <button type="button" class="btn btn-primary">Add Brand</button>
                </a>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Brand Name </th>
                            <th>Brand Image </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <img src="{{ asset('upload/brands/'.$item->image) }}" style="width: 70px; height: 70px;">
                                </td>
                                <td>
                                    @if (Auth::user()->can('brand.edit'))
                                    <a href="{{ route('edit.brand', $item->id) }}" class="btn btn-info btn-lg">Edit</a>
                                    @endif
                                    @if (Auth::user()->can('brand.delete'))
                                    <form method="POST" action="{{ route('delete.brand', $item->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to delete this brand?')">Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
