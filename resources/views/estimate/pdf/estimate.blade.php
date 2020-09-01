<html>
<head>
    <title>Customer Estimate - PDF</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
            <img src="{{ public_path('assets/img/logo1.png') }}" width="450px" height="140px" alt="logo" />
        </div>
        <div class="col-6">
            <address>
                4663 State Route 784 <br/>
                South Shore, Ky 41175 <br/>
                (740) 207-2847
            </address>
            <h3>Estimate ID: {{$estimate->id ?? 'Unknown ID'}}</h3>
            <h3>Estimate Date: {{\Carbon\Carbon::parse($estimate->created_at)->format('M d Y')}}</h3>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-6">
            <h3>Customer Information</h3>
            <hr>
            <div class="row">
                Customer: {{$customer->firstName ?? 'Unknown Customer'}} {{$customer->lastName ?? ''}} - @if($customer->phoneNumber) {{ '('.substr($customer->phoneNumber, 0, 3).') '.substr($customer->phoneNumber, 3, 3).'-'.substr($customer->phoneNumber,6)  }} @endif <br />
                Address: {{$customer->address ?? ''}} <br/>
                Date of Service: @if($estimate->dateofService){{\Carbon\Carbon::parse($estimate->dateofService)->format('M d Y')}} @else TBD @endif <br />
                Detail Service Type: @if($estimate->detilType == 1) Shop Detail @elseif($estimate->detailType == 2) Mobile Detail @else T.B.D @endif <br />
                Arrival Window: @if($estimate->arrivalTime){{\Carbon\Carbon::parse($estimate->arrivalTime)->format('H:i')}} to {{\Carbon\Carbon::parse($estimate->arrivalTime)->addHours(3)->format('H:i')}}@else TBD @endif <br/>
            </div>
        </div>
        <div class="col-6">
            <h3>Vehicle Information</h3>
            <hr>
            @if($estimate->vehicle)
                VIN Number: {{$estimate->vehicle->vehicleInfo->vin ?? 'VIN not provided at time of estimate.'}} <br />

                Vehicle Year: {{$estimate->vehicle->vehicleInfo->year}} <br />


                Vehicle Make: {{$estimate->vehicle->vehicleInfo->make}} <br />


                Vehicle Model/Style: {{$estimate->vehicle->vehicleInfo->model}} - {{$estimate->vehicle->vehicleInfo->style}} <br />


                Vehicle Color: {{$estimate->vehicle->vehicleInfo->colorInfo->description ?? ''}}
            @else
                No Vehicle information added.
            @endif



        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <small> <strong> Reported Problem: </strong> {!! $estimate->problem ?? '' !!} </small>
        </div>
    </div>

    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Package #</th>
                <th>Description</th>
                @if($estimate->ndp)
                    <td>Pricing Information</td>
                @else
                    <th>List Price</th>
                    <th>Your Price</th>
                    <th>Deposit</th>
                @endif

            </tr>
            </thead>
            <tbody>
            @foreach($estimate->packages as $packages)
            <tr @if($estimate->approvedPackage == $packages->id) class="bg-success" @endif>
                <td>{{$loop->iteration}}</td>
                <td width="50%">
                    <h6>{{$packages->package->description}}</h6>
                    {!! $packages->package->details !!} <br />
                    <small>@if($packages->package->items) @foreach($packages->package->items as $item)
                        {{$item->desc->description}} @if($loop->last) @else , @endif @endforeach  @endif</small>
                    @if($packages->addOnService)
                        <table class="table table-sm">
                            <tr>
                                <th><h6>Add on Services</h6></th>
                            </tr>
                            @foreach($packages->addOnService as $aos)
                                <tr>
                                    <td>
                                        @if($aos->serviceId == 0) {{$aos->description ?? ''}}  @else {{$aos->service->description  }} @endif - <small>List Price: ${{$aos->service->charge ?? '0.00'}}  Charged: {{$aos->price ?? '0.00'}} </small>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </td>
                @if($estimate->ndp)
                    <td>Pricing By National Detail Pros</td>
                @else
                    <td>${{$packages->listPrice ?? ''}}</td>
                    <td>${{$packages->chargedPrice ?? ''}}</td>
                    <td>${{$packages->deposit ?? ''}}</td>
                @endif
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
        @if($estimate->signed) <img src="{{public_path($estimate->signature)}}" width="200px" height="100px">  @else <strong>X___________________________________________________________________________</strong> @endif
    </div>
    <div class="col-3 align-text-bottom">
        @if($estimate->signed) {{\Carbon\Carbon::parse($estimate->signed)->format('m/d/Y H:i')}}  @else  <strong>____________________________________</strong> @endif
    </div>

</div>

<div class="row">
    <div class="col-8 mr-2">
        Customer Approval
    </div>
    <div class="col-3">
        Date
    </div>
</div>

<div style="page-break-after: always; page-break-inside: avoid;"></div>

<div class="row">
    <div class="col-xl-6">
        <strong>What do I need to do prior to the detail:</strong> Please be sure to have all personal belongings out of the vehicle prior to having it detailed.
        We respect your belongings and wish that nothing happens to them. Belongings left in the vehicle will be placed in a box for your retrieval
        after the detail is completed. If the technician has to remove large amounts of trash or belongings there is a $25.00 fee added to your estimate. <p />
        <strong>Just had your car detailed by a Pro?</strong> - Now that your professional detailer has restored your car to like new condition, learn how to keep
        it that way. Most swirls and scratches build-up over time from improper washing and drying techniques. Ask your detailer how to properly wash and dry to
        maintain your car’s exterior or ask them if they offer a maintenance program.
        <strong>Maintenance Program -</strong> If you like your car to always look like it was just detailed, then it is strongly recommend to ask your
        detailer if they offer a maintenance program. A maintenance program is the option to have your detailer wash and re-wax your vehicles on a
        regular basis to maintain both your investment and their appearance to show room new condition.
        <strong>The paint on your car is thin! -</strong> Chances are you’re driving a new or newer car with a factory clearcoat finish for a paint job.
        The factory clearcoat finish on modern cars is THIN. How thin? In most cases thinner than a Post-It Note. The factory sprayed clear layer of paint
        on most new cars averages around 2 mils. That’s thinner than the average post-it note.
        <strong>Why is this important? -</strong> Because if the detailer you hire uses inexpensive compounds and polishes or simply scratches your car in
        the way they wash it and dry off the water, this can ruin your car’s paint job or lead to what’s called, clearcoat failure. That’s where a car
        looks like it has a bad rash because the clear layer of paint is flaking off. Here’s the deal – clearcoat failure CANNOT be fixed. The only honest
        fix is to repaint the affected panel or repaint the entire car.
        <strong>Clearcoats are scratch sensitive -</strong> Clearcoat finishes are also easily scratched; this is called scratch-sensitive. What this
        means is although clearcoats tend to be harder than the old school lacquers and enamels used before 1980, they still scratch easily and the
        scratches or swirls are unsightly and cause your car’s paint to deteriorate faster than it would without them.
        <strong>Deeper defects -</strong> Deeper below surface paint defects, like key scratches and severe Type II Water Spots may be too deep to safely
        remove. For most cars and most people, it is better to learn to trust your detailer to make the judgment call as to which defects to let remain
        versus trying to remove 100%. Often times a thorough compounding and polishing using premium quality products will reduce the visibility of deeper
        defects to the point that they are a lot less visible. This is the preferred approach for any vehicle that is used as a daily driver.
        There’s a lot more to know about car detailing than simply having a wash bucket, a wash mitt and some car wax. Read through this packet of information and discuss with the detailer that gave you this information what package he recommends for your car and why.
        Glossary of Terms used in the Detailing Industry
        <strong>Car Wash -</strong> Generic term for removing loose dirt before any other exterior process is performed. This can include a normal car
        wash, rinse less wash, waterless wash or the use of a spray detailer.
        <strong>Mechanical Decontamination -</strong> To remove above surface bonded contaminants like air-borne pollution, tree sap, overspray paint
        or industrial fallout through a mechanical means such as detailing clay.
        <strong>Chemical Decontamination -</strong> Chemical decontamination is an advanced procedure where specific chemicals are used to remove either acidic or alkaline contaminants off the surface or metal particles off and out of paint.
        1-Step Cleaner/Wax - A cleaner/wax is a product that does three steps in one step. This includes cleaning, polishing and leaving behind a layer of protection. A quality brand cleaner/wax professionally applied will do a good job of restoring a clear, shiny finish but these types of products will NOT normally remove all the swirls and scratches. It will remove some of the shallow swirls and scratches and leave the remaining swirls and scratches shiny.
        2-Step Polish & Wax - A two-step polish and wax is a more advanced procedure that will remove a majority of the shallow paint defects like swirls,
    </div>
</div>

</body>
</html>
