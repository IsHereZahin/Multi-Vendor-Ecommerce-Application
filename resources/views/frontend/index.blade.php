@extends('frontend.components.master')
@section('content')

@section('title')
Home Easy Multi Vendor Shop
@endsection

@include('frontend.layouts.heroes')

@include('frontend.layouts.category')

@include('frontend.layouts.banners')

@include('frontend.layouts.products')

@include('frontend.layouts.vendor')

@endsection
