@extends('user.user_dashboard_master')

@section('user-dashboard')
<div class="tab-pane fade show active" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
    <div class="card">
        <div class="card-header">
            <h5>Change Password</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('user.password.update') }}" onsubmit="return validatePassword()">
                @csrf
                <div class="row">
                    <!-- Old Password -->
                    <div class="form-group col-md-12">
                        <label for="old_password">Old Password <span class="required">*</span></label>
                        <div class="input-group">
                            <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Enter your current password" required style="border-top: 1px solid #ccc; border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;"/>
                            <div class="input-group-append">
                                <span class="input-group-text" onclick="togglePasswordVisibility('old_password')" style="height: 100%; display: flex; align-items: center; justify-content: center; background-color: transparent; border-top: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc;">
                                    <i class="bi bi-eye-slash" id="old_password_icon" style="font-size: 1.2em;"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="form-group col-md-12">
                        <label for="new_password">New Password <span class="required">*</span></label>
                        <div class="input-group">
                            <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Enter a new password" required style="border-top: 1px solid #ccc; border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;"/>
                            <div class="input-group-append">
                                <span class="input-group-text" onclick="togglePasswordVisibility('new_password')" style="height: 100%; display: flex; align-items: center; justify-content: center; background-color: transparent; border-top: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc;">
                                    <i class="bi bi-eye-slash" id="new_password_icon" style="font-size: 1.2em;"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="form-group col-md-12">
                        <label for="new_password_confirmation">Confirm New Password <span class="required">*</span></label>
                        <div class="input-group">
                            <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" placeholder="Re-enter the new password" required style="border-top: 1px solid #ccc; border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;"/>
                            <div class="input-group-append">
                                <span class="input-group-text" onclick="togglePasswordVisibility('new_password_confirmation')" style="height: 100%; display: flex; align-items: center; justify-content: center; background-color: transparent; border-top: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc;">
                                    <i class="bi bi-eye-slash" id="new_password_confirmation_icon" style="font-size: 1.2em;"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Error Messages -->
                    <small id="error_message" class="form-text text-danger" style="display: none;"></small>

                    <!-- Submit Button -->
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit" id="submit_btn" disabled>
                            Change Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePasswordVisibility(inputId) {
        var input = document.getElementById(inputId);
        var icon = document.getElementById(inputId + '_icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    }

    // Validate passwords
    function validatePassword() {
        var newPassword = document.getElementById('new_password').value;
        var confirmPassword = document.getElementById('new_password_confirmation').value;
        var submitBtn = document.getElementById('submit_btn');
        var errorMessage = document.getElementById('error_message');

        // Check if passwords are long enough (min. 8 characters)
        if (newPassword.length < 8 || confirmPassword.length < 8) {
            errorMessage.textContent = 'Password must be at least 8 characters long.';
            errorMessage.style.display = 'block';
            submitBtn.disabled = true;
            return false;
        }

        // Check if passwords match
        if (newPassword !== confirmPassword) {
            errorMessage.textContent = 'New Password and Confirm New Password do not match.';
            errorMessage.style.display = 'block';
            submitBtn.disabled = true;
            return false;
        }

        // If everything is fine
        errorMessage.style.display = 'none';
        submitBtn.disabled = false;
        return true;
    }

    // Check password match and length on input
    document.getElementById('new_password').addEventListener('input', validatePassword);
    document.getElementById('new_password_confirmation').addEventListener('input', validatePassword);
</script>
@endsection
