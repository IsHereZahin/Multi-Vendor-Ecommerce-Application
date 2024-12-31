@extends('admin.components.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Divisions</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page">All Divisions (<span style="color: rgb(0, 119, 255);">{{ count($divisions) }}</span>)</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDivisionModal">Add Division</button>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                                <th>Division Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($divisions as $key => $division)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $division->division_name }}</td>
                                    <td>
                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editDivisionModal" data-id="{{ $division->id }}" data-name="{{ $division->division_name }}">Edit</button>

                                        <form action="{{ route('delete.division', $division->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the division: {{ $division->division_name }}?')">Delete</button>
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

    <!-- Modal for Adding Division -->
    <div class="modal fade" id="addDivisionModal" tabindex="-1" aria-labelledby="addDivisionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDivisionModalLabel">Add Division</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store.division') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="division_name" class="form-label">Division Name</label>
                            <input type="text" class="form-control" id="division_name" name="division_name" value="{{ old('division_name') }}" required>
                            @error('division_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add Division</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Division -->
    <div class="modal fade" id="editDivisionModal" tabindex="-1" aria-labelledby="editDivisionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDivisionModalLabel">Edit Division</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="editDivisionForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_division_name" class="form-label">Division Name</label>
                            <input type="text" class="form-control" id="edit_division_name" name="division_name" required>
                            @error('division_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Division</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const editDivisionModal = document.getElementById('editDivisionModal');
        editDivisionModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var divisionId = button.getAttribute('data-id');
            var divisionName = button.getAttribute('data-name');

            // Set the values in the edit modal form
            document.getElementById('edit_division_name').value = divisionName;

            // Set the form action URL to the update route
            var form = document.getElementById('editDivisionForm');
            form.action = '{{ route('update.division', ['id' => '__ID__']) }}'.replace('__ID__', divisionId);
        })
    </script>
@endsection
