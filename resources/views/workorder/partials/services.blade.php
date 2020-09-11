<div class="col-xl-4">
    <h2>Interior Services</h2>
    <div class="card">
        <div class="card-body py-0 px-0 px-sm-3">
            <div class="list-wrapper">
                <ul class="d-flex flex-column text-white todo-list todo-list-custom">

                    <li>
                        <div class="col-xl-2 text-center">

                        </div>
                        <div class="col-xl-10 text-center">
                            Service To Be Completed
                        </div>

                    </li>
                    @if($workOrder->services)
                        @foreach($workOrder->services as $s)
                            @if($s->service->serviceTypeId == 1)
                            <li>
                                <div class="col-xl-2 text-center">
                                    <div class="form-check form-check-muted m-0">
                                        <label class="form-check-label">

                                            <input type="checkbox" name="service" value="{{$s->id}}" class="form-check-input" data-id="{{$s->id}}"  @if($s->status == 2) checked @endif>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-10">
                                   @if($s->service->id == 39) {{$s->description}}   @else {{$s->status}} {{$s->service->description ?? 'Unknown Service'}} @endif
                                </div>

                            </li>

                            @endif
                        @endforeach

                    @else
                        <li>
                            <div class="col-xl-2 text-center">
                                No services added to estimate
                            </div>

                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4">
    <h2>Exterior Services</h2>
    <div class="card">
        <div class="card-body py-0 px-0 px-sm-3">
            <div class="list-wrapper">
                <ul class="d-flex flex-column text-white todo-list todo-list-custom">

                    <li>
                        <div class="col-xl-2 text-center">

                        </div>
                        <div class="col-xl-10 text-center">
                            Service To Be Completed
                        </div>

                    </li>
                    @if($workOrder->services)
                        @foreach($workOrder->services as $s)
                            @if($s->service->serviceTypeId == 2)
                                <li>
                                    <div class="col-xl-2 text-center">
                                        <div class="form-check form-check-muted m-0">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="service" value="{{$s->id}}" class="form-check-input" data-id="{{$s->id}} @if($s->status == 2) checked @endif onchange="serviceComplete()">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xl-10">
                                        @if($s->service->id == 39) {{$s->description}}   @else {{$s->service->description ?? 'Unknown Service'}} @endif
                                    </div>

                                </li>

                            @endif
                        @endforeach

                    @else
                        <li>
                            <div class="col-xl-2 text-center">
                                No services added to estimate
                            </div>

                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4">
    <h2>Other Services</h2>
    <div class="card">
        <div class="card-body py-0 px-0 px-sm-3">
            <div class="list-wrapper">
                <ul class="d-flex flex-column text-white todo-list todo-list-custom">

                    <li>
                        <div class="col-xl-2 text-center">

                        </div>
                        <div class="col-xl-10 text-center">
                            Service To Be Completed
                        </div>

                    </li>
                    @if($workOrder->services)
                        @foreach($workOrder->services as $s)
                            @if($s->service->serviceTypeId == 0)
                                <li>
                                    <div class="col-xl-2 text-center">
                                        <div class="form-check form-check-muted m-0">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="service" value="{{$s->id}}" class="form-check-input" data-id="{{$s->id}} @if($s->status == 2) checked @endif onchange="serviceComplete()">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xl-10">
                                        @if($s->service->id == 39) {{$s->description}}   @else {{$s->service->description ?? 'Unknown Service'}} @endif
                                    </div>

                                </li>

                            @endif
                        @endforeach

                    @else
                        <li>
                            <div class="col-xl-2 text-center">
                                No Other Services Added to Workorder
                            </div>

                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
