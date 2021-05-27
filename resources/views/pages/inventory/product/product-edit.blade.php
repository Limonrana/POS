@extends('layouts.app')

@section('title', 'Add Product | Inventory POS')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-auto mb-2 mb-sm-0">
                    <h6 class="mb-0">DashBoard > Products > Edit</h6>
                </div>
                <div class="col-sm-auto">
                    <a class="text-600" href="{{ route('home') }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="DashBoard"><svg class="svg-inline--fa fa-th fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="th" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M149.333 56v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zm181.334 240v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm32-240v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24zm-32 80V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm-205.334 56H24c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm386.667-56H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm0 160H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zM181.333 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24z"></path></svg><!-- <span class="fas fa-th"></span> --></a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('product.update.data', $product->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row no-gutters">
            <div class="col-lg-8 pr-lg-2">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Edit Product</h5>
                    </div>
                    <div class="card-body bg-light">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="title">Product Title</label>
                                        <input class="form-control @error('title') is-invalid @enderror" id="title" value="{{ $product->title }}" name="title" type="text" required>
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="sub_title">Sub Title</label>
                                        <input class="form-control" id="sub_title" name="sub_title" value="{{ $product->sub_title }}" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="category_id">Category Name</label>
                                        <select id="category_id" name="category_id" class="custom-select mb-3  @error('category_id') is-invalid @enderror" required>
                                            <option selected>Choose One</option>
                                            @foreach($category as $val)
                                                <option value="{{ $val->id }}" @if ($product->category_id == $val->id) selected @endif>{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="unit_id">Unit Name</label>
                                        <select id="unit_id" name="unit_id" class="custom-select mb-3  @error('unit_id') is-invalid @enderror" required>
                                            <option selected>Choose One</option>
                                            @foreach($unit as $val)
                                                <option value="{{ $val->id }}" @if ($product->unit_id == $val->id) selected @endif>{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="buying_price">Buying Price</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">BDT</span>
                                            </div>
                                            <input class="form-control @error('buying_price') is-invalid @enderror" type="text" id="buying_price" value="{{ $product->buying_price }}" name="buying_price" placeholder="200" required>
                                            @error('buying_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="selling_price">Selling Price</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">BDT</span>
                                            </div>
                                            <input class="form-control  @error('selling_price') is-invalid @enderror" type="text"  value="{{ $product->selling_price }}" id="selling_price" name="selling_price" placeholder="320.95" required>
                                            @error('selling_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="code">Product SKU Code</label>
                                        <input class="form-control @error('code') is-invalid @enderror" id="code" name="code"  value="{{ $product->code }}" placeholder="SKU-1234" type="text" required>
                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="intro">Product Description</label>
                                        <textarea class="form-control" id="intro" name="description" cols="30" rows="13">{!! $product->description !!}</textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 pl-lg-2">
                <div class="sticky-top sticky-sidebar">
                    <div class="card mb-3 overflow-hidden">
                        <div class="card-header">
                            <h5 class="mb-0">Featured Image</h5>
                        </div>
                        <div class="card-body bg-light">
                            <h6 class="mt-2 font-weight-bold">Product Status<span class="fs--2 ml-1 text-primary" data-toggle="tooltip" data-placement="top" title="You can go draft mode for this product. Then Product will be Invisible."><span class="fas fa-question-circle"></span></span></h6>
                            <div class="pl-2">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="status" value="1" id="active" checked="checked" />
                                    <label class="custom-control-label" for="active">Active</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" value="0" name="status" id="draft" />
                                    <label class="custom-control-label" for="draft">Draft</label>
                                </div>
                            </div>
                            <hr class="border-dashed border-bottom-0">
                            <div class="pl-2">
                                <div class="fallback"><input id="fallback" type="file" onchange="showImage(this.files[0])" name="image"></div>
                                <div class="preview">
                                    <div class="image-complete" id="image_complete"  style="{{ $product->image ? 'display: none;' : 'display: block;' }}">
                                        <div class="message-text" id="uploadImage" style="{{ $product->image ? 'display: none;' : 'display: block;' }}">
                                            <img class="mr-2" src="{{ asset('assets/img/icons/cloud-upload.svg') }}" width="25" alt="">Drop your file here
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-2" id="img_show">
                                <img id="preview_img" @if ($product->image) src="{{ asset($product->photo->image_path) }}" @else src="#" @endif class="my-preview-img" style="{{ $product->image ? 'display: block; border: 2px dashed' : 'display: none; border: none;' }}">
                                <a class="img-remove text-danger" onclick="imgRemove()" href="#!" style="{{ $product->image ? 'display: block;' : 'display: none;' }}">
                                    <span class="fas fa-times"></span>
                                </a>
                            </div>
                            <div class="col-12 d-flex justify-content-end mt-4"><button class="btn btn-primary" type="submit">Publish </button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('admin-css')
    <style>
        .image-complete {
            border: 2px dashed;
            padding: 70px;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
        }
        .fallback {
            display: none;
        }
        .img-remove {
            text-align: right !important;
            display: none;
        }
        .img-remove {
            position: absolute;
            top: 34%;
            right: 8%;
            display: none;
        }
        .my-preview-img {
            width: 98%;
        }
        .my-preview-img:hover {
            opacity: 0.6;
        }
    </style>
@endsection

@section('admin-js')
    <script>
        var imageInput      = document.getElementById('fallback');
        var uploadImage     = document.getElementById('uploadImage');
        var uploadImg       = document.getElementById('image_complete');

        if (uploadImg) {
            uploadImg.addEventListener("click", function(event) {
                imageInput.click();
            });
        }
        function showImage(img) {
            document.querySelector('.image-complete').style.display = "none";
            document.querySelector('.image-complete').style.border = "none";
            document.querySelector('.img-remove').style.display = "block";
            document.querySelector('.my-preview-img').style.display = "block";
            document.querySelector('.my-preview-img').style.border = "2px dashed";
            document.getElementById('preview_img').src = window.URL.createObjectURL(img);
        }
        function imgRemove() {
            document.querySelector('.my-preview-img').style.display = "none";
            document.querySelector('.img-remove').style.display = "none";
            document.querySelector('.image-complete').style.display = "block";
            document.querySelector('.image-complete').style.border = "2px dashed";
            uploadImage.style.display = "block";
        }
    </script>
@endsection
