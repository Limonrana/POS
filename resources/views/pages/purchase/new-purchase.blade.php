@extends('layouts.app')

@section('title', 'Add New Purchase | Inventory POS')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-auto mb-2 mb-sm-0">
                    <h6 class="mb-0">DashBoard > Purchase > Add New</h6>
                </div>
                <div class="col-sm-auto">
                    <a class="text-600" href="{{ route('home') }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="DashBoard"><svg class="svg-inline--fa fa-th fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="th" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M149.333 56v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zm181.334 240v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm32-240v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24zm-32 80V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm-205.334 56H24c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm386.667-56H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm0 160H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zM181.333 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24z"></path></svg><!-- <span class="fas fa-th"></span> --></a>
                </div>
            </div>
        </div>
    </div>

    <form class="purchase" action="{{ route('purchase.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row no-gutters">
            <div class="col-xl-4 order-xl-1 pl-xl-2">
                <div class="mb-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="card-title">Order Details</div>
                            <p class="card-text">
                                <div class="form-group">
                                    <label for="order_number">Order Number</label>
                                    <input class="form-control" id="order_number" name="order_number" type="text" value="{{ $order_number }}" placeholder="POS-00001">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="order_date">Order Date</label>
                                        <input class="form-control datetimepicker" id="order_date" name="order_date" type="text" data-options='{"dateFormat":"d/m/y"}' value="{{ $today }}">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="shipping_date">Shipping Date</label>
                                        <input class="form-control datetimepicker" id="shipping_date" name="shipping_date" type="text" data-options='{"dateFormat":"d/m/y"}'>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <span class="badge badge-warning">Unfulfilled</span>
                                    </div>
                                    <div class="col-6 text-right">
                                        <b>Unpaid</b> <span class="badge badge-light text-indigo"> ${ total } TK</span>
                                    </div>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-light btn-reveal-trigger">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless fs--1 mb-0">
                            <tr class="border-bottom">
                                <th class="pl-0">Subtotal</th>
                                <input type="hidden" name="subtotal" :value="`${ subtotal }`">
                                <th class="pr-0 text-right">${ subtotal } TK</th>
                            </tr>
                            <tr class="border-bottom">
                                <th class="pl-0">Freight</th>
                                <th class="pr-0 text-right">
                                    <div class="input-group">
                                        <input class="form-control input-quantity input-spin-none my_numb_input" v-model="freight" name="freight_cost" type="number">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">TK</span>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            <tr class="border-bottom">
                                <th class="pl-0">Vat</th>
                                <th class="pr-0 text-right">
                                    <div class="input-group">
                                        <input class="form-control input-quantity input-spin-none my_numb_input" v-model="vat" name="tax" type="number">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">TK</span>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            <tr class="border-bottom">
                                <th class="pl-0">Discount</th>
                                <th class="pr-0 text-right">
                                    <div class="input-group">
                                        <input class="form-control input-quantity input-spin-none my_numb_input" v-model="discount" name="discount" type="number">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            <tr class="border-bottom">
                                <th class="pl-0">Total</th>
                                <input type="hidden" name="total" :value="`${ total }`">
                                <th class="pr-0 text-right">${ total } TK</th>
                            </tr>
                            <tr class="border-bottom">
                                <th class="pl-0">Paid</th>
                                <th class="pr-0 text-right">
                                    <div class="input-group">
                                        <input class="form-control input-quantity input-spin-none my_numb_input" type="number" v-model="paid" name="paid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">TK</span>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </table>
                        <div class="bg-100">

                        </div>
                        <div class="text-right mt-3">
                            <hr class="border-dashed d-block d-md-none d-xl-block d-xxl-none my-4">
                            <input type="hidden" name="balance" :value="`${ balance }`">
                            <div class="fs-2 font-weight-semi-bold">Balance: ${ balance }<span class="text-primary"> TK</span></div>
                            <button class="btn btn-success mt-3 px-5" type="submit">Confirm &amp; Pay</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 pr-xl-2">
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-sm-auto">
                                <h5 class="mb-2 mb-sm-0">Vendor Details</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="vendor_section"></div>
                        <template v-if="vendor.vendor">
                            <div class="row">
                                <div class="col-md-12 mb-3 mb-md-0">
                                    <div class="custom-control custom-radio radio-select">
                                        <input class="custom-control-input" id="address-1" type="radio" checked>
                                        <label class="custom-control-label font-weight-bold d-block" for="address-1">${ vendor.vendor.name }
                                            <span class="radio-select-content">
                                                <span> ${ vendor.address.street }, ${ vendor.address.city }<br>${ vendor.address.state }, ${ vendor.address.country } - ${ vendor.address.zip }
                                                <span class="d-block mb-0 pt-2">${ vendor.vendor.email }</span>
                                                <span class="d-block mb-0 pt-2">${ vendor.vendor.phone }</span>
                                                </span>
                                            </span>
                                        </label>
                                        <a class="mt-2 fs--1 cart-remove" @click="vendorRemove()">Remove</a></div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="card-body bg-light">
                                <div class="row m-auto">
                                    <div class="col-9 col-md-9 col-lg-9">
                                        <div class="form-group">
                                            <label for="vendor_id">Select Vendor</label>
                                            <select name="vendor_id" class="form-control selectpicker" id="vendor_id">
                                                <option selected>Choose</option>
                                                @foreach($vendors as $val)
                                                    <option value="{{ $val->id }}">
                                                        {{ $val->title_name }} - {{ $val->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3 col-md-3 col-lg-3 mt-pt text-right">
                                        <button class="btn btn-falcon-default btn-md mt-2" type="button" @click="addVendor()"><span class="fas fa-plus fs--2 mr-1" data-fa-transform="up-1"></span> Add Item</button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Product Details</h5>
                    </div>
                    <div class="card-body">
                        <template v-if="cart.length">
                            <div class="card-body p-0">
                                <div class="row bg-200 text-900 no-gutters px-1 fs--1 font-weight-semi-bold">
                                    <div class="col-6 col-md-6 p-2 px-md-3">Name</div>
                                    <div class="col-6 col-md-6 px-3">
                                        <div class="row">
                                            <div class="col-md-4 py-2 d-none d-md-block text-center">Quantity</div>
                                            <div class="col-md-4 py-2 d-none d-md-block text-center">Price</div>
                                            <div class="col-md-4 text-right p-2 px-md-3">SubTotal</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-gutters align-items-center px-1 border-bottom border-200" v-for="(item, index) in cart">
                                    <div class="col-6 py-3 px-2 px-md-3">
                                        <div class="media align-items-center">
                                            {{--                                            <a href="#">--}}
                                            {{--                                                <img class="rounded mr-3 d-none d-md-block" :src="`${ item.photo_url.split('/purchase').pop() }`" alt="" width="60" />--}}
                                            {{--                                            </a>--}}
                                            <div class="media-body">
                                                <h5 class="fs-0"><a class="text-900"> ${ item.product_name }</a></h5>
                                                <div class="fs--2 fs-md--1"><a class="text-danger cart-remove" @click="cartRemove(item.id)">Remove</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 p-3">
                                        <div class="row">
                                            <div class="col-md-4 d-flex justify-content-end justify-content-md-center px-2 px-md-3 order-1 order-md-0">
                                                <div>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend"><button type="button" class="btn btn-sm btn-outline-secondary border-300 px-2" data-field="input-quantity" data-type="minus" @click="decrement(item.id)">-</button></div>
                                                        <input class="form-control text-center px-2 input-quantity input-spin-none" name="qty" type="number" min="1" :id="'qty-'+item.id" :value="`${ item.qty }`" v-on:change="qtyUpdate(item.id)" aria-label="Amount (to the nearest dollar)" style="max-width: 40px" />
                                                        <div class="input-group-append"><button type="button" class="btn btn-sm btn-outline-secondary border-300 px-2" data-field="input-quantity" data-type="plus" @click="increment(item.id)">+</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-flex justify-content-end justify-content-md-center px-2 px-md-3 order-1 order-md-0">
                                                <input class="form-control text-center px-2 input-quantity input-spin-none" :id="'price-'+item.id" type="number" min="1" :value="`${ item.price }`" v-on:input="priceUpdate(item.id)" style="max-width: 100px" />
                                            </div>
                                            <div class="col-md-4 text-right pl-0 pr-2 pr-md-3 order-0 order-md-1 mb-2 mb-md-0 text-600">${ item.subtotal } TK</div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Product -->
                            </div>
                        </template>
                        <div class="add-product-btn badge badge-light text-center">
                            <a class="mb-4" href="#add-product" data-toggle="collapse" aria-expanded="false" aria-controls="add-product">
                                <span class="fas fa-plus"></span> <span> Add New Product</span></a>
                        </div>
                        <hr class="border-dashed">
                        <div class="collapse" id="add-product">
                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-9 col-md-9 col-lg-9">
                                        <div class="form-group">
                                            <label for="product_id">Select Product</label><br>
                                            <select class="form-control selectpicker" id="product_id" style="display: block;">
                                                <option selected>Choose</option>
                                                @foreach($products as $val)
                                                    <option value="{{ $val->id }}">
                                                        {{ $val->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3 col-md-3 col-lg-3 mt-pt">
                                        <button class="btn btn-falcon-default btn-md mt-2" type="button" @click="addCart()"><span class="fas fa-plus fs--2 mr-1" data-fa-transform="up-1"></span> Add Item</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('admin-css')
    <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <style>
        .mt-pt{
            padding-top: 22px;
        }
        .cart-remove {
            cursor: pointer;
        }
        th.pr-0.text-right {
            width: 130px;
        }
        span.input-group-text {
            font-size: 12px;
            font-weight: 600;
            padding: 5px;
        }
        input.form-control.my_numb_input {
            padding: 10px;
            font-size: 12px;
            text-align: right;
        }
        .add-product-btn.badge.badge-light.text-center {
            width: 100%;
            padding: 20px;
        }
        .select2-container {
            display: block !important;
        }
    </style>
@endsection
@section('admin-js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/lib/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/lib/flatpickr/flatpickr.min.js') }}"></script>
@endsection
