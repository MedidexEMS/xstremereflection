
    <div class="col-xl-4">
        <div class="card widget">
            <div class="card-body">
                <div class="row">
                    <div class="p-3 text-success flex-1">
                        <i class="fa fa-user-plus fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">Estimate Totals</h2>
                        <div class="text-muted">{{$estimates->sum('total')}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card widget">
            <div class="card-body">
                <div class="row">
                    <div class="p-3 text-success flex-1">
                        <i class="fa fa-user-plus fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">Work Orders Totals</h2>
                        <div class="text-muted">
                           {{$workorders->where('status', '!=', 9)->sum('totalCharge')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card widget">
            <div class="card-body">
                <div class="row">
                    <div class="p-3 text-success flex-1">
                        <i class="fa fa-user-plus fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">Work Orders Totals</h2>
                        <div class="text-muted">
                            {{$invoices->sum('totalCharge')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

