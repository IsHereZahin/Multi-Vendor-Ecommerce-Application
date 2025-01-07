@extends('user.user_dashboard_master')

@section('user-dashboard')
<div class="tab-pane fade show active" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
    <div class="card">
        <div class="card-header">
            <h5>Change Password</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('user.password.update') }}">
                @csrf
                <div class="row">
                    <!-- Old Password -->
                    <div class="form-group col-md-12">
                        <label for="old_password">Old Password <span class="required">*</span></label>
                        <input
                            type="password"
                            name="old_password"
                            class="form-control"
                            id="old_password"
                            placeholder="Enter your current password"
                            required />
                    </div>

                    <!-- New Password -->
                    <div class="form-group col-md-12">
                        <label for="new_password">New Password <span class="required">*</span></label>
                        <input
                            type="password"
                            name="new_password"
                            class="form-control"
                            id="new_password"
                            placeholder="Enter a new password"
                            required />
                    </div>

                    <!-- Confirm New Password -->
                    <div class="form-group col-md-12">
                        <label for="new_password_confirmation">Confirm New Password <span class="required">*</span></label>
                        <input
                            type="password"
                            name="new_password_confirmation"
                            class="form-control"
                            id="new_password_confirmation"
                            placeholder="Re-enter the new password"
                            required />
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-12">
                        <button
                            type="submit"
                            class="btn btn-fill-out submit font-weight-bold"
                            name="submit"
                            value="Submit">
                            Change Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
