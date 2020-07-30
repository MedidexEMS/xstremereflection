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

    <div class="row">
        <div class="col-xl-12">
            @include('workorder.partials.statusButtons')
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


@section('scripts')

@stop
