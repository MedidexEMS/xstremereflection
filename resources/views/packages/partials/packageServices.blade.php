<div class="card-body">
    <h5 class="card-title">Package Services</h5>
    <ul class="list-group">
        @foreach($packageServices as $row)
            <li class="list-group-item">{{$row->desc->description}}</li>
        @endforeach

    </ul>
</div>
