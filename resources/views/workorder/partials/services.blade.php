<div class="col-xl-12">
    <h2>Add on Services</h2>
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
                            <li>
                                <div class="col-xl-2 text-center">
                                    <div class="form-check form-check-muted m-0">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-10">
                                   @if($s->service->id == 39) {{$s->description}}   @else {{$s->service->description ?? 'Unknown Service'}} @endif
                                </div>

                            </li>
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
