@extends('layouts.dashboard')

@section('page-title', __('Dashboard'))
@section('page-heading', __('Dashboard'))

@section('styles')

@stop


@section('content')
    @include('partials.messages')

    <div class="page-inner mt--5">
        @include('dashboard.partials.overallStats')
            <div class="col-md-6">
                <div class="card full-height">
                    <div class="card-body">
                        <div class="card-title">Total income & spend statistics</div>
                        <div class="row py-3">
                            <div class="col-md-4 d-flex flex-column justify-content-around">
                                <div>
                                    <h6 class="fw-bold text-uppercase text-success op-8">Total Income</h6>
                                    <h3 class="fw-bold">${{number_format($invoiceTotal)}}</h3>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-uppercase text-danger op-8">Total Outstanding</h6>
                                    <h3 class="fw-bold">${{number_format($invoiceOutstanding)}}</h3>
                                </div>
                            </div>
                            <div class="col-md-8" >
                                <div id="chart-container">
                                    <div class="pull-in">
                                       <div id="chart" style="height: 200px;"> {!! $chart->container() !!} </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @include('dashboard.partials.estimateHistory')
            @include('dashboard.partials.estimates')
        </div>

@stop

@section('modals')
    @include('dashboard.partials.modalUpdateEstimate')
@stop

@section('scripts')
    <script>
        Circles.create({
            id:'circles-1',
            radius:45,
            value:{{$leads}},
            maxValue:10,
            width:7,
            text: {{$leads}},
            colors:['#f1f1f1', '#000034'],
            duration:400,
            wrpClass:'circles-wrp',
            textClass:'circles-text',
            styleWrapper:true,
            styleText:true
        })

        Circles.create({
            id:'circles-2',
            radius:45,
            value:{{$estimate ?? 0}},
            maxValue:10,
            width:7,
            text: {{$estimate ?? 0}},
            colors:['#f1f1f1', '#2BB930'],
            duration:400,
            wrpClass:'circles-wrp',
            textClass:'circles-text',
            styleWrapper:true,
            styleText:true
        })

        Circles.create({
            id:'circles-3',
            radius:45,
            value:{{$workorder ?? 0}},
            maxValue:5,
            width:7,
            text: {{$workorder ?? 0}},
            colors:['#f1f1f1', '#ff6700'],
            duration:400,
            wrpClass:'circles-wrp',
            textClass:'circles-text',
            styleWrapper:true,
            styleText:true
        })

        Circles.create({
            id:'circles-4',
            radius:45,
            value:{{$unpaidInvoices ?? 0}},
            maxValue:5,
            width:7,
            text: {{$unpaidInvoices ?? 0}},
            colors:['#f1f1f1', '#F25961'],
            duration:400,
            wrpClass:'circles-wrp',
            textClass:'circles-text',
            styleWrapper:true,
            styleText:true
        })



        $('#lineChart').sparkline([105,103,123,100,95,105,115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#ffa534',
            fillColor: 'rgba(255, 165, 52, .14)'
        });

        //Notify
        $.notify({
            icon: 'flaticon-alarm-1',
            title: 'Indexial',
            message: 'Bootstrap 4 Admin Template',
        },{
            type: 'secondary',
            placement: {
                from: "bottom",
                align: "right"
            },
            time: 1000,
        });
    </script>

    <script>
        $("#updateEstimateModal").on("shown.bs.modal", function(e) {
            var link = $(e.relatedTarget).data("link");

            // AJAX request
            $.ajax({
                url: link,
                type: 'get',
                success: function(response){
                    // Add response in Modal body
                    $('#updateEstimateModal .modal-body').html(response);

                    $('#datepicker-popup-1').datepicker({
                        todayHighlight: true,
                    });

                    $( "#newDateForm" ).hide();

                    function showForm() {

                        $( "#newDateForm" ).show();
                    }
                }
            });
        });

        function showForm() {

            $( "#newDateForm" ).show();
        }

    </script>

    {!! $chart->script() !!}
@stop
