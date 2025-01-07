@extends('frontend.components.master')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ '/' }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> My Account
        </div>
    </div>
</div>
<div class="page-content pt-150 pb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="row">
                    @include('user.user_dashboard_sidebar')
                    <div class="col-md-9">
                        <div class="tab-content account dashboard-content pl-50">
                            @yield('user-dashboard')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
