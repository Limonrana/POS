@extends('layouts.app')

@section('title', 'Stock Management | Inventory POS')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-auto mb-2 mb-sm-0">
                    <h6 class="mb-0">DashBoard > Stock</h6>
                </div>
                <div class="col-sm-auto">
                    <a class="text-600" href="{{ route('home') }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="DashBoard"><svg class="svg-inline--fa fa-th fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="th" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M149.333 56v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zm181.334 240v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm32-240v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24zm-32 80V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm-205.334 56H24c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm386.667-56H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm0 160H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zM181.333 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24z"></path></svg><!-- <span class="fas fa-th"></span> --></a>
                </div>
            </div>
        </div>
    </div>
    @if (count($stocks) > 0)
        <div class="card mb-3">
            <div class="card-header">
                <div class="row align-items-center justify-content-between">
                    <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                        <h5 class="fs-1 mb-0 text-nowrap py-2 py-xl-0">Stock Management</h5>
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
                            <th class="sort pr-1 align-middle">Product Name</th>
                            <th class="sort pr-1 align-middle">Quantity</th>
                            <th class="sort pr-1 align-middle">Status</th>
                            <th class="sort pr-1 align-middle">Modify On</th>
                            <th class="sort pr-1 align-middle text-center">Modify By</th>
                            <th class="no-sort pr-1 align-middle data-table-row-action">Action</th>
                        </tr>
                        </thead>
                        <tbody id="purchases">
                            @foreach($stocks as $key => $val)
                                <tr class="btn-reveal-trigger" id="value_{{ $val->id }}">
                                    <td class="align-middle">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input checkbox-bulk-select-target" type="checkbox" id="checkbox_{{ $val->id }}" />
                                            <label class="custom-control-label" for="checkbox_{{ $val->id }}"></label>
                                        </div>
                                    </td>
                                    <th class="align-middle"><a class="color-blue">{{ $val->title }}</a></th>
                                    <th class="align-middle">
                                            <span class="badge badge rounded-capsule badge-soft-success">
                                                {{ $val->stock == 0 ? "0" : $val->stock }}
                                                <span class="ml-1 fas fa-cart-plus" data-fa-transform="shrink-2"></span>
                                            </span>
                                    </th>
                                    <th class="align-middle">
                                        @if ($val->stock == 0)
                                            <span class="badge badge rounded-capsule badge-danger">Out Of Stock</span>
                                        @elseif($val->stock < 6)
                                            <span class="badge badge rounded-capsule badge-warning">Limited Stock</span>
                                        @elseif ($val->stock == null)
                                            <span class="badge badge rounded-capsule badge-danger">Out Of Stock</span>
                                        @else
                                            <span class="badge badge rounded-capsule badge-soft-success">Stock Available</span>
                                        @endif
                                    </th>
                                    <td class="align-middle">{{ $val->updated_at ? $val->updated_at->diffForHumans() : $val->created_at->diffForHumans() }}</td>
                                    <td class="align-middle text-center fs-0">
                                        <span class="badge badge rounded-capsule badge-soft-success">
                                            {{ $val->updated_by ? $val->updated_by : $val->created_by }}
                                            <span class="ml-1 fas fa-user" data-fa-transform="shrink-2"></span>
                                        </span>
                                    </td>
                                    <td class="align-middle white-space-nowrap">
                                        <div class="dropdown text-sans-serif"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dropdown0" data-toggle="dropdown" data-boundary="html" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown0">
                                                <div class="bg-white py-2">
                                                    <a class="dropdown-item" href="#!" id="{{ $val->id }}" onclick="Edit(this.id)" data-toggle="modal" data-target="#categoryEdit">Edit</a>
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
                        <h3>No More Product Here!</h3>
                        <p class="lead">Create a New Category and Start Something Beautiful.</p><a class="btn btn-falcon-primary" data-toggle="modal" data-target="#categoryAdd" href="{{ route('product.create') }}">Add New</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

{{--    Category Add Model--}}
    <!-- Edit Modal-->
    <div class="modal fade" id="categoryEdit" tabindex="-1" role="dialog" aria-labelledby="categoryEdit-label" aria-hidden="true">
        <div class="modal-dialog mt-6" role="document">
            <div class="modal-content border-0">
                <div class="modal-header px-5 text-white position-relative modal-shape-header">
                    <div class="position-relative z-index-1">
                        <div>
                            <h4 class="mb-0 text-white" id="authentication-modal-label">Edit Stock</h4>
                        </div>
                    </div><button class="close text-white position-absolute t-0 r-0 mt-1 mr-1" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body py-4 px-5">
                    <form action="" method="POST" id="editUpdate">
                        @csrf
                        <div class="form-group">
                            <label for="title">Product Name</label>
                            <input class="form-control" type="text" id="title" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="qty">Product Quantity</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="number" id="qty"/>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block mt-3" type="button" onclick="editUpdate()" name="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script>
        //Category Edit Request
        var cName = document.getElementById('title');
        var qty = document.getElementById('qty');
        var action = document.getElementById('editUpdate');
        var cId = [];
        function Edit(id) {
            axios.get('/get-product/' + id)
                .then(response => {
                    var i = response.data;
                    cName.value = i.title;
                    qty.value = i.stock;
                    cId.push(i.id);
                })
                .catch()
        };
        function editUpdate() {
            var qty = document.getElementById('qty').value;
            axios.put('/stocks/' + cId[0], { stock: qty })
                .then(response => {
                    location.reload();
                    toastr.success("Stock successfully updated");
                })
                .catch(error => {
                    toastr.warning("Opps! Something is wrong.");
                })
        }
    </script>
@endsection
