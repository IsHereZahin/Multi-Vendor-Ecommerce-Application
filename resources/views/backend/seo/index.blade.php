@extends('admin.components.master')
@section('content')
    <div class="container">
        <h3 class="mb-4">SEO Settings</h3>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.seo.setting.update') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Meta Title</label>
                <div class="col-sm-9">
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $seo->meta_title) }}">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Meta Author</label>
                <div class="col-sm-9">
                    <input type="text" name="meta_author" class="form-control" value="{{ old('meta_author', $seo->meta_author) }}">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Meta Keywords</label>
                <div class="col-sm-9">
                    <input type="text" name="meta_keyword" class="form-control" value="{{ old('meta_keyword', $seo->meta_keyword) }}">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Meta Description</label>
                <div class="col-sm-9">
                    <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $seo->meta_description) }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Open Graph Type</label>
                <div class="col-sm-9">
                    <input type="text" name="og_type" class="form-control" value="{{ old('og_type', $seo->og_type) }}">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Open Graph URL</label>
                <div class="col-sm-9">
                    <input type="text" name="og_url" class="form-control" value="{{ old('og_url', $seo->og_url) }}">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Open Graph Image URL</label>
                <div class="col-sm-9">
                    <input type="text" name="og_image" class="form-control" value="{{ old('og_image', $seo->og_image) }}">
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Save Settings</button>
                <a href="{{ route('admin.seo.setting.reset') }}" class="btn btn-danger">Reset to Default</a>
            </div>
        </form>
    </div>
@endsection
