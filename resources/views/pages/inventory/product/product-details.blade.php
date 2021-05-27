@extends('layouts.app')

@section('title', 'Product Details | Inventory POS')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-auto mb-2 mb-sm-0">
                    <h6 class="mb-0">DashBoard > Products > Title</h6>
                </div>
                <div class="col-sm-auto">
                    <a class="text-600" href="{{ route('home') }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="DashBoard"><svg class="svg-inline--fa fa-th fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="th" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M149.333 56v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zm181.334 240v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm32-240v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24zm-32 80V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm-205.334 56H24c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm386.667-56H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm0 160H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zM181.333 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24z"></path></svg><!-- <span class="fas fa-th"></span> --></a>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                @if ($product->photo)
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="product-slider">
                            <div class="item h-100">
                                <img class="rounded h-100 fit-cover" src="{{ asset($product->photo ? $product->photo->image_path : '') }}" alt="" width="95%">
                            </div>
                        </div>
                    </div>
                @endif
                <div class="@if ($product->photo) col-lg-6 @else col-lg-6 @endif">
                    <h5>{{ $product->title }}</h5>
                    <a class="fs--1 mb-2 d-block" href="#!">{{ $product->category->name }}</a>
                    <p class="fs--1">
                        {{ Illuminate\Support\Str::limit($product->description, 400) }}
                    </p>
                    <h6 class="d-flex align-items-center">
                        Selling Price: <span class="text-warning mr-2"> BDT {{ $product->selling_price }}
                        </span>
                    </h6>
                    <h6 class="d-flex align-items-center">
                        <span class="mr-1 fs--1 text-500">
                            Buying Price: BDT {{ $product->buying_price }}
                        </span>
                    </h6>
                    <p class="fs--1 mb-1"> <span>Unit: </span><strong></strong>{{ $product->unit->name }}</p>
                    <p class="fs--1 mb-1"> <span>Shipping Cost: </span><strong>BDT 50</strong></p>
                    <p class="fs--1">Stock: <strong class="text-danger">
                            @if ($product->stock == 0 OR $product->stock == null)
                                <span class="badge badge-danger">Out Of Stock</span>
                            @elseif($product->stock < 6)
                                <span class="badge badge-warning">Low Stock</span> {{ $product->stock }} {{ $product->unit->name }}
                            @else
                                {{ $product->stock }} {{ $product->unit->name }}
                            @endif
                        </strong></p>
                    <p class="fs--1 mb-3">Sub Title: <span style="color: #2c7be5;">{{ $product->sub_title }}</span></p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="fancy-tab overflow-hidden mt-4">
                        <div class="nav-bar">
                            <div class="nav-bar-item active pl-0 pr-2 pr-sm-4">
                                <div class="mt-1 fs--1">Description</div>
                            </div>
                        </div>
                        <div class="tab-contents">
                            <div class="tab-content active">
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
