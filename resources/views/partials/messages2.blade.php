

@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))


        @foreach ($data as $msg)


            <script>

                    console.log( "ready!" );
                    //Notify
                    $.notify({
                        icon: 'flaticon-alarm-1',
                        title: 'Action Completed',
                        message: '{{ $msg }}',
                    },{
                        type: 'success',
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                        time: 5000,
                    });

            </script>
        @endforeach


    @else
        <script>
            $( document ).ready(function() {
                console.log( "ready!" );
                //Notify
                $.notify({
                    icon: 'flaticon-alarm-1',
                    title: 'Action Completed',
                    message: '{{ $data }}',
                },{
                    type: 'success',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    time: 5000,
                });
            });


        </script>
       @endif
@endif
