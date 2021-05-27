@extends('layouts.app')

@section('title', 'Add New Customer | Inventory POS')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-auto mb-2 mb-sm-0">
                    <h6 class="mb-0">DashBoard > Customer > Edit</h6>
                </div>
                <div class="col-sm-auto">
                    <a class="text-600" href="{{ route('home') }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="DashBoard"><svg class="svg-inline--fa fa-th fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="th" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M149.333 56v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zm181.334 240v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm32-240v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24zm-32 80V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm-205.334 56H24c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm386.667-56H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm0 160H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zM181.333 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24z"></path></svg><!-- <span class="fas fa-th"></span> --></a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('customer.update', $customer->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row no-gutters">
            <div class="col-lg-8 pr-lg-2">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Edit Customer</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="title_name">Customer Title</label>
                                    <input class="form-control @error('title_name') is-invalid @enderror" value="{{ $customer->title_name }}" id="title_name" name="title_name" type="text" required>
                                    @error('title_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" value="{{ $customer->name }}" id="name" name="name" type="text">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input class="form-control @error('email') is-invalid @enderror" value="{{ $customer->email }}" id="email" name="email" type="email" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input class="form-control @error('phone') is-invalid @enderror" value="{{ $customer->phone }}" id="phone" name="phone" type="text" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="website">Website (Optional)</label>
                                    <input class="form-control @error('website') is-invalid @enderror" value="{{ $customer->website }}" id="website" name="website" type="text">
                                    @error('selling_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks" cols="30" rows="4">{!! $customer->remarks !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Address</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="collapse" id="experience-form">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-0" for="address_name">Address Title</label>
                                        <input value="{{ $customer->getAddress->id }}" name="address" type="hidden" />
                                        <input class="form-control form-control-sm" id="address_name" value="{{ $customer->getAddress->address_name }}" type="text" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-0" for="street">Street Address</label>
                                        <input class="form-control form-control-sm" id="street" value="{{ $customer->getAddress->street }}" type="text" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-0" for="city">City</label>
                                        <input class="form-control form-control-sm" id="city" value="{{ $customer->getAddress->city }}" type="text" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-0" for="state">State</label>
                                        <input class="form-control form-control-sm" id="state" value="{{ $customer->getAddress->state }}" type="text" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-0" for="zip">Zip</label>
                                        <input class="form-control form-control-sm" id="zip" value="{{ $customer->getAddress->zip }}" type="text" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-0" for="country">Country</label>
                                        <input class="form-control form-control-sm" id="country" value="{{ $customer->getAddress->country }}" type="text" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="mb-0" for="remark">Remarks</label>
                                        <textarea class="form-control" id="remark" cols="30" rows="4">{!! $customer->getAddress->remarks !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                       <button class="btn btn-sm btn-success" type="button" id="{{ $customer->getAddress->id }}" onclick="update(this.id)">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <a class="mb-4 d-block d-flex align-items-center" href="#experience-form" data-toggle="collapse" aria-expanded="false" aria-controls="experience-form"><span class="circle-dashed"><span class="fas fa-edit"></span></span></a>
                            <div class="media-body position-relative pl-3">
                                <h6 class="fs-0 mb-0">{{ $customer->getAddress->street }} @if ($customer->getAddress->street) <small class="fas fa-check-circle text-primary ml-1" data-toggle="tooltip" data-placement="top" title="Verified" data-fa-transform="shrink-4 down-2"></small> @else No Address @endif</h6>
                                <p class="mb-1"> <a href="#experience-form" data-toggle="collapse" aria-expanded="false" aria-controls="experience-form">Edit</a></p>
                                <p class="text-1000 mb-0">{{ $customer->getAddress->city ? $customer->getAddress->city.',' : '' }} {{ $customer->getAddress->state }}</p>
                                <p class="text-1000 mb-0">{{ $customer->getAddress->country ? $customer->getAddress->country.',' : '' }} {{ $customer->getAddress->zip }}</p>
                                <hr class="border-dashed border-bottom-0" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 pl-lg-2">
                <div class="sticky-top sticky-sidebar">
                    <div class="card mb-3 overflow-hidden">
                        <div class="card-header">
                            <h5 class="mb-0">Settings</h5>
                        </div>
                        <div class="card-body bg-light">
                            <h6 class="mt-2 font-weight-bold">Status<span class="fs--2 ml-1 text-primary" data-toggle="tooltip" data-placement="top" title="You can go draft mode for this product. Then Product will be Invisible."><span class="fas fa-question-circle"></span></span></h6>
                            <fieldset id="group1">
                                <div class="pl-2">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="status" value="1" id="active" @if ($customer->status == 1) checked @endif />
                                        <label class="custom-control-label" for="active">Active</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" value="0" name="status" id="draft" @if ($customer->status == 0) checked @endif />
                                        <label class="custom-control-label" for="draft">Draft</label>
                                    </div>
                                </div>
                            </fieldset>
                            <hr class="border-dashed border-bottom-0">
                            <div class="mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0">Payment Methods</h5>
                                </div>
                                <div class="card-body bg-light">
                                    <fieldset id="group2">
                                        <div class="media">
                                            <div class="custom-control custom-radio">
                                                <input value="{{ $customer->getPayment->id }}" name="payment_method" type="hidden" />
                                                <input class="custom-control-input" type="radio" name="payment_name" value="Paypal" id="paypal" @if ($customer->getPayment->name == "Paypal") checked @endif />
                                                <label class="custom-control-label" for="paypal">
                                                    <div class="media-body position-relative pl-3">
                                                        <h6 class="fs-0 mb-0">Paypal
                                                            <small class="fas fa-check-circle text-primary ml-1" data-toggle="tooltip" data-placement="top" title="Verified" data-fa-transform="shrink-4 down-2"></small>
                                                        </h6>
                                                        <hr class="border-dashed border-bottom-0" />
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="media">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="payment_name" value="Skill" id="skill"@if ($customer->getPayment->name == "Skill") checked @endif />
                                                <label class="custom-control-label" for="skill">
                                                    <div class="media-body position-relative pl-3">
                                                        <h6 class="fs-0 mb-0">Skill
                                                            <small class="fas fa-check-circle text-primary ml-1" data-toggle="tooltip" data-placement="top" title="Verified" data-fa-transform="shrink-4 down-2"></small>
                                                        </h6>
                                                        <hr class="border-dashed border-bottom-0" />
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="media">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="payment_name" value="Bank" id="bank" @if ($customer->getPayment->name == "Bank") checked @endif />
                                                <label class="custom-control-label" for="bank">
                                                    <div class="media-body position-relative pl-3">
                                                        <h6 class="fs-0 mb-0">Bank
                                                            <small class="fas fa-check-circle text-primary ml-1" data-toggle="tooltip" data-placement="top" title="Verified" data-fa-transform="shrink-4 down-2"></small>
                                                        </h6>
                                                        <hr class="border-dashed border-bottom-0" />
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="media">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="payment_name" value="Cash" id="cash" @if ($customer->getPayment->name == "Cash") checked @endif />
                                                <label class="custom-control-label" for="cash">
                                                    <div class="media-body position-relative pl-3">
                                                        <h6 class="fs-0 mb-0">Cash
                                                            <small class="fas fa-check-circle text-primary ml-1" data-toggle="tooltip" data-placement="top" title="Verified" data-fa-transform="shrink-4 down-2"></small>
                                                        </h6>
                                                        <hr class="border-dashed border-bottom-0" />
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end mt-4"><button class="btn btn-primary" type="submit">Update </button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('admin-js')
    <script>
        // Update Request
        function update(id) {
            var address_name = document.getElementById('address_name').value;
            var street       = document.getElementById('street').value;
            var city         = document.getElementById('city').value;
            var state        = document.getElementById('state').value;
            var zip          = document.getElementById('zip').value;
            var country      = document.getElementById('country').value;
            var remarks      = document.getElementById('remark').value;
            axios.put('/address/' + id, { address_name: address_name, street: street, city: city, state: state, zip: zip, country: country, remarks: remarks })
                .then(response => {
                    location.reload();
                    toastr.success("Address successfully updated");
                })
                .catch(error => {
                    toastr.warning("Opps! Something is wrong.");
                })
        }
    </script>
@endsection
