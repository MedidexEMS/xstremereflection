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
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">Payment Information</div>
            <div class="card-body">
                <p>{{$invoice->estimate->customer->firstName}} {{$invoice->estimate->customer->lastName}} Thank You for accepting your package, the package you choose has a deposit. Lets go head and take care of that now if you have the time.</p>
                <p>Total Invoice: ${{$invoice->total}}</p>
                <p>Total Deposit Due Today: ${{$invoice->deposit}}</p>
            </div>

            <div class="card-footer">
                <div class="links">
                    <form action="/api/payment" method="POST">
                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{env('stripeTestDataKey')}}"
                            data-amount="{{$amount}}"
                            data-name="{{$invoice->estimate->customer->firstName}} {{$invoice->estimate->customer->lastName}}"
                            data-description="Deposit Funds"
                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                            data-currency="usd"></script>

                    </form>
                </div>
            </div>
        </div>

    </div>



</div>

@stop

@section('scripts')


@stop
