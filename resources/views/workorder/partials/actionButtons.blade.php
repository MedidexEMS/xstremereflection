<div class="row mb-2">
    <a href="/workorder/addServices/{{$workOrder->id}}" class="btn btn-primary btn-block">Add Services From Package</a>
</div>

<div class="row mb-2">
    <a class="btn btn-warning btn-block" href="/estimate/{{$workOrder->estimate->id}}/pdf">PDF Estimate Customer Copy</a>
</div>

<div class="row mb-2">
    <a class="btn btn-warning btn-block" href="/upsale/{{$workOrder->estimate->id}}/pdf">PDF Upsale Detailer Copy</a>
</div>
