@extends('layouts.app')

@section('title', 'Edit Purchase | Inventory POS')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-md">
                    <h5 class="mb-2 mb-md-0">Order {{ $purchase->order_number }}</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('purchase.invoice', $purchase->id) }}" class="btn btn-falcon-success btn-sm mr-2 mb-2 mb-sm-0" type="button">
                        <span class="fas fa-print mr-1"> </span>Invoice (Print)
                    </a>
                    <button class="btn btn-falcon-default btn-sm mr-2 mb-2 mb-sm-0" type="button">
                        <span class="far fa-envelope mr-1"> </span>Email (Invoice)
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form class="purchase-edit" action="{{ route('purchase.update.data', $purchase->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row no-gutters">
            <div class="col-xl-4 order-xl-1 pl-xl-2">
                <div class="mb-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="card-title">Order Details</div>
                            <p class="card-text">
                            <div class="form-group">
                                <input type="hidden" name="id" id="purchase_id" value="{{ $purchase->id }}">
                                <label for="order_number">Order Number</label>
                                <input class="form-control" id="order_number" name="order_number" type="text" value="{{ $purchase->order_number }}" readonly>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="order_date">Order Date</label>
                                    <input class="form-control datetimepicker" id="order_date" name="order_date" v-on:input="buttonAdd()" type="text" data-options='{"dateFormat":"d/m/y"}' value="{{ $purchase->order_date }}">
                                </div>
                                <div class="form-group col-6">
                                    <label for="shipping_date">Shipping Date</label>
                                    <input class="form-control datetimepicker" id="shipping_date" name="shipping_date" v-on:input="buttonAdd()" type="text" data-options='{"dateFormat":"d/m/y"}' value="{{ $purchase->shipping_date }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    @if ($purchase->status == 0)
                                        <span class="badge badge-warning">Unfulfilled</span>
                                    @else
                                        <span class="badge badge-info">Fulfilled</span>
                                    @endif
                                </div>
                                <div class="col-6 text-right">
                                    @if ($purchase->is_pay == 0)
                                        <b>Unpaid</b>
                                    @elseif ($purchase->is_pay == 2)
                                        <b>Partial</b>
                                    @else
                                        <b>Paid</b>
                                    @endif
                                    <span class="badge badge-light text-indigo"> ${ purchase.paid } TK</span>
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
                                <input type="hidden" name="subtotal" value="">
                                <th class="pr-0 text-right">${ purchase.subtotal } TK</th>
                            </tr>
                            <tr class="border-bottom">
                                <th class="pl-0">Freight</th>
                                <th class="pr-0 text-right">
                                    <div class="input-group">
                                        <input class="form-control input-quantity input-spin-none my_numb_input" v-on:input="buttonAdd()" :value="`${ purchase.freight_cost }`" name="freight_cost" type="number">
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
                                        <input class="form-control input-quantity input-spin-none my_numb_input" v-on:input="buttonAdd()" :value="`${ purchase.tax }`" name="tax" type="number">
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
                                        <input class="form-control input-quantity input-spin-none my_numb_input" v-on:input="buttonAdd()" :value="`${ purchase.discount }`" name="discount" type="number">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            <tr class="border-bottom">
                                <th class="pl-0">Total</th>
                                <input type="hidden" name="total" value="">
                                <th class="pr-0 text-right">${ purchase.total } TK</th>
                            </tr>
                            <tr class="border-bottom">
                                <th class="pl-0">Paid</th>
                                <th class="pr-0 text-right">
                                    <div class="input-group">
                                        <input class="form-control input-quantity input-spin-none my_numb_input" v-on:input="buttonAdd()" :value="`${ purchase.paid }`" type="number" name="paid">
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
                            <input type="hidden" name="balance" value="">
                            <div class="fs-2 font-weight-semi-bold">Balance: ${ purchase.balance }<span class="text-primary"> TK</span></div>
                            <template v-if="button == false">
                                <template v-if="purchase.is_pay == 3">
                                    <a href="{{ route('purchase.pay', $purchase->id) }}" class="btn btn-sm btn-danger mt-3 px-4" type="submit">Return Due</a>
                                </template>
                                <template v-else>
                                    @if ($purchase->is_pay == 0)
                                        <a href="{{ route('purchase.pay', $purchase->id) }}" class="btn btn-sm btn-info mt-3 px-5" type="submit" >Pay</a>
                                    @elseif($purchase->is_pay == 2)
                                        <a href="{{ route('purchase.pay', $purchase->id) }}" class="btn btn-sm btn-warning mt-3 px-5" type="submit">Pay Left</a>
                                    @else
                                        <a href="{{ route('purchase.unpay', $purchase->id) }}" class="btn btn-sm btn-danger mt-3 px-5" type="submit">Unpay</a>
                                    @endif
                                </template>
                                @if ($purchase->status == 0)
                                    <a href="{{ route('purchase.fulfillment', $purchase->id) }}" class="btn btn-sm btn-success mt-3 px-5">Fulfilled</a>
                                @else
                                    <a href="{{ route('purchase.unfulfillment', $purchase->id) }}" class="btn btn-sm btn-warning mt-3 px-5" type="submit">Unfulfilled</a>
                                @endif
                            </template>
                            <template v-else>
                                <button class="btn btn-sm btn-warning mt-3 px-5" type="button" @click="cancel()">Cancel</button>
                                <button class="btn btn-sm btn-success mt-3 px-5" type="submit">Save</button>
                            </template>
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
                        <input type="hidden" name="vendor" id="get_vendor" value="{{ $purchase->vendor_id }}">
                        <template v-if="vendor.vendor">
                            <div class="row">
                                <div class="col-md-12 mb-3 mb-md-0">
                                    <div class="custom-control custom-radio radio-select">
                                        <input class="custom-control-input" id="address-1" type="radio" name="clientName" checked>
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
                                                <option value="0" selected>Choose</option>
                                                @foreach($vendors as $val)
                                                    <option value="{{ $val->id }}">
                                                        {{ $val->title_name }} - {{ $val->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3 col-md-3 col-lg-3 mt-pt text-right">
                                        <button class="btn btn-falcon-default btn-md mt-2" type="button" @click="addVendorEdit()"><span class="fas fa-plus fs--2 mr-1" data-fa-transform="up-1"></span> Add Item</button>
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
                        <template v-if="products.length">
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
                                <div class="row no-gutters align-items-center px-1 border-bottom border-200" v-for="(item, index) in products">
                                    <div class="col-6 py-3 px-2 px-md-3">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <h5 class="fs-0"><a class="text-900"> ${ item.get_product.title }</a></h5>
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
                                                <input class="form-control text-center px-2 input-quantity input-spin-none" type="number" min="1" :id="'price-'+item.id" :value="`${ item.price }`" v-on:change="priceUpdate(item.id)" style="max-width: 80px"/>
                                            </div>
                                            <div class="col-md-4 text-right pl-0 pr-2 pr-md-3 order-0 order-md-1 mb-2 mb-md-0 text-600">${ item.subtotal } TK</div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Product -->
                            </div>
                        </template>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3">{!! $purchase->remarks !!}</textarea>
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
    </style>
@endsection
@section('admin-js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/lib/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/lib/flatpickr/flatpickr.min.js') }}"></script>
@endsection
