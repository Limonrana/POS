@extends('layouts.app')

@section('title', 'Dashboard | Inventory POS')

@section('content')
    <div class="card mb-3">
        <div class="card-body rounded-soft bg-gradient">
            <div class="row text-white align-items-center no-gutters">
                <div class="col">
                    <h4 class="text-white mb-0">Today {{ number_format($today_sales, 2) }} TK</h4>
                    <p class="fs--1 font-weight-semi-bold">Yesterday <span class="opacity-50">{{ number_format($yesterday_sales, 2) }} TK</span></p>
                </div>
                <div class="col-auto d-none d-sm-block"><select class="custom-select custom-select-sm mb-3" id="dashboard-chart-select">
                        <option value="all">All Payments</option>
                        <option value="successful" selected="selected">Successful Payments</option>
                        <option value="failed">Failed Payments</option>
                    </select></div>
            </div><canvas class="max-w-100 rounded" id="chart-line" width="1618" height="375" aria-label="Line chart" role="img"></canvas>
        </div>
    </div>
    <div class="card-deck">
        <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card" style="background-image:url({{ asset('assets/img/illustrations/corner-1.png') }});"></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6>This Month Sales<span class="badge badge-soft-warning rounded-capsule ml-2">{{ ($prev_month_sales - $current_month_sales) == 0 ? '0.00' : number_format(($prev_month_sales - $current_month_sales) / $current_month_sales * 100, 2) }}%</span></h6>
                <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning">BDT. {{ number_format($current_month_sales, 2) }}</div><a class="font-weight-semi-bold fs--1 text-nowrap" href="#!">All sales<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
            </div>
        </div>
        <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card" style="background-image:url({{ asset('assets/img/illustrations/corner-2.png') }});"></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6>This Month Purchase<span class="badge badge-soft-info rounded-capsule ml-2">{{ ($prev_month_purchase - $current_month_purchase) == 0 ? '0.00' : number_format(($prev_month_purchase - $current_month_purchase) / $current_month_purchase * 100, 2) }}%</span></h6>
                <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-info">BDT. {{ number_format($current_month_purchase, 2) }}</div><a class="font-weight-semi-bold fs--1 text-nowrap" href="#!">All purchase<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
            </div>
        </div>
        <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card" style="background-image:url({{ asset('assets/img/illustrations/corner-3.png') }});"></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6>This Month Revenue<span class="badge badge-soft-success rounded-capsule ml-2">{{ ($getPrevRevenue - $getRevenue) == 0 ? '0.00' : number_format(($getPrevRevenue - $getRevenue) / $getRevenue * 100, 2) }}%</span></h6>
                <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif">BDT. {{ number_format($getRevenue, 2) }}</div><a class="font-weight-semi-bold fs--1 text-nowrap" href="#!">Statistics<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
            </div>
        </div>
    </div>
    @if (count($sales) > 0)
        <div class="card mb-3 purchase">
            <div class="card-header">
                <div class="row align-items-center justify-content-between">
                    <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                        <h5 class="fs-1 mb-0 text-nowrap py-2 py-xl-0">Sales List</h5>
                    </div>
                    <div class="col-6 col-sm-auto ml-auto text-right pl-0">
                        <div class="d-none" id="purchases-actions">
                            <div class="input-group input-group-sm"><select class="custom-select cus" aria-label="Bulk actions">
                                    <option value="Delete" selected>Delete</option>
                                </select><button class="btn btn-falcon-default btn-sm ml-2" id="allDelete" type="button">Apply</button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0">
                <div class="dashboard-data-table">
                    <table class="table table-sm table-dashboard fs--1 data-table border-bottom" id='recordsTable' data-options='{"responsive":false,"pagingType":"simple","lengthChange":false,"searching":false,"pageLength":8,"columnDefs":[{"targets":[0,6],"orderable":false}],"language":{"info":"_START_ to _END_ Items of _TOTAL_ — <a href=https://prium.github.io/"#!\" class=\"font-weight-semi-bold\"> view all <span class=\"fas fa-angle-right\" data-fa-transform=\"down-1\"></span> </a>"},"buttons":["copy","excel"]}'>
                        <thead class="bg-200 text-900">
                        <tr>
                            <th class="no-sort pr-1 align-middle data-table-row-bulk-select">
                                <div class="custom-control custom-checkbox"><input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-purchases-select" type="checkbox" data-checkbox-body="#purchases" data-checkbox-actions="#purchases-actions" data-checkbox-replaced-element="#dashboard-actions" /><label class="custom-control-label" for="checkbox-bulk-purchases-select"></label></div>
                            </th>
                            <th class="sort pr-1 align-middle">Order Number</th>
                            <th class="sort pr-1 align-middle">Customer</th>
                            <th class="sort pr-1 align-middle">Order Date</th>
                            <th class="sort pr-1 align-middle">ship date</th>
                            <th class="sort pr-1 align-middle">Total</th>
                            <th class="sort pr-1 align-middle">Balance</th>
                            <th class="sort pr-1 align-middle text-center">Modify On</th>
                            <th class="sort pr-1 align-middle text-center">Status</th>
                            <th class="sort pr-1 align-middle text-center">Pay</th>
                            <th class="no-sort pr-1 align-middle data-table-row-action">Action</th>
                        </tr>
                        </thead>
                        <tbody id="purchases">
                        @foreach($sales as $key => $val)
                            <tr class="btn-reveal-trigger" id="value_{{ $val->id }}">
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input checkbox-bulk-select-target" type="checkbox" id="checkbox_{{ $val->id }}" />
                                        <label class="custom-control-label" for="checkbox_{{ $val->id }}"></label>
                                    </div>
                                </td>
                                <th class="align-middle"><a href="{{ route('sales.edit', $val->id) }}" class="color-blue">{{ $val->order_number }}</a></th>
                                <td class="align-middle">{{ \Illuminate\Support\Str::limit($val->customer->title_name, 6) }} - {{ \Illuminate\Support\Str::limit($val->customer->name, 12) }}</td>
                                <td class="align-middle">{{ $val->order_date }}</td>
                                <td class="align-middle">
                                    {{ $val->shipping_date ? $val->shipping_date : 'N/A' }}
                                </td>
                                <td class="align-middle">{{ $val->total }} TK</td>
                                <td class="align-middle">{{ $val->balance ? $val->balance : '00.00' }} TK</td>
                                <td class="align-middle text-center">
                                    {{ $val->updated_at ? $val->updated_at->diffForHumans() : "$val->created_at->diffForHumans()" }}
                                </td>
                                <td class="align-middle text-center fs-0">
                                    @if ($val->status == 0)
                                        <span class="badge badge rounded-capsule badge-warning">
                                            Unfulfilled
                                            <span class="ml-1 fas fa-user" data-fa-transform="shrink-2"></span>
                                        </span>
                                    @else
                                        <span class="badge badge rounded-capsule badge-soft-success">
                                            Fulfilled
                                            <span class="ml-1 fas fa-user" data-fa-transform="shrink-2"></span>
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle text-center fs-0">
                                    @if ($val->is_pay == 0)
                                        <span class="badge badge rounded-capsule badge-danger">Unpaid</span>
                                    @elseif ($val->is_pay == 2)
                                        <span class="badge badge rounded-capsule badge-warning">Partial</span>
                                    @else
                                        <span class="badge badge rounded-capsule badge-soft-success">Paid</span>
                                    @endif
                                </td>
                                <td class="align-middle white-space-nowrap">
                                    <div class="dropdown text-sans-serif"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dropdown0" data-toggle="dropdown" data-boundary="html" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                        <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown0">
                                            <div class="bg-white py-2">
                                                <a class="dropdown-item" href="{{ route('sales.edit', $val->id) }}">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('sales.invoice', $val->id) }}">Invoice</a>
                                                <div class="dropdown-divider"></div>
                                                @if ($val->status == 0)
                                                    <a class="dropdown-item" href="{{ route('sales.fulfillment', $val->id) }}">Fulfill</a>
                                                @else
                                                    <a class="dropdown-item" href="{{ route('sales.unfulfillment', $val->id) }}">Unfulfill</a>
                                                @endif
                                                <div class="dropdown-divider"></div>
                                                @if ($val->is_pay == 0)
                                                    <a class="dropdown-item" href="{{ route('sales.pay', $val->id) }}">Pay</a>
                                                @elseif ($val->is_pay == 2)
                                                    <a class="dropdown-item" href="{{ route('sales.pay', $val->id) }}">Pay Left</a>
                                                @else
                                                    <a class="dropdown-item" href="{{ route('sales.unpay', $val->id) }}">Unpay</a>
                                                @endif
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="#" id="{{ $val->id }}" onclick="singleDelete(this.id)">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body overflow-hidden p-lg-7">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-6"><img class="img-fluid" src="{{ asset('assets/img/illustrations/4.png') }}" alt=""></div>
                    <div class="col-lg-6 pl-lg-4 my-5 text-center text-lg-left">
                        <h3>No More Sales Here!</h3>
                        <p class="lead">Create a New Sales and Start Something Beautiful.</p><a href="{{ route('sales.create') }}" class="btn btn-falcon-primary">Add New</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('admin-js')
    <script>
        // Bulk Delete Option Start
        $(document).ready(function(){
            $('#allDelete').click(function(){
                var data_arr = [];
                // Get checked checkboxes
                $('#recordsTable input[type=checkbox]').each(function() {
                    if (jQuery(this).is(":checked")) {
                        var id = this.id;
                        var splitid = id.split('_');
                        var postid = splitid[1];
                        data_arr.push(postid);
                    }
                });
                if(data_arr.length > 0){
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //Delete Request Send
                            axios.post('/all-sales', { id: data_arr})
                                .then(response => {
                                    $.each(data_arr, function( i,l ){
                                        $("#value_"+l).remove();
                                    });
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                })
                                .catch(error => {
                                    toastr.warning("Opps! Something is wrong.");
                                })
                        }
                    })
                }
            });
        });

        // Single Delete Option Start
        function singleDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //Delete Request Send
                    axios.delete('/sales/' + id)
                        .then(response => {
                            $("#value_"+id).remove();
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        })
                        .catch(error => {
                            toastr.warning("Opps! Something is wrong.");
                        })
                }
            })
        };

    </script>
@endsection
