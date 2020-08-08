@extends('layouts.default')

@section('page-title', __('Dashboard'))
@section('page-heading', __('Dashboard'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Dashboard')
    </li>
@stop

@section('content')
    @include('partials.messages')

<div class="row">

    @role('Admin')
    @foreach (\Vanguard\Plugins\Vanguard::availableWidgets(auth()->user()) as $widget)
        @if ($widget->width)
            <div class="col-md-{{ $widget->width }}">
                @endif
                {!! app()->call([$widget, 'render']) !!}
                @if($widget->width)
            </div>
        @endif
    @endforeach
    @endrole

    @role('business_admin')
        @include('dashboard.businessAdminIndex')
    @endrole

</div>

    <div class="row">
        @include('dashboard.partials.rescheduleJobs')
        @include('dashboard.partials.workOrders')
        @include('dashboard.partials.pendingInvoice')
    </div>

@stop
@include('dashboard.partials.modalUpdateEstimate')
@section('scripts')
    @foreach (\Vanguard\Plugins\Vanguard::availableWidgets(auth()->user()) as $widget)
        @if (method_exists($widget, 'scripts'))
            {!! app()->call([$widget, 'scripts']) !!}
        @endif
    @endforeach

    <script>
        $("#updateEstimateModal").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget).data("link");

            // AJAX request
            $.ajax({
                url: link,
                type: 'get',
                success: function(response){
                    // Add response in Modal body
                    $('.modal-body').html(response);

                    // Display Modal
                    $('#empModal').modal('show');
                }
            });
        });

    </script>
@stop
