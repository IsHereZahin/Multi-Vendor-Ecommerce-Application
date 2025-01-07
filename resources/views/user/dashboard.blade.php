@extends('user.user_dashboard_master')

@section('user-dashboard')
<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Hello {{ Auth::user()->name }}!</h3>
    </div>
    <div class="card-body">
        <p>
            From your account dashboard, you can easily check &amp; view your <a href="#">recent orders</a>,<br />
            manage your <a href="#">shipping and billing addresses</a>, and <a href="#">edit your password and account details.</a>
        </p>
    </div>
</div>
@endsection
