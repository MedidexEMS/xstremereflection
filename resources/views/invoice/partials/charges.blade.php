

<div class="row m-2">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body py-0 px-0 px-sm-3">
               <div class="row">
                   <div class="col-xl-4 col-xl--12 text-center">
                       <a href=";javascript" data-toggle="modal" data-target="#packageModal"><img src="{{ url('assets/img/service.png') }}" height="50" width="50"></a> <br>
                       Add Package
                   </div>
                   <div class="col-xl-4 col-xl--12 text-center">
                       <a href=";javascript" data-toggle="modal" data-target="#serviceModal"><img src="{{ url('assets/img/service2.png') }}" height="50" width="50"></a> <br>
                       Add Service
                   </div>
                   <div class="col-xl-4 col-xl--12 text-center">
                       <a href=";javascript" data-toggle="modal" data-target="#productModal"><img src="{{ url('assets/img/addProduct.png') }}" height="50" width="50"></a> <br>
                       Add Product
                   </div>
               </div>
            </div>
        </div>
    </div>
</div>

<div class="row ">
    <div class="col-xl-6 col-xl--12">
        <h2>Packages</h2>
        <div class="card">
            <div class="card-body py-0 px-0 px-sm-3">
                    <div class="list-wrapper">
                        <ul class="d-flex flex-column text-white todo-list todo-list-custom">
                            @if($estimate->packages)
                                <li>
                                    <div class="col-xl-2 text-center">
                                        Qty
                                    </div>
                                    <div class="col-xl-4 text-center">
                                        Package Name
                                    </div>
                                    <div class="col-xl-3 text-center">
                                        Discount
                                    </div>
                                    <div class="col-xl-3 text-center">
                                        Cost
                                    </div>
                                </li>
                                @foreach($estimate->packages as $packages)
                                    <li>
                                        <div class="col-xl-2 text-center">
                                            {{$packages->quanity ?? '?'}}
                                        </div>
                                        <div class="col-xl-4 text-center">
                                            {{$packages->package->description ?? 'Unknown Package'}}
                                        </div>
                                        <div class="col-xl-3 text-center">
                                            @if($packages->discountType == 2) $ @endif  {{$packages->discount ?? '0'}} @if($packages->discountType == 1) % @endif
                                        </div>
                                        <div class="col-xl-3 text-center">
                                            List Price: <br>
                                            $ {{$packages->listPrice ?? ''}} <br>
                                            Total: $ {{$packages->chargedPrice ?? ''}}
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <div class="col-xl-2 text-center">
                                        No packages added to estimate
                                    </div>

                                </li>
                            @endif
                        </ul>
                    </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-xl--12">
        <div class="row">
            <div class="col-xl-12">
                <h2>Add on Services</h2>
                <div class="card">
                    <div class="card-body py-0 px-0 px-sm-3">
                        <div class="list-wrapper">
                            <ul class="d-flex flex-column text-white todo-list todo-list-custom">
                                <li>
                                    <div class="col-xl-2 text-center">
                                        Qty
                                    </div>
                                    <div class="col-xl-4 text-center">
                                        Service Added
                                    </div>
                                    <div class="col-xl-3 text-center">
                                        Discount
                                    </div>
                                    <div class="col-xl-3 text-center">
                                        Cost
                                    </div>
                                </li>
                                <li>
                                    <div class="col-xl-2 text-center">
                                        1
                                    </div>
                                    <div class="col-xl-4 text-center">
                                        Bronze Package
                                    </div>
                                    <div class="col-xl-3 text-center">
                                        50%
                                    </div>
                                    <div class="col-xl-3 text-center">
                                        List Price: $159.99 <br>
                                        Total: $100.00
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-xl-12">
                <h2>Add on Products</h2>
                <div class="card">
                    <div class="card-body py-0 px-0 px-sm-3">
                        <div class="list-wrapper">
                            <ul class="d-flex flex-column text-white todo-list todo-list-custom">
                                <li>
                                    <div class="col-xl-2 text-center">
                                        Qty
                                    </div>
                                    <div class="col-xl-4 text-center">
                                        Product Added
                                    </div>
                                    <div class="col-xl-3 text-center">
                                        Discount
                                    </div>
                                    <div class="col-xl-3 text-center">
                                        Cost
                                    </div>
                                </li>
                                <li>
                                    <div class="col-xl-2 text-center">
                                        1
                                    </div>
                                    <div class="col-xl-4 text-center">
                                        Bronze Package
                                    </div>
                                    <div class="col-xl-3 text-center">
                                        50%
                                    </div>
                                    <div class="col-xl-3 text-center">
                                        List Price: $159.99 <br>
                                        Total: $100.00
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

</div>
