@extends('admin.components.master')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<div class="page-content">

  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Product</div>
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="card">
    <div class="card-body p-4">
      <h5 class="card-title">Edit Product (ID: {{ $product->id }})</h5> <hr />

      <form id="myForm" action="{{ route('update.product',$product->id ) }}" method="post"  enctype="multipart/form-data">
        @csrf
        @method('POST') <div class="form-body mt-4">
          <div class="row">
            <div class="col-lg-8">
              <div class="border border-3 p-4 rounded">

                <div class="form-group mb-3">
                  <label for="inputProductTitle" class="form-label">Product Name</label>
                  <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="form-control" id="inputProductTitle" placeholder="Enter product title" required>
                  @error('product_name')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="inputProductTitle" class="form-label">Product Tags</label>
                  <input type="text" name="product_tags" data-role="tagsinput" value="{{ old('product_tags', $product->product_tags) }}" class="form-control visually-hidden" required>
                  @error('product_tags')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="inputProductTitle" class="form-label">Product Size</label>
                  <input type="text" name="product_size" data-role="tagsinput" value="{{ old('product_size', $product->product_size) }}" class="form-control visually-hidden" required>
                  @error('product_size')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="inputProductTitle" class="form-label">Product Color</label>
                  <input type="text" name="product_color" data-role="tagsinput" value="{{ old('product_color', $product->product_color) }}" class="form-control visually-hidden" required>
                  @error('product_color')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="inputProductDescription" class="form-label">Short Description</label>
                  <textarea name="short_descp" class="form-control" id="inputProductDescription" rows="3" required>{{ old('short_descp', $product->short_descp) }}</textarea>
                  @error('short_descp')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="inputProductDescription" class="form-label">Long Description</label>
                    <textarea id="mytextarea" name="long_descp" required>{{ old('long_descp', $product->long_descp) }}</textarea>
                    @error('long_descp')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label for="inputProductTitle" class="form-label">Main Thumbnail</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input name="product_thambnail" class="form-control" type="file" id="formFile" onChange="mainThamUrl(this)">
                        @error('product_thambnail')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="col-md-6">
                        <img src="{{ asset($product->product_thambnail) }}" id="mainThmb" width="80" height="80">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-3">
                    <label for="inputProductTitle" class="form-label">Multiple Images</label>
                    <input class="form-control" name="multi_img[]" type="file" id="multiImg" multiple>
                    @error('multi_img')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="row" id="preview_img">
                        @foreach($uploadedImages as $image)
                            <div class="col-md-3 mb-3" style="width: 100px;">
                                <img src="{{ asset($image->photo_name) }}" class="img-thumbnail" alt="Image" width="100px" height="80px" style="border: 0;">
                                <input name="delete_image[]" type="checkbox" class="delete-checkbox" data-image-id="{{ $image->id }}" value="{{ $image->id }}"> Delete ({{ $image->id }})
                            </div>
                        @endforeach
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        $('.delete-checkbox').change(function() {
                            if ($(this).is(':checked')) {
                                var imageId = $(this).data('image-id');
                                deleteImage(imageId);
                            }
                        });

                        function deleteImage(imageId) {
                            $.ajax({
                                type: 'POST',
                                url: '/delete-image',
                                data: {
                                    image_id: imageId,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        // Image deleted successfully
                                        console.log('Image deleted');
                                    } else {
                                        console.error('Failed to delete image');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error:', error);
                                }
                            });
                        }
                    });
                </script>



                </div>
              </div>

              <div class="col-lg-4">
                <div class="border border-3 p-4 rounded">
                  <div class="row g-3">

                    <div class="form-group col-md-6">
                      <label for="inputPrice" class="form-label">Product Price</label>
                      <input type="text" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" class="form-control" id="inputPrice" placeholder="00.00" required>
                      @error('selling_price')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group col-md-6">
                      <label for="inputCompareatprice" class="form-label">Discount Price</label>
                      <input type="text" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" class="form-control" id="inputCompareatprice" placeholder="00.00">
                      @error('discount_price')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group col-md-6">
                      <label for="inputCostPerPrice" class="form-label">Product Code</label>
                      <input type="text" name="product_code" value="{{ old('product_code', $product->product_code) }}" class="form-control" id="inputCostPerPrice" placeholder="00.00" required>
                      @error('product_code')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group col-md-6">
                      <label for="inputStarPoints" class="form-label">Product Quantity</label>
                      <input type="text" name="product_qty" value="{{ old('product_qty', $product->product_qty) }}" class="form-control" id="inputStarPoints" placeholder="00.00" required>
                      @error('product_qty')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group col-12">
                        <label for="inputProductType" class="form-label">Product Brand</label>
                        <select name="brand_id" class="form-select" id="inputProductType" required>
                          @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                          @endforeach
                        </select>
                        @error('brand_id')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>

                      <div class="form-group col-12">
                        <label for="inputVendor" class="form-label">Product Category</label>
                        <select name="category_id" class="form-select" id="inputVendor" required>
                          @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                          @endforeach
                        </select>
                        @error('category_id')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>

                      <div class="form-group col-12">
                        <label for="inputCollection" class="form-label">Product SubCategory</label>
                        <select name="subcategory_id" class="form-select" id="inputCollection" required>
                            @if ($subcategories)
                                @foreach($subcategories as $subcat)
                                    <option value="{{ $subcat->id }}" {{ $product->subcategory_id == $subcat->id ? 'selected' : '' }}>{{ $subcat->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('subcategory_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="form-group col-12">
                        <label for="inputCollection" class="form-label">Select Vendor</label>
                        <select name="vendor_id" class="form-select" id="inputCollection" required>
                          @foreach($activeVendor as $vendor)
                            <option value="{{ $vendor->id }}" {{ $product->vendor_id == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                          @endforeach
                        </select>
                        @error('vendor_id')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>

                      <div class="col-12">
                        <div class="row g-3">

                          <div class="form-group col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" name="hot_deals" type="checkbox" value="1" id="flexCheckDefault" {{ $product->hot_deals == 1 ? 'checked' : '' }}>
                              <label class="form-check-label" for="flexCheckDefault">Hot Deals</label>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" name="featured" type="checkbox" value="1" id="flexCheckDefault" {{ $product->featured == 1 ? 'checked' : '' }}>
                              <label class="form-check-label" for="flexCheckDefault">Featured</label>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" name="special_offer" type="checkbox" value="1" id="flexCheckDefault" {{ $product->special_offer == 1 ? 'checked' : '' }}>
                              <label class="form-check-label" for="flexCheckDefault">Special Offer</label>
                            </div>
                          </div>


                          <div class="form-group col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" name="special_deals" type="checkbox" value="1" id="flexCheckDefault" {{ $product->special_deals == 1 ? 'checked' : '' }}>
                              <label class="form-check-label" for="flexCheckDefault">Special Deals</label>
                            </div>
                          </div>

                          <div class="form-group col-md-12">
                            <label for="inputDescription" class="form-label">Product Status</label>
                            <select name="status" class="form-select" id="inputDescription">
                              <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                              <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                              <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                        </div>
                      </div>

                      <div class="form-group mb-3 mt-4">
                        <button class="btn btn-primary px-4" type="submit">Update Product</button>
                      </div>

                  </div>
                </div>
              </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Thumbnail Image --}}
<script type="text/javascript">
	function mainThamUrl(input){
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e){
				$('#mainThmb').attr('src',e.target.result).width(80).height(80);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>

{{-- Multi Image --}}
<script>
    $(document).ready(function(){
     $('#multiImg').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            var data = $(this)[0].files; //this file data

            $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                    .height(80); //create image element
                        $('#preview_img').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });

        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
     });
    });
</script>

{{-- Sub-Category --}}
<script type="text/javascript">
    $(document).ready(function(){
        $('select[name="category_id"]').on('change', function(){
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: "{{ url('/subcategory/ajax') }}/"+category_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data){
                        $('select[name="subcategory_id"]').empty(); // Clear existing options
                        $.each(data, function(key, value){
                            $('select[name="subcategory_id"]').append('<option value="'+ value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log any errors to console
                        alert("An error occurred while fetching subcategories. Please try again.");
                    }
                });
            } else {
                $('select[name="subcategory_id"]').empty(); // Clear subcategory options if no category is selected
            }
        });
    });
</script>


@endsection
