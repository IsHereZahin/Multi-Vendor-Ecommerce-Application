@extends('admin.components.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Districts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page">All Districts (<span style="color: rgb(0, 119, 255);">{{ count($districts) }}</span>)</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDistrictModal">Add District</button>
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
                                <th>Division Name</th>
                                <th>District Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($districts as $key => $district)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $district->division->division_name }}</td>
                                    <td>{{ $district->district_name }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editDistrictModal" data-id="{{ $district->id }}" data-division="{{ $district->division_id }}" data-name="{{ $district->district_name }}">Edit</button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('delete.district', $district->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the district: {{ $district->district_name }}?')">Delete</button>
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

    <!-- Modal for Adding District -->
    <div class="modal fade" id="addDistrictModal" tabindex="-1" aria-labelledby="addDistrictModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDistrictModalLabel">Add District</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store.district') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="division_id" class="form-label">Select Division</label>
                            <select name="division_id" id="division_id" class="form-control" required>
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                                @endforeach
                            </select>
                            @error('division_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="district_name" class="form-label">District Name</label>
                            <input type="text" class="form-control" id="district_name" name="district_name" value="{{ old('district_name') }}" required>
                            @error('district_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add District</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing District -->
    <div class="modal fade" id="editDistrictModal" tabindex="-1" aria-labelledby="editDistrictModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDistrictModalLabel">Edit District</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="editDistrictForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_division_id" class="form-label">Select Division</label>
                            <select name="division_id" id="edit_division_id" class="form-control" required>
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                                @endforeach
                            </select>
                            @error('division_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="edit_district_name" class="form-label">District Name</label>
                            <input type="text" class="form-control" id="edit_district_name" name="district_name" required>
                            @error('district_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update District</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const editDistrictModal = document.getElementById('editDistrictModal');
        editDistrictModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var districtId = button.getAttribute('data-id');
            var divisionId = button.getAttribute('data-division');
            var districtName = button.getAttribute('data-name');

            // Set the values in the edit modal form
            document.getElementById('edit_district_name').value = districtName;
            document.getElementById('edit_division_id').value = divisionId;

            // Set the form action URL to the update route
            var form = document.getElementById('editDistrictForm');
            form.action = '{{ route('update.district', ['id' => '__ID__']) }}'.replace('__ID__', districtId);
        })
    </script>
@endsection
