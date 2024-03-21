@extends('vendor\components\master')
@section('content')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Vendor Details</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Vendor Info</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ (!empty($vendordata->photo)) ? url('upload/user/vendor/'.$vendordata->photo):url('adminbackend/assets/images/no_image.jpg') }}" alt="vendor" class="rounded-circle p-1 bg-primary" width="110">
                                <div class="mt-3">
                                    <h4>{{ $vendordata->name ?? 'Name not found!' }}</h4>
                                    <p class="text-secondary mb-1" style="margin-top: -5px">Since {{ $vendordata->vendor_join_year ?? 'Year not found!' }}</p>
                                    <p class="text-secondary mb-1">{{ $vendordata->email ?? '' }}</p>
                                    <p class="text-muted font-size-sm">{{ $vendordata->address ?? 'Address not found!' }}</p>
                                </div>
                            </div>
                            <hr class="my-4" />
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Shop Short Info</h6>
                                    <p>{{ $vendordata->vendor_short_info }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{ route('vendor.profile.update') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0"></h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <img id="showImage" style="height: 10vh" class="rounded avatar-lg" src="{{ (!empty($vendordata->photo)) ? url('upload/user/vendor/'.$vendordata->photo):url('adminbackend/assets/images/no_image.jpg') }}" alt="Image">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Vendor Logo</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input name="photo" class="form-control" type="file" id="image">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Vendor Username</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" value="{{ $vendordata->username ?? '' }}" disabled/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Shop Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="name" value="{{ $vendordata->name ?? '' }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Vendor Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="email" value="{{ $vendordata->email ?? '' }}" required/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Vendor Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="phone" value="{{ $vendordata->phone ?? '' }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Vendor Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="address" value="{{ $vendordata->address ?? '' }}" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Vendor Since</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select name="vendor_join_year" class="form-select mb-3" aria-label="Default select example">
                                            <option value="{{ $vendordata->vendor_join_year ?? '' }}">
                                                {{ $vendordata->vendor_join_year ?? 'Year not found' }}
                                            </option>
                                            @for ($year = 2000; $year <= date('Y'); $year++)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Vendor Info</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <textarea name="vendor_short_info" class="form-control" id="inputAddress2" rows="3">{{ $vendordata->vendor_short_info ?? 'Info ...' }}</textarea>
                                    </div>
                                </div>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
@endsection
