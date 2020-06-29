@foreach($packages as $package)
    <div class="col-xl-3 col-sm-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row mb-1">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{$package->description}}</h3>
                            <p class="text-success ml-2 mb-0 font-weight-medium"> # Sold</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-warning ">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                    </div>
                </div>

                <h6 class="text-muted font-weight-normal">${{$package->cost}}</h6>

                @if($package->companyId == 0) <h6 class="text-blue font-weight-bold">XR Package</h6> @endif

                <div class="row">
                    <div class="col-3">
                        <div class="d-flex align-items-center align-self-start">
                            <button class="btn btn-primary">Edit</button>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="">
                            <button class="btn btn-dark">View Package Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
