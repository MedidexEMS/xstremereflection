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
                            <div class="col-md-8">
                                <div id="chart-container">
                                    <canvas id="totalIncomeChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card full-height">
                    <div class="card-header">
                        <div class="card-title">Lead / Estimate History</div>
                    </div>
                    <div class="card-body">
                        <ol class="activity-feed">
                            <li class="feed-item feed-item-secondary">
                                <time class="date" datetime="9-25">Sep 25</time>
                                <span class="text">Responded to need <a href="#">"Volunteer opportunity"</a></span>
                            </li>
                            <li class="feed-item feed-item-success">
                                <time class="date" datetime="9-24">Sep 24</time>
                                <span class="text">Added an interest <a href="#">"Volunteer Activities"</a></span>
                            </li>
                            <li class="feed-item feed-item-info">
                                <time class="date" datetime="9-23">Sep 23</time>
                                <span class="text">Joined the group <a href="single-group.html">"Boardsmanship Forum"</a></span>
                            </li>
                            <li class="feed-item feed-item-warning">
                                <time class="date" datetime="9-21">Sep 21</time>
                                <span class="text">Responded to need <a href="#">"In-Kind Opportunity"</a></span>
                            </li>
                            <li class="feed-item feed-item-danger">
                                <time class="date" datetime="9-18">Sep 18</time>
                                <span class="text">Created need <a href="#">"Volunteer Opportunity"</a></span>
                            </li>
                            <li class="feed-item">
                                <time class="date" datetime="9-17">Sep 17</time>
                                <span class="text">Attending the event <a href="single-event.html">"Some New Event"</a></span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card full-height">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Support Tickets</div>
                            <div class="card-tools">
                                <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-today" data-toggle="pill" href="#pills-today" role="tab" aria-selected="true">Today</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-week" data-toggle="pill" href="#pills-week" role="tab" aria-selected="false">Week</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-month" data-toggle="pill" href="#pills-month" role="tab" aria-selected="false">Month</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="avatar avatar-online">
                                <span class="avatar-title rounded-circle border border-white bg-info">J</span>
                            </div>
                            <div class="flex-1 ml-3 pt-1">
                                <h6 class="text-uppercase fw-bold mb-1">Joko Subianto <span class="text-warning pl-3">pending</span></h6>
                                <span class="text-muted">I am facing some trouble with my viewport. When i start my</span>
                            </div>
                            <div class="float-right pt-1">
                                <small class="text-muted">8:40 PM</small>
                            </div>
                        </div>
                        <div class="separator-dashed"></div>
                        <div class="d-flex">
                            <div class="avatar avatar-offline">
                                <span class="avatar-title rounded-circle border border-white bg-secondary">P</span>
                            </div>
                            <div class="flex-1 ml-3 pt-1">
                                <h6 class="text-uppercase fw-bold mb-1">Prabowo Widodo <span class="text-success pl-3">open</span></h6>
                                <span class="text-muted">I have some query regarding the license issue.</span>
                            </div>
                            <div class="float-right pt-1">
                                <small class="text-muted">1 Day Ago</small>
                            </div>
                        </div>
                        <div class="separator-dashed"></div>
                        <div class="d-flex">
                            <div class="avatar avatar-away">
                                <span class="avatar-title rounded-circle border border-white bg-danger">L</span>
                            </div>
                            <div class="flex-1 ml-3 pt-1">
                                <h6 class="text-uppercase fw-bold mb-1">Lee Chong Wei <span class="text-muted pl-3">closed</span></h6>
                                <span class="text-muted">Is there any update plan for RTL version near future?</span>
                            </div>
                            <div class="float-right pt-1">
                                <small class="text-muted">2 Days Ago</small>
                            </div>
                        </div>
                        <div class="separator-dashed"></div>
                        <div class="d-flex">
                            <div class="avatar avatar-offline">
                                <span class="avatar-title rounded-circle border border-white bg-secondary">P</span>
                            </div>
                            <div class="flex-1 ml-3 pt-1">
                                <h6 class="text-uppercase fw-bold mb-1">Peter Parker <span class="text-success pl-3">open</span></h6>
                                <span class="text-muted">I have some query regarding the license issue.</span>
                            </div>
                            <div class="float-right pt-1">
                                <small class="text-muted">2 Day Ago</small>
                            </div>
                        </div>
                        <div class="separator-dashed"></div>
                        <div class="d-flex">
                            <div class="avatar avatar-away">
                                <span class="avatar-title rounded-circle border border-white bg-danger">L</span>
                            </div>
                            <div class="flex-1 ml-3 pt-1">
                                <h6 class="text-uppercase fw-bold mb-1">Logan Paul <span class="text-muted pl-3">closed</span></h6>
                                <span class="text-muted">Is there any update plan for RTL version near future?</span>
                            </div>
                            <div class="float-right pt-1">
                                <small class="text-muted">2 Days Ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

        var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

        var mytotalIncomeChart = new Chart(totalIncomeChart, {
            type: 'bar',
            data: {
                labels: ["S", "M", "T", "W", "T", "F", "S", "S", "M", "T"],
                datasets : [{
                    label: "Total Income",
                    backgroundColor: '#ff9e27',
                    borderColor: 'rgb(23, 125, 255)',
                    data: [6, 4, 9, 5, 4, 6, 4, 3, 8, 10],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            display: false //this will remove only the label
                        },
                        gridLines : {
                            drawBorder: false,
                            display : false
                        }
                    }],
                    xAxes : [ {
                        gridLines : {
                            drawBorder: false,
                            display : false
                        }
                    }]
                },
            }
        });

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
@stop
