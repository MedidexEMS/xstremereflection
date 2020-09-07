@extends('layouts.default')

@section('page-title', __($workOrder->estimate->customer->lastName .' Work Order'))
@section('page-heading', __($workOrder->estimate->customer->lastName .' Work Order'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Invoice')
    </li>
@stop

@section('content')
    @include('partials.messages')
    <div class="row mb-3">
        @include('workorder.partials.jobStats')
    </div>
    <div class="row">
        <div class="col-xl-12">
            @include('workorder.partials.statusButtons')
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <a href="/workorder/completed/{{$workOrder->id}}" class="btn btn-success btn-block">Complete Work Order</a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-sm--12 grid-margin stretch-card">
            @include('workorder.partials.customer')
        </div>
        <div class="col-xl-6 col-sm--12 grid-margin stretch-card">
            @include('workorder.partials.serviceInfo')
        </div>
    </div>

    <div class="row">
        @include('workorder.partials.services')
    </div>

@stop
@include('workorder.partials.modalVehicleUpdate')

@section('scripts')
<script>
    function vinUpdate () {
        var vin = document.getElementById("vin").value;

        $.ajax({

            type: 'GET',

            url: '/vin-api/' + vin,

            success: function (data) {
                var vehicle = JSON.parse(data);
                $('#make').attr('value', vehicle.specification.make);
                $('#model').attr('value', vehicle.specification.model);
                $('#trim').attr('value', vehicle.specification.trim_level);
                $('#style').attr('value', vehicle.specification.style);
                $('#year').attr('value', vehicle.specification.year);

                var width = vehicle;

                console.log(width.replace(/[^0-9\.]+/g, ""));

            }

        });
    }
</script>
@stop
