    <div class="card">
        <div class="card-body py-0 px-0 px-sm-3">
            <div class="row ">

                <div class="col-sm-7 col-xl-8">
                    <h4 class="mb-1 mb-sm-0">Customer Information</h4>
                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        Estimate ID: {{$estimate->id ?? 'Unknown ID'}}
                    </p>
                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        Detail Service Type: @if($estimate->detilType == 1) Shop Detail @elseif($estimate->detailType == 2) Mobile Detail @endif
                    </p>

                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        Service Date: {{\Carbon\Carbon::parse($estimate->dateofService)->format('m-d-Y')}}
                    </p>
                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        Arrival Window: @if($estimate->arrivalTime){{\Carbon\Carbon::parse($estimate->arrivalTime)->format('H:i')}} to {{\Carbon\Carbon::parse($estimate->arrivalTime)->addHours(3)->format('H:i')}}@else TBD @endif
                    </p>
                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        Name: {{$customer->firstName ?? 'Unknown Customer'}} {{$customer->lastName ?? ''}}
                    </p>
                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        Phone: {{$customer->phoneNumber ?? ''}}
                    </p>
                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        Email: {{$customer->email ?? ''}}
                    </p>
                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        Address: {{$customer->address ?? ''}}
                    </p>
                </div>

                <div class="col-xl-4 text-right">
                    <a href=";javascript" data-toggle="modal" data-target="#customerModal"><i class="fas fa-edit"></i></a>
                </div>
            </div>
        </div>
    </div>
