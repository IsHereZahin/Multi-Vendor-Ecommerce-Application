@extends('admin.components.master')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Site Settings</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Site Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="{{ route('admin.site.setting.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $setting->id }}">

                                    <!-- Logo -->
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label">Logo</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="logo" class="form-control" id="image">
                                            <img id="showImage" src="{{ asset('frontend/assets/imgs/theme/' . $setting->logo) }}" alt="Logo" style="width: 100px; height: 100px;" class="mt-2 border rounded">
                                        </div>
                                    </div>

                                    <!-- Last Updated -->
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label">Last Updated</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $setting->updated_at->format('d M Y, h:i A') }}" disabled>
                                        </div>
                                    </div>

                                    <!-- Slogan -->
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label">Slogan</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="slogan" class="form-control" value="{{ $setting->slogan }}">
                                        </div>
                                    </div>

                                    <!-- Support Phone -->
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label">Support Phone</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="support_phone" class="form-control" value="{{ $setting->support_phone }}">
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" class="form-control" value="{{ $setting->email }}">
                                        </div>
                                    </div>

                                    <!-- Address -->
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="address" class="form-control" value="{{ $setting->address }}">
                                        </div>
                                    </div>

                                    <!-- Social Media -->
                                    @foreach(['facebook', 'twitter', 'instagram', 'youtube'] as $platform)
                                        <div class="row mb-4">
                                            <label class="col-sm-3 col-form-label">{{ ucfirst($platform) }} Username</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="{{ $platform }}_username" class="form-control" value="{{ $setting[$platform.'_username'] }}">
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Timezone -->
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label">Timezone</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="timezone" class="form-control" value="{{ $setting->timezone }}">
                                        </div>
                                    </div>

                                    <!-- Open Hours -->
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label">Open Hours</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="open_hours" class="form-control" value="{{ $setting->open_hours }}">
                                        </div>
                                    </div>

                                    <!-- Open Days -->
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label">Open Days</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="open_days" class="form-control" value="{{ $setting->open_days }}">
                                        </div>
                                    </div>

                                    <!-- Maintenance Mode -->
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label">Maintenance Mode</label>
                                        <div class="col-sm-9">
                                            <select name="maintenance_mode" class="form-control">
                                                <option value="0" {{ $setting->maintenance_mode == 0 ? 'selected' : '' }}>Off</option>
                                                <option value="1" {{ $setting->maintenance_mode == 1 ? 'selected' : '' }}>On</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to save the changes?');">Save Settings</button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Reset Button -->
                                <form method="get" action="{{ route('admin.site.setting.reset') }}">
                                    <button type="submit" class="btn btn-danger mt-3" onclick="return confirm('Are you sure you want to reset the changes?');">Reset to Default</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
@endsection
