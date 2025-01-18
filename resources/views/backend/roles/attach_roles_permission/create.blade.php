@extends('admin.components.master')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style type="text/css">
        .form-check-label {
            text-transform: capitalize;
        }
    </style>

    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Roles in Permission</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Roles in Permission</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Content -->
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">
                                <form id="myForm" method="post" action="{{ route('store.role.permission') }}">
                                    @csrf
                                    <!-- Role Name Input -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Role Name</h6>
                                        </div>
                                        <div class="form-group col-sm-9 text-secondary">
                                            <input type="text" id="role_name" name="role_name" class="form-control"
                                                required />
                                        </div>
                                    </div>

                                    <!-- Permissions Section -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefaultAll">
                                        <label class="form-check-label" for="flexCheckDefaultAll">Select All
                                            Permissions</label>
                                    </div>
                                    <hr>

                                    <!-- Permission Groups and Individual Permissions -->
                                    @foreach ($permission_groups as $group)
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-check"
                                                    title="Select this to auto-select all related permissions">
                                                    <input class="form-check-input group-checkbox" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label"
                                                        for="flexCheckDefault">{{ $group->group_name }}</label>
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                @php
                                                    $permissions = App\Models\User::getPermissionByGroupName(
                                                        $group->group_name,
                                                    );
                                                @endphp

                                                @foreach ($permissions as $permission)
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="permission[]" type="checkbox"
                                                            value="{{ $permission->id }}"
                                                            id="flexCheckDefault{{ $permission->id }}">
                                                        <label class="form-check-label"
                                                            for="flexCheckDefault{{ $permission->id }}">{{ $permission->name }}</label>
                                                    </div>
                                                @endforeach
                                                <br>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Submit Button -->
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
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
            // Select/Unselect all permissions
            $('#flexCheckDefaultAll').on('click', function() {
                const isChecked = $(this).is(':checked');
                $('input[type="checkbox"]').prop('checked', isChecked);
            });

            // Select/deselect group-related permissions
            $('.group-checkbox').on('click', function() {
                const isChecked = $(this).is(':checked');
                $(this).closest('.row').find('input[type="checkbox"]:not(.group-checkbox)').prop('checked',
                    isChecked);
            });

            // Uncheck "Permission All" if any individual permission is unchecked
            $('input[type="checkbox"]').not('#flexCheckDefaultAll').on('click', function() {
                if (!$(this).is(':checked')) {
                    $('#flexCheckDefaultAll').prop('checked', false);
                }
            });
        });
    </script>
@endsection
