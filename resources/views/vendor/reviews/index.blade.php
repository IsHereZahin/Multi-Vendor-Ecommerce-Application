@extends('vendor.components.master')
@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Reviews and Comments</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Reviews and Comments</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Comment</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $key => $review)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $review->comment }}</td>
                                    <td>{{ $review->user->name }}</td>
                                    <td>
                                        <a href="{{ route('product.details', ['id' => $review->product->id, 'slug' => $review->product->product_slug]) }}"
                                            target="_blank">
                                            {{ $review->product->product_name }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="product-rate d-inline-block">
                                            <div class="stars" style="font-size: 20px; color: #ccc;">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="star"
                                                        style="margin-right: 5px; color: {{ $review->rating >= $i ? 'gold' : '#ccc' }};">&#9733;</span>
                                                @endfor
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @switch($review->status)
                                            @case(0)
                                                <span class="badge rounded-pill bg-warning">Pending</span>
                                            @break

                                            @case(1)
                                                <span class="badge rounded-pill bg-success">Published</span>
                                            @break

                                            @case(2)
                                                <span class="badge rounded-pill bg-secondary">Pending Review</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @switch($review->status)
                                            @case(0)
                                                <a href="{{ route('vendor.review.toggle', $review->id) }}"
                                                    class="btn btn-success">Approve</a>
                                            @break

                                            @case(1)
                                                <a href="{{ route('vendor.review.toggle', $review->id) }}"
                                                    class="btn btn-warning">Reject</a>
                                            @break

                                            @case(2)
                                                <a href="{{ route('vendor.review.toggle', $review->id) }}"
                                                    class="btn btn-secondary">Pending</a>
                                            @break
                                        @endswitch

                                        <form action="{{ route('vendor.review.delete', $review->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to permanently delete this review?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
