@extends('layouts.default')

@section('page-title', __('Packages'))
@section('page-heading', __('My Packages'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Dashboard')
</li>
@stop

@section('content')
@include('partials.messages')

<div class="row mb-4">
    <div class="col-xl-4">
        <a href="/packages/create"><button class="btn btn-primary btn-block">Create New Package</button></a>
    </div>
</div>
<div class="row">
    @include('packages.partials.package')
</div>

@stop

@section('scripts')

@stop
