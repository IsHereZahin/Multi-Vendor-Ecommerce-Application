@extends('admin.components.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">States</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page">All States (<span style="color: rgb(0, 119, 255);">{{ count($states) }}</span>)</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStateModal">Add State</button>
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
                                <th>State Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($states as $key => $state)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $state->division->division_name }}</td>
                                    <td>{{ $state->district->district_name }}</td>
                                    <td>{{ $state->state_name }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editStateModal" data-id="{{ $state->id }}" data-division="{{ $state->division_id }}" data-district="{{ $state->district_id }}" data-name="{{ $state->state_name }}">Edit</button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('delete.state', $state->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the state: {{ $state->state_name }}?')">Delete</button>
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

    <!-- Modal for Adding State -->
    <div class="modal fade" id="addStateModal" tabindex="-1" aria-labelledby="addStateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStateModalLabel">Add State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store.state') }}" method="POST">
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
                            <label for="district_id" class="form-label">Select District</label>
                            <select name="district_id" id="district_id" class="form-control" required>
                                <option value="">Select District</option>
                            </select>
                            @error('district_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="state_name" class="form-label">State Name</label>
                            <input type="text" class="form-control" id="state_name" name="state_name" value="{{ old('state_name') }}" required>
                            @error('state_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Add State</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing State -->
    <div class="modal fade" id="editStateModal" tabindex="-1" aria-labelledby="editStateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStateModalLabel">Edit State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="editStateForm">
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
                            <label for="edit_district_id" class="form-label">Select District</label>
                            <select name="district_id" id="edit_district_id" class="form-control" required>
                                <option value="">Select District</option>
                            </select>
                            @error('district_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="edit_state_name" class="form-label">State Name</label>
                            <input type="text" class="form-control" id="edit_state_name" name="state_name" required>
                            @error('state_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update State</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle dynamic loading of districts based on selected division
        document.getElementById('division_id').addEventListener('change', function () {
            var divisionId = this.value;
            var districtSelect = document.getElementById('district_id');
            districtSelect.innerHTML = '<option value="">Select District</option>'; // Reset districts

            if (divisionId) {
                fetch('/get-districts/' + divisionId)
                    .then(response => response.json())
                    .then(data => {
                        data.districts.forEach(district => {
                            var option = document.createElement('option');
                            option.value = district.id;
                            option.textContent = district.district_name;
                            districtSelect.appendChild(option);
                        });
                    });
            }
        });

        // Handle dynamic loading of districts when editing state
        const editStateModal = document.getElementById('editStateModal');
        editStateModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var divisionId = button.getAttribute('data-division');
            var districtId = button.getAttribute('data-district');
            var stateName = button.getAttribute('data-name');

            // Set the values in the edit modal form
            document.getElementById('edit_state_name').value = stateName;
            document.getElementById('edit_division_id').value = divisionId;

            // Load districts for the selected division
            fetch('/get-districts/' + divisionId)
                .then(response => response.json())
                .then(data => {
                    var districtSelect = document.getElementById('edit_district_id');
                    districtSelect.innerHTML = '<option value="">Select District</option>';

                    data.districts.forEach(district => {
                        var option = document.createElement('option');
                        option.value = district.id;
                        option.textContent = district.district_name;
                        if (district.id == districtId) {
                            option.selected = true;
                        }
                        districtSelect.appendChild(option);
                    });
                });

            // Set the form action URL to the update route
            var form = document.getElementById('editStateForm');
            form.action = '{{ route('update.state', ['id' => '__ID__']) }}'.replace('__ID__', button.getAttribute('data-id'));
        });
    </script>
@endsection
