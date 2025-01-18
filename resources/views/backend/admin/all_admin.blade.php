@extends('admin.components.master')
@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">All Admins</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Admins</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.admin') }}" class="btn btn-primary">Create New Admin</a>
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
                                <th>Profile Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="text-center">Role</th>
                                <th>Last Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $key => $admin)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ asset($admin->photo ? 'upload/user/admin/' . $admin->photo : 'adminbackend/assets/images/no_image.jpg') }}" alt="Profile Image" class="rounded-circle p-1 bg-primary" style="width: 50px; height: 50px;">
                                    </td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->phone }}</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill" style="background-color: {{ $admin->role == 'superadmin' ? '#2d93ff' : ($admin->role == 'admin' ? '#ffbf00' : '#ff7043') }}; color: #fff; padding: 6px 12px;">
                                            {{ ucfirst($admin->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($admin->UserOnline())
                                            <span class="badge badge-pill bg-success text-white">Active Now</span>
                                        @else
                                            @php
                                                $lastSeen = Carbon\Carbon::parse($admin->last_seen);
                                                $hoursDiff = $lastSeen->diffInHours(Carbon\Carbon::now());
                                            @endphp

                                            @if ($hoursDiff > 1)
                                                <span class="badge badge-pill bg-secondary text-white">Offline (Last active:
                                                    {{ $lastSeen->diffForHumans() }})</span>
                                            @else
                                                <span
                                                    class="badge badge-pill bg-warning text-dark">{{ $lastSeen->diffForHumans() }}</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="btn {{ $admin->status == 'active' ? 'btn-success' : 'btn-danger' }} btn-secondary">
                                            {{ ucfirst($admin->status) }}
                                        </span>
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
