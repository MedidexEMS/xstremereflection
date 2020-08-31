@extends('layouts.loggedOut')

@section('page-title', __('Customer Estimate'))
@section('page-heading', __('Customer Estimate'))

@section('styles')

@stop

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Invoice')
    </li>
@stop

@section('content')
    @include('partials.messages')

    <div class="row">
        <div class="col-xl-12 text-center">
            <img src="/assets/img/logo1.png" alt="logo"  height="125px" width="300px"/>
        </div>
    </div>

    <div class="row p-10 mb-3">
        <div class="col-xl-12">
            John Doe I would like to thank you for contacting Xtreme Reflection for the perfection of your _________________.
            We have slated our schedule for ________________________ and plan to give your vehicle the care you expect.
            Please review the packages below and select the package that best fits your needs.
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
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($estimate->packages as $packages)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td style="width: 50px">
                            <h6>{{$packages->package->description}}</h6>
                            <div class="col-xl-12">

                                <div class="row">
                                    <div class="col-xl-10">

                                    </div>
                                </div>
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
                            </div>
                        </td>
                        <td>${{$packages->listPrice ?? ''}}</td>
                        <td>${{$packages->chargedPrice ?? ''}}</td>
                        <td>${{$packages->deposit ?? ''}}</td>
                        <td><a href="/customerSignatureBody/{{$packages->id}}"><button class="btn btn-success btn-block">Approve Package # {{$loop->iteration}}</button></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

    </div>

    @include('estimate.partials.modalCustomerSignature')

@stop

@section('scripts')

    <script>
        $("#customerSignatureModal").on("show.bs.modal", function(e) {
            // AJAX request
            $.ajax({
                url: '/estimate/customerSignatureBody',
                type: 'get',
                success: function(response){
                    // Add response in Modal body
                    $('#customerApproval').html(response);


                }
            });
        });
    </script>
@stop
