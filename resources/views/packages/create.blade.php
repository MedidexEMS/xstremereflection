@extends('layouts.default')

@section('page-title', __('New Package'))
@section('page-heading', __('New Packages'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Package')
    </li>
@stop

@section('content')
    @include('partials.messages')



@stop

@section('scripts')

@stop
