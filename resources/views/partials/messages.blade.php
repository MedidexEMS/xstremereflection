@if(isset ($errors) && count($errors) > 0)
    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
        <!-- Position it -->
        <div style="position: absolute; top: 0; right: 0;">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="15000">
                <div class="toast-header">
                    <img src="{{url('/assets/img/bluesquare.png')}}" class="rounded bg-danger mr-2" alt="..." width="15px" height="15px">
                    <strong class="mr-auto">Error Reported</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
            <!-- Position it -->
            <div style="position: absolute; top: 0; right: 0;">
                @foreach ($data as $msg)
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="15000">
                        <div class="toast-header">
                            <img src="{{url('/assets/img/bluesquare.png')}}" class="rounded mr-2" alt="..." width="15px" height="15px">
                            <strong class="mr-auto">Action Completed</strong>
                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="toast-body">
                            {{ $msg }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
            <!-- Position it -->
            <div style="position: absolute; top: 0; right: 0;">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="15000">
                    <div class="toast-header">
                        <img src="{{url('/assets/img/bluesquare.png')}}" class="rounded mr-2" alt="..." width="15px" height="15px">
                        <strong class="mr-auto">Action Completed</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        {{ $data }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
