<div class="card-body">
    <h5 class="card-title">Included Packages</h5>
    <ul class="list-group">
        @if($packages)
        @foreach($packages as $row)
            <a href="/package/edit/{{$row->id}}"><li class="list-group-item">{{$row->description}} Package</li></a>
        @endforeach
        @else
            <li class="list-group-item">No Included Packages</li>
        @endif

    </ul>
</div>
