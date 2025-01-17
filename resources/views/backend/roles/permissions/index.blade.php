@extends('admin.components.master')
@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">All Permission</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Permission</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('create.permission') }}" class="btn btn-primary">Add Permission</a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Permission Name </th>
                                <th>Group Name </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $key => $item)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->group_name }}</td>
                                    <td>
                                        <a href="{{ route('edit.permission', $item->id) }}" class="btn btn-info">Edit</a>
                                        <form action="{{ route('delete.permission', $item->id) }}" method="POST" style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Permission Name </th>
                                <th>Group Name </th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
