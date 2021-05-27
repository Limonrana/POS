@extends('layouts.app')

@section('title', 'Product | Inventory POS')

@section('content')
    @if (count($products) > 0)
        <div class="card mb-3">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-sm-auto mb-2 mb-sm-0">
                        <h6 class="mb-0">Showing {{ count($products) }} of {{ $count }} Products</h6>
                    </div>
                    <div class="col-sm-auto">
                        <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('product.create') }}" data-toggle="tooltip" data-placement="top" title="Add New Product"><span class="fas fa-plus"></span> Add New</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                  <!--Start Product -->
                    @foreach($products as $val)
                        <div class="mb-4 col-md-4 col-lg-3" id="value_{{ $val->id }}">
                            <div class="border rounded h-100 d-flex flex-column justify-content-between pb-3">
                                <div class="overflow-hidden">
                                    <div class="position-relative rounded-top overflow-hidden">
                                        <a class="d-block" href="{{ route('product.show', $val->slug) }}">
                                            <img class="img-fluid rounded-top" src="{{ asset($val->image ? $val->photo->image_path : 'assets/img/no-image.png') }}"/>
                                        </a>
                                        <span class="badge badge-pill badge-success position-absolute r-0 t-0 mt-2 mr-2 z-index-2">
                                           SKU: {{ $val->code }}
                                        </span>
                                        </div>
                                    <div class="p-3">
                                        <h5 class="fs-0">
                                            <a class="text-dark" href="{{ route('product.show', $val->slug) }}">
                                                {{ $val->title }}
                                            </a>
                                        </h5>
                                        <p class="text-dark">{{ $val->sub_title ? $val->sub_title : '' }}</p>
                                        <p class="fs--1 mb-3 text-500">Category: {{ $val->category->name }}</p>
                                        <h5 class="fs-md-2 text-warning mb-0 d-flex align-items-center mb-3">BDT {{ $val->buying_price }}</h5>
                                        <p class="fs--1 mb-1">Unit: <strong>{{ $val->unit->name }}</strong></p>
                                        <p class="fs--1 mb-1">Stock: <strong class="text-success">
                                                @if ($val->stock == 0 OR $val->stock == null)
                                                    <span class="badge badge-danger">Out Of Stock</span>
                                                @elseif($val->stock < 6)
                                                   <span class="badge badge-warning">Low Stock</span> {{ $val->stock }} {{ $val->unit->name }}
                                                @else
                                                    {{ $val->stock }} {{ $val->unit->name }}
                                                @endif
                                            </strong></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between px-3">
                                    <div class="text-right">
                                        <a class="btn btn-sm btn-falcon-default" href="{{ route('product.show', $val->slug) }}" data-toggle="tooltip" data-placement="top" title="VIEW">
                                            <span class="fas fa-eye"></span>
                                        </a>
                                        <a class="btn btn-sm btn-falcon-default" href="{{ route('product.edit', $val->id) }}" data-toggle="tooltip" data-placement="top" title="EDIT">
                                            <span class="fas fa-edit"></span>
                                        </a>
                                        <a class="btn btn-sm btn-falcon-default" href="#" id="{{ $val->id }}" onclick="singleDelete(this.id)" data-toggle="tooltip" data-placement="top" title="DELETE">
                                            <span class="fas fa-trash-alt"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                <!--End Product -->
                </div>
            </div>
            <div class="card-footer bg-light d-flex justify-content-center">
                    {{ $products->links() }}
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
                        <p class="lead">Create a New Product and Start Something Beautiful.</p><a class="btn btn-falcon-primary" href="{{ route('product.create') }}">Add New</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('admin-css')
    <style>
        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #2c7be5;
            border-color: #2c7be5;
        }
        .page-item:hover .page-link {
            z-index: 3;
            color: #fff;
            background-color: #2c7be5;
            border-color: #2c7be5;
        }
    </style>
@endsection

@section('admin-js')
    <script>
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
                    axios.delete('/product/' + id)
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
