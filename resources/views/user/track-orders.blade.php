@extends('user.user_dashboard_master')

@section('user-dashboard')
<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Track Your Orders</h3>
    </div>
    <div class="card-body">
        <p>To track your order, please enter your Order ID and Billing email below:</p>
        <form action="#" method="post">
            <div class="form-group">
                <label>Order ID</label>
                <input name="order-id" placeholder="Order ID" type="text" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Billing Email</label>
                <input name="billing-email" placeholder="Email" type="email" class="form-control"/>
            </div>
            <button type="submit" class="btn btn-primary">Track</button>
        </form>
    </div>
</div>
@endsection
