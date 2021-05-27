@extends('layouts.app')

@section('title', 'Sales Report | Inventory POS')

@section('content')
    <div class="sales-report">
        <div class="media mb-4 mt-3"><span class="fa-stack mr-2 ml-n1"><i class="fas fa-circle fa-stack-2x text-300"></i> <i class="fa-inverse fa-stack-1x text-primary fas fa-percentage"></i></span>
            <div class="media-body">
                <h5 class="mb-0 text-primary position-relative"><span class="bg-200 pr-3">Sales Report</span><span class="border position-absolute absolute-vertical-center w-100 z-index--1 l-0"></span></h5>
                <p class="mb-0">You can see your total sales report from below.</p>
            </div>
        </div>

        <div class="card-deck">
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url({{ asset('assets/img/illustrations/corner-1.png') }});"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6>Total Sales<span class="badge badge-soft-warning rounded-capsule ml-2">{{ ($yesterday_sales - $today_sales) == 0 ? '0.00' : number_format(($yesterday_sales - $today_sales) / $today_sales * 100, 2) }}%</span></h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning">BDT. {{ number_format($today_sales, 2) }}</div><a class="font-weight-semi-bold fs--1 text-nowrap" href="#!">Statistics<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
                </div>
            </div>
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url({{ asset('assets/img/illustrations/corner-2.png') }});"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6>Monthly Sales<span class="badge badge-soft-info rounded-capsule ml-2">{{ ($prev_sales - $monthly_sales) == 0 ? '0.00' : number_format(($prev_sales - $monthly_sales) / $monthly_sales * 100, 2) }}%</span></h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-info">BDT. {{ number_format($monthly_sales, 2) }}</div><a class="font-weight-semi-bold fs--1 text-nowrap" href="#!">Statistics<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
                </div>
            </div>
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url({{ asset('assets/img/illustrations/corner-3.png') }});"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6>Yearly Sales<span class="badge badge-soft-success rounded-capsule ml-2">{{ ($prev_year - $yearly_sales) == 0 ? '0.00' : number_format(($prev_year - $yearly_sales) / $yearly_sales * 100, 2) }}%</span></h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif">BDT. {{ number_format($yearly_sales, 2) }}</div><a class="font-weight-semi-bold fs--1 text-nowrap" href="#!">Statistics<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
                </div>
            </div>
        </div>
        <template  v-if="sales.length">
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                            <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">All Sales</h5>
                        </div>
                        <div class="col-6 col-sm-auto ml-auto text-right pl-0">
                            <div id="dashboard-actions">
                                <button class="btn btn-falcon-default btn-sm" type="button">
                                    <span class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span>
                                    <span class="d-none d-sm-inline-block ml-1">Export</span>
                                </button>
                                <button class="btn btn-danger btn-sm mx-2" type="button" @click="showSearch()">
                                    <span class="far fa-arrow-alt-circle-left" data-fa-transform="shrink-3 down-2"></span>
                                    <span class="d-none d-sm-inline-block ml-1">Cancel</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0">
                    <div class="falcon-data-table">
                        <table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100" data-options='{"searching":false,"responsive":false,"pageLength":20,"info":true,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39; p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
                            <thead class="bg-200">
                            <tr>
                                <th class="sort">Order #</th>
                                <th class="sort">Customer</th>
                                <th class="sort">Inventory Status</th>
                                <th class="sort">Payment Status</th>
                                <th class="sort">Date</th>
                                <th class="sort">SubTotal</th>
                                <th class="sort">Freight</th>
                                <th class="sort">Total Tax</th>
                                <th class="sort">Total</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <tr v-for="(item, index) in sales">
                                <td>${ item.order_number }</td>
                                <td>${ item.customer.name }</td>
                                <td v-if="item.status == 0">Unfulfilled</td>
                                <td v-else>Fulfilled</td>
                                <td v-if="item.is_pay == 0">Unpaid</td>
                                <td v-else-if="item.is_pay == 2">Partial</td>
                                <td v-else>Paid</td>
                                <td>${ item.order_date }</td>
                                <td>${ item.subtotal } Tk</td>
                                <td>${ item.freight_cost } Tk</td>
                                <td>${ item.tax } Tk</td>
                                <td>${ item.total } Tk</td>
                            </tr>
                            </tbody>
                            <tfoot class="bg-200">
                            <tr>
                                <th>Grand Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>${ subTotal } Tk</th>
                                <th>${ freightTotal } Tk</th>
                                <th>${ taxTotal } Tk</th>
                                <th>${ total } Tk</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="card h-100 mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Search Sales Report</h5>
                </div>
                <div class="bg-light card-body">
                    <div class="row no-gutters">
                        <div class="col-md-6 col-6 pr-2">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input class="form-control datetimepicker" id="start_date" type="text" data-options='{"dateFormat":"Y-m-d"}'>
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label for="datetimepicker">Start Date</label>--}}
{{--                                <input class="form-control datetimepicker" id="datetimepicker" type="text" data-options='{"enableTime":true,"dateFormat":"d/m/Y H:i"}'>--}}
{{--                            </div>--}}
                        </div>
                        <div class="col-md-6 col-6 pl-2">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input class="form-control datetimepicker" id="end_date" type="text" data-options='{"dateFormat":"Y-m-d"}'>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block" type="button" @click="getSales()"><span class="fa fa-lock mr-2"></span> Search Report</button>
                </div>
            </div>
        </template>
    </div>
@endsection

@section('admin-css')
    <link href="{{ asset('assets/lib/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection

@section('admin-js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/lib/flatpickr/flatpickr.min.js') }}"></script>
@endsection
