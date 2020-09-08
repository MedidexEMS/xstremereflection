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
    <div class="title m-b-md">Payment Information</div>

    <div class="links">
        <form action="/api/payment" method="POST">
            <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="pk_test_51HPAurAzOqvz8nyKljc9bcWzTA8GYcj35Qv1307AJtsI5xwBHgoMywiYpqtIl9KpPuMY1U4LnNX1vUjAhXuNUxu900bGay9YuX"
                data-amount="{{$invoice->deposit}}"
                data-name="{{$invoice->estimate->customer->firstName}} {{$invoice->estimate->customer->lastName}}"
                data-description="Deposit Funds"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-currency="usd"></script>

        </form>
    </div>
</div>

@stop

@section('scripts')


@stop
