@extends('user.user_dashboard_master')

@section('user-dashboard')
<div class="tab-pane fade show active" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
    <div class="card">
        <div class="card-header">
            <h5>Account Details</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Username (disabled field) -->
                    <div class="form-group col-md-6">
                        <label for="username">Username <span class="required">*</span></label>
                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            value="{{ $userdata->username }}"
                            disabled
                            id="username" />
                    </div>

                    <!-- Name field -->
                    <div class="form-group col-md-6">
                        <label for="name">Name <span class="required">*</span></label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ $userdata->name }}"
                            id="name" />
                    </div>

                    <!-- Email field -->
                    <div class="form-group col-md-12">
                        <label for="email">Email <span class="required">*</span></label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ $userdata->email }}"
                            id="email" />
                    </div>

                    <!-- Phone field -->
                    <div class="form-group col-md-12">
                        <label for="phone">Phone <span class="required">*</span></label>
                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ $userdata->phone }}"
                            id="phone" />
                    </div>

                    <!-- Address field -->
                    <div class="form-group col-md-12">
                        <label for="address">Address <span class="required">*</span></label>
                        <input
                            type="text"
                            name="address"
                            class="form-control"
                            value="{{ $userdata->address }}"
                            id="address" />
                    </div>

                    <!-- User Photo upload -->
                    <div class="form-group col-md-12">
                        <label for="photo">User Photo <span class="required">*</span></label>
                        <input
                            type="file"
                            name="photo"
                            class="form-control"
                            id="image" />
                    </div>

                    <!-- User photo preview -->
                    <div class="form-group col-md-12">
                        <label>&nbsp;</label>
                        <img
                            id="showImage"
                            src="{{ (!empty($userdata->photo)) ? url('upload/user/user/'.$userdata->photo) : url('adminbackend/assets/images/no_image.jpg') }}"
                            alt="User Photo"
                            class="rounded-circle p-1 bg-primary"
                            width="110" />
                    </div>

                    <!-- Save Change button -->
                    <div class="col-md-12">
                        <button
                            type="submit"
                            class="btn btn-fill-out submit font-weight-bold"
                            name="submit"
                            value="Submit">
                            Save Change
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
