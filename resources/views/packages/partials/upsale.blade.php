<div class="card-body">
    <h5 class="card-title">Upsale Recommendations</h5>
    <ul class="list-group">
        @if($upsale)
            @foreach($upsale as $row)
                <li class="list-group-item">{{$row->description}} Package</li>
            @endforeach
        @else
            <li class="list-group-item">No Included Upsale Services</li>
        @endif

    </ul>
</div>
