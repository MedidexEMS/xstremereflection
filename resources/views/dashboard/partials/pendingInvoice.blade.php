<div class="col-xl-4 col-sm-12">
    <h2>Pending Payment</h2>
    <div class="card">
        <div class="card-body py-0 px-0 px-sm-3">

            <div class="list-group">
                @foreach($invoices as $row)
                    <a href="/workorder/{{$row->invoice->id}}/show" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{$row->firstName ?? 'Missing Customer Info'}} {{$row->lastName ?? 'Missing Customer Info'}} - {{$row->phoneNumber ?? 'Missing Contact Info'}}</h5>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{\Carbon\Carbon::parse($row->invoice->dateofService)->format('m-d-Y')}}</h5>
                        </div>
                        <small>Invoice Total: ${{$row->invoice->total}}</small>
                    </a>
                    <hr>
                @endforeach

            </div>
        </div>
    </div>
</div>

