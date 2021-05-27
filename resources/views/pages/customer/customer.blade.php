@extends('layouts.app')

@section('title', 'Customers | Inventory POS')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-auto mb-2 mb-sm-0">
                    <h6 class="mb-0">DashBoard > Customer</h6>
                </div>
                <div class="col-sm-auto">
                    <a class="text-600" href="{{ route('home') }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="DashBoard"><svg class="svg-inline--fa fa-th fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="th" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M149.333 56v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zm181.334 240v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm32-240v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24zm-32 80V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm-205.334 56H24c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm386.667-56H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm0 160H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zM181.333 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24z"></path></svg><!-- <span class="fas fa-th"></span> --></a>
                </div>
            </div>
        </div>
    </div>
    @if (count($customers) > 0)
        <div class="card mb-3">
            <div class="card-header">
                <div class="row align-items-center justify-content-between">
                    <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                        <h5 class="fs-1 mb-0 text-nowrap py-2 py-xl-0">Vendor List</h5>
                    </div>
                    <div class="col-6 col-sm-auto ml-auto text-right pl-0">
                        <div class="d-none" id="purchases-actions">
                            <div class="input-group input-group-sm"><select class="custom-select cus" aria-label="Bulk actions">
                                    <option value="Delete" selected>Delete</option>
                                </select><button class="btn btn-falcon-default btn-sm ml-2" id="allDelete" type="button">Apply</button></div>
                        </div>
                        <div id="dashboard-actions">
                            <a href="{{ route('customers.create') }}" class="btn btn-falcon-default btn-sm" type="button">
                                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                                <span class="d-none d-sm-inline-block ml-1">Add New</span>
                            </a>
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
                            <th class="sort pr-1 align-middle">Title</th>
                            <th class="sort pr-1 align-middle">Full Name</th>
                            <th class="sort pr-1 align-middle">Email</th>
                            <th class="sort pr-1 align-middle">Phone</th>
                            <th class="sort pr-1 align-middle">City & State</th>
                            <th class="sort pr-1 align-middle text-center">Modify On</th>
                            <th class="sort pr-1 align-middle text-center">Created By</th>
                            <th class="no-sort pr-1 align-middle data-table-row-action">Action</th>
                        </tr>
                        </thead>
                        <tbody id="purchases">
                        @foreach($customers as $key => $val)
                            <tr class="btn-reveal-trigger" id="value_{{ $val->id }}">
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input checkbox-bulk-select-target" type="checkbox" id="checkbox_{{ $val->id }}" />
                                        <label class="custom-control-label" for="checkbox_{{ $val->id }}"></label>
                                    </div>
                                </td>
                                <th class="align-middle"><a class="color-blue">{{ $val->title_name }}</a></th>
                                <td class="align-middle">{{ $val->name }}</td>
                                <td class="align-middle">{{ $val->email }}</td>
                                <td class="align-middle">{{ $val->phone }}</td>
                                <td class="align-middle">
                                    {{ $val->getAddress->city ? $val->getAddress->city.',' : '' }} {{ $val->getAddress->state }}
                                </td>
                                <td class="align-middle text-center">
                                    {{ $val->updated_at ? $val->updated_at->diffForHumans() : "$val->created_at->diffForHumans()" }}
                                </td>
                                <td class="align-middle text-center fs-0">
                                        <span class="badge badge rounded-capsule badge-soft-success">
                                            {{ $val->created_by ? $val->created_by : "N/A" }}
                                            <span class="ml-1 fas fa-user" data-fa-transform="shrink-2"></span>
                                        </span>
                                </td>
                                <td class="align-middle white-space-nowrap">
                                    <div class="dropdown text-sans-serif"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dropdown0" data-toggle="dropdown" data-boundary="html" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                        <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown0">
                                            <div class="bg-white py-2">
                                                <a class="dropdown-item" href="{{ route('customers.edit', $val->id) }}">Edit</a>
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
                        <h3>No More Customer Here!</h3>
                        <p class="lead">Create a New Cutomer and Start Something Beautiful.</p><a href="{{ route('customers.create') }}" class="btn btn-falcon-primary">Add New</a>
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
                            axios.post('/all-customers', { id: data_arr})
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
                    axios.delete('/customers/' + id)
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
