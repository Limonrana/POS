@extends('layouts.app')

@section('title', 'Invoice Sales | Inventory POS')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-md">
                    <h5 class="mb-2 mb-md-0">Order {{ $invoice->order_number }}</h5>
                </div>
                <div class="col-auto">
                    <button class="btn btn-falcon-success btn-sm mr-2 mb-2 mb-sm-0 print-window" type="button">
                        <span class="fas fa-print mr-1"> </span>Invoice (Print PDF)
                    </button>
                    <a href="#" target="_blank" class="btn btn-falcon-success btn-sm mr-2 mb-2 mb-sm-0" type="button">
                        <span class="far fa-envelope mr-1"> </span>Email (Invoice)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-center text-center mb-3">
                <div class="col-sm-6 text-sm-left"><img src="{{ asset('assets/img/logos/logo-invoice.png') }}" alt="invoice" width="150"></div>
                <div class="col text-sm-right mt-3 mt-sm-0">
                    <h2 class="mb-3">Invoice</h2>
                    <h5>Inventory</h5>
                    <p class="fs--1 mb-0">156 University Ave, Dhaka<br>On, Bangladesh, 1206</p>
                    @if ($invoice->status == 0)
                        <span class="badge badge-warning">Unfulfilled</span>
                    @else
                        <span class="badge badge-success">Fulfilled</span>
                    @endif

                    @if ($invoice->is_pay == 0)
                        <span class="badge badge-danger">Unpaid</span>
                    @elseif ($invoice->is_pay == 2)
                        <span class="badge badge-warning">Partials</span>
                    @else
                        <span class="badge badge-info">Paid</span>
                    @endif
                </div>
                <div class="col-12">
                    <hr>
                </div>
            </div>
            <div class="row justify-content-between align-items-center">
                <div class="col">
                    <h6 class="text-500">Invoice to</h6>
                    <h5>{{ $invoice->customer->name }}</h5>
                    <p class="fs--1">{{ $invoice->customer->getAddress->street }}<br>{{ $invoice->customer->getAddress->city }}, {{ $invoice->customer->getAddress->state }}<br>{{ $invoice->customer->getAddress->country }}</p>
                    <p class="fs--1"><a href="mailto:{{ $invoice->customer->email }}">{{ $invoice->customer->email }}</a><br><a href="tel:{{ $invoice->customer->phone }}">{{ $invoice->customer->phone }}</a></p>
                </div>
                <div class="col-sm-auto ml-auto">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless fs--1">
                            <tbody>
                            <tr>
                                <th class="text-sm-right">Invoice No:</th>
                                <td>{{ $invoice->order_number }}</td>
                            </tr>
                            <tr>
                                <th class="text-sm-right">Order Date:</th>
                                <td>{{ $invoice->order_date }}</td>
                            </tr>
                            @if ($invoice->shipping_date)
                                <tr>
                                    <th class="text-sm-right">Shipping Date:</th>
                                    <td>{{ $invoice->shipping_date }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th class="text-sm-right">Invoice Date:</th>
                                <td>{{ $today }}</td>
                            </tr>
                            <tr>
                                <th class="text-sm-right">Payment Method:</th>
                                <td>{{ $invoice->customer->getPayment->name }}</td>
                            </tr>
                            <tr class="alert-success font-weight-bold">
                                <th class="text-sm-right">Amount Due:</th>
                                <td>{{ $invoice->balance }} TK</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="table-responsive mt-4 fs--1">
                <table class="table table-striped border-bottom">
                    <thead>
                    <tr class="bg-primary text-white">
                        <th class="border-0">Products</th>
                        <th class="border-0 text-center">Quantity</th>
                        <th class="border-0 text-right">Price</th>
                        <th class="border-0 text-right">Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice->salesDetails as $val)

                    <tr>
                        <td class="align-middle">
                            <h6 class="mb-0 text-nowrap">{{ $val->getProduct->title }}</h6>
                            <p class="mb-0">{{ $val->getProduct->subtitle ? $val->getProduct->subtitle : '' }}</p>
                        </td>
                        <td class="align-middle text-center">{{ $val->qty }}</td>
                        <td class="align-middle text-right">{{ $val->price }} TK</td>
                        <td class="align-middle text-right">{{ $val->subtotal }} TK</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row no-gutters justify-content-end">
                <div class="col-auto">
                    <table class="table table-sm table-borderless fs--1 text-right">
                        <tr>
                            <th class="text-900">Subtotal:</th>
                            <td class="font-weight-semi-bold">{{ $invoice->subtotal }} TK </td>
                        </tr>
                        @if ($invoice->freight_cost)
                        <tr>
                            <th class="text-900">Freight :</th>
                            <td class="font-weight-semi-bold">{{ $invoice->freight_cost }} TK</td>
                        </tr>
                        @endif
                        @if ($invoice->tax)
                        <tr>
                            <th class="text-900">Tax :</th>
                            <td class="font-weight-semi-bold">{{ $invoice->tax }} TK</td>
                        </tr>
                        @endif
                        @if ($invoice->discount)
                            <tr>
                                <th class="text-900">Discount {{ $invoice->discount }}%:</th>
                                <td class="font-weight-semi-bold">{{ $invoice->subtotal * $invoice->discount / 100 }} TK</td>
                            </tr>
                        @endif
                        <tr class="border-top">
                            <th class="text-900">Total:</th>
                            <td class="font-weight-semi-bold">{{ $invoice->total }} TK</td>
                        </tr>
                        <tr class="border-top border-2x font-weight-bold text-900">
                            <th>Amount Due:</th>
                            <td>{{ $invoice->balance }} TK</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <p class="fs--1 mb-0"><strong>Notes: </strong>We really appreciate your business and if there’s anything else we can do, please let us know!</p>
        </div>
    </div>
@endsection

@section('admin-js')
    <script>
        $('.print-window').click(function() {
            window.print();
        });
    </script>
@endsection
