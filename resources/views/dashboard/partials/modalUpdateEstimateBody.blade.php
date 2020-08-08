<div class="row">
    @if($estimate->customer->email)
        <a type="button" class="btn btn-primary btn-lg btn-block mb-3">Send Reminder Email</a>
    @endif
    <a class="btn btn-danger btn-lg btn-block mb-3" href="/estimate/cancel/{{$estimate->id}}">Canceled By Customer</a>
    <a type="button" class="btn btn-success btn-lg btn-block mb-3">Enter New Date</a>
</div>

<form id="newDateForm">

</form>
