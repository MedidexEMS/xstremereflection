<html>
<head>
    <title>Customer Estimate - PDF</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        tr {
            page-break-inside: avoid
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <img src="{{ public_path('/assets/img/logo1.png') }}" width="500px" height="150px" alt="logo" />
        </div>
        <div class="col-6">
            <address>
                4663 State Route 784 <br/>
                South Shore, Ky 41175 <br/>
                (740) 207-2847
            </address>
            <h1>Estimate ID: {{$estimate->id ?? 'Unknown ID'}}</h1>
            <h1>Estimate Date: {{\Carbon\Carbon::parse($estimate->created_at)->format('M d Y')}}</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-6">
            <h3>Customer Information</h3>
            <hr>
            <div class="row">
                Customer: {{$customer->firstName ?? 'Unknown Customer'}} {{$customer->lastName ?? ''}} - @if($customer->phoneNumber) {{ '('.substr($customer->phoneNumber, 0, 3).') '.substr($customer->phoneNumber, 3, 3).'-'.substr($customer->phoneNumber,6)  }} @endif <br />
                Address: {{$customer->address ?? ''}} <br/>
                Detail Service Type: @if($estimate->detilType == 1) Shop Detail @elseif($estimate->detailType == 2) Mobile Detail @else T.B.D @endif <br />
                Arrival Window: @if($estimate->arrivalTime){{\Carbon\Carbon::parse($estimate->arrivalTime)->format('H:i')}} to {{\Carbon\Carbon::parse($estimate->arrivalTime)->addHours(3)->format('H:i')}}@else TBD @endif <br/>
            </div>
        </div>
        <div class="col-6">
            <h3>Vehicle Information</h3>
            <hr>
            <h4 class="mb-1 mb-sm-0">Customer Information</h4>
            <p class="mb-0 font-weight-normal d-none d-sm-block">
                VIN Number: {{$estimate->vehicle->vehicleInfo->vin ?? 'VIN not provided at time of estimate.'}}
            </p>
            <p class="mb-0 font-weight-normal d-none d-sm-block">
                Vehicle Year: {{$estimate->vehicle->vehicleInfo->year}}
            </p>
            <p class="mb-0 font-weight-normal d-none d-sm-block">
                Vehicle Make: {{$estimate->vehicle->vehicleInfo->make}}
            </p>
            <p class="mb-0 font-weight-normal d-none d-sm-block">
                Vehicle Model/Style: {{$estimate->vehicle->vehicleInfo->model}} - {{$estimate->vehicle->vehicleInfo->style}}
            </p>
            <p class="mb-0 font-weight-normal d-none d-sm-block">
                Vehicle Color: {{$estimate->vehicle->vehicleInfo->colorInfo->description ?? ''}}
            </p>
        </div>
    </div>

    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Package #</th>
                <th>Description</th>
                <th>List Price</th>
                <th>Your Price</th>
                <th>Deposit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($estimate->packages as $packages)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td width="50%">
                    <h6>{{$packages->package->description}}</h6>
                    {!! $packages->package->details !!}
                </td>
                <td>${{$packages->listPrice ?? ''}}</td>
                <td>${{$packages->chargedPrice ?? ''}}</td>
                <td>${{$packages->deposit ?? ''}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <small>
                <strong>Note:</strong> This estimate is not a contract or a bill. It is our best guess at the total price to complete the work started above.
                Based upon our initial inspection or conversation, if prices change or additional parts and labor are required, we will inform you prior to
                proceeding with the work. Some estimates require security deposits at the time of accepting the estimate. Your estimate is valid for
                <strong>{{$estimate->days}} days</strong>. Please refer to our cancellation policy for more information about security deposit refunds.
            </small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-8 mr-2">
        <strong>X___________________________________________________________________________</strong>
    </div>
    <div class="col-3">
        <strong>____________________________________</strong>
    </div>
    <div class="col-8 mr-2">
        Customer Approval
    </div>
    <div class="col-3">
        Date
    </div>
</div>

</body>
</html>
