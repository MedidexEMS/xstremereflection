@extends('layouts.default')

@section('page-title', __('New Invoice'))
@section('page-heading', __('New Invoice'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Invoice')
    </li>
@stop

@section('content')
    @include('partials.messages')
    @if($estimate->status != 4)
    <div class="row mb-4">
        <div class="col">
            <button type="button"  class="btn btn-primary" style="width: 100%">Send for Approval</button>
        </div>
        <div class="col">
            <a href="/estimate/workOrder/{{$estimate->id}}" ><button type="button" class="btn btn-primary" style="width: 100%">Convert to Work Order</button></a>
        </div>
        <div class="col">
            <button type="button"  class="btn btn-danger" style="width: 100%">Void</button>
        </div>
    </div>
    @else
        <div class="row mb-4 text-center">
            <h2>Estimate has been approved and scheduled for service.</h2>
        </div>
    @endif
    <div class="row">
        <div class="col-xl-6 col-sm--12 grid-margin stretch-card">
            @include('estimate.partials.customer')
        </div>
        <div class="col-xl-6 col-sm--12 grid-margin stretch-card">
            @include('estimate.partials.serviceInfo')
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            @include('estimate.partials.charges')
        </div>
    </div>

    <!-- begin theme-panel -->
    <div class="theme-panel active">
        <a   class="theme-collapse-btn"> <span class="text-primary"><i class="fas fa-money-bill-alt "></i> </span> </a>
        <div class="theme-panel-content">
            <ul class="theme-list clearfix">
                <li class="active text-danger"> <span class="display-4" id="subTotal">$ {{ number_format($estimateTotal, 2, '.', '') ?? '0.00'}} </span>&nbsp;</li>

            </ul>
        </div>
    </div>


@stop

@include('invoice.partials.itemModal')
@include('invoice.partials.vehicleModal')


@section('scripts')

    <script>
        function listPriceUpdate() {
            var id = document.getElementById("packageId").value;

            $.get("/packageData/"+ id, function(data){
                var package = JSON.parse(data);

                document.getElementById('listPrice').innerHTML = package.cost;


            });
        }

        function discountUpdate() {
            var discount = document.getElementById("discount").value;
            var discountType = document.getElementById("discount").value;

            if(discountType = 1){
                var discountTotal = discount / 100;

                var newPrice = listPriceUpdate.cost - discountTotal;

                document.getElementById('packageTotals').innerHTML = newPrice;
            }else if(discountType = 2){

            }
        }
        $('#vehicleModal').on('show.bs.modal', function (){

            $( "#newVehicleForm" ).hide();
        });

        function vehicleUpdate(){
            var vehicleId = document.getElementById("vehicleId").value;

            if(vehicleId == 0){

                $( "#newVehicleForm" ).show();
                $( "#addCustomerVehicle").hide();
            }
            else {
                console.log('Existing Customer')
                $( "#newVehicleForm" ).hide();
                $( "#addCustomerVehicle").show();
            }

        }

        function vinUpdate (){
            var vin = document.getElementById("vin").value;

            $.ajax({

                type:'GET',

                url:'/vin-api/'+ vin,

                success:function(data){
                    var vehicle = JSON.parse(data);
                    $('#make').attr('value', vehicle.specification.make);
                    $('#model').attr('value', vehicle.specification.model);
                    $('#trim').attr('value', vehicle.specification.trim_level);
                    $('#style').attr('value', vehicle.specification.style);
                    $('#year').attr('value', vehicle.specification.year);

                    var width = vehicle;

                    console.log(width.replace(/[^0-9\.]+/g,""));

                }

            });
        }
    </script>




@stop
