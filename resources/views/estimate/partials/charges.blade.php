
@if($estimate->status != 4)
<div class="row m-2">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body py-0 px-0 px-sm-3">
               <div class="row">
                   <div class="col-xl-12 text-center">
                       <a href=";javascript" data-toggle="modal" data-target="#packageModal"><img src="{{ url('assets/img/service.png') }}" height="50" width="50"></a> <br>
                       Add Package
                   </div>

               </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row ">
    <div class="col-xl-12 col-xl--12">
        <h2>Packages</h2>
        <div class="card">
            <div class="card-body py-0 px-0 px-sm-3">
                    <div class="list-wrapper">
                        <ul class="d-flex flex-column text-white todo-list todo-list-custom">
                            @if($estimate->packages)
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Select PKG</th>
                                        <th>Package Description</th>
                                        <th>List Price</th>
                                        <th>Charged Price</th>
                                        <th>Deposit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($estimate->packages as $packages)
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="package" id="package{{$packages->ic}}" value="{{$packages->id}}" onchange="selectedPackage()" @if($estimate->approvedPackage == $packages->id) checked="checked" @endif>

                                                    </label>
                                                </div>
                                            </td>
                                            <td width="50%">
                                                {{$packages->package->description ?? 'Unknown Package'}} <br />
                                                @if($packages->addOnService)
                                                    <table class="table table-sm">
                                                        <tr>
                                                            <th><h6>Add on Services</h6></th>
                                                        </tr>
                                                        @foreach($packages->addOnService as $aos)
                                                            <tr>
                                                                <td>
                                                                    @if($aos->serviceId == 0) {{$aos->description ?? ''}}  @else {{$aos->service->description  }} @endif - <small>List Price: ${{$aos->service->charge ?? '0.00'}}  Charged: {{$aos->price ?? '0.00'}} </small>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                @endif

                                            </td>
                                            <td>
                                                $ {{$packages->listPrice ?? ''}}
                                            </td>
                                            <td>
                                                $ {{$packages->chargedPrice ?? ''}}
                                            </td>
                                            <td>
                                                $ {{$packages->deposit ?? ''}}
                                            </td>
                                            <td>
                                                @if($estimate->status != 4)  <a href="/removePackage/{{$packages->id}}"><span class="text-danger"><i class="fad fa-eraser"></i></span></a> @endif

                                                <a data-toggle="modal" data-link="/modal/packageServices/{{$packages->id}}" data-target="#servicesModal"><i class="fas fa-binoculars ml-3"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <table class="table table">
                                                <tr>
                                                    <th>Price</th>
                                                    <th>Product</th>
                                                    <th>Labor</th>
                                                    <th>Labor %</th>
                                                    <th>Acquisition</th>
                                                    <th>Gross Profit</th>
                                                    <th>Margin</th>
                                                    <th>Markup</th>
                                                </tr>
                                                <?php
                                                $price = $packages->chargedPrice;
                                                $laborPrice = $packages->package->laborCost;
                                                $productPrice = $packages->package->productCost;
                                                $acquisitionPrice = $packages->package->acquisitionCost;
                                                $laborMargin =  $laborPrice / $price * 100;
                                                if($estimate->detailType == 2){
                                                    $costs =$laborPrice + $productPrice + $acquisitionPrice + 25 ;
                                                    $gross = $price - $laborPrice - $productPrice - $acquisitionPrice - 25;
                                                }else{
                                                    $costs =$laborPrice + $productPrice + $acquisitionPrice ;
                                                    $gross = $price - $laborPrice - $productPrice - $acquisitionPrice;
                                                }
                                                $profit = $gross / $price * 100;
                                                $badProfit = 66 - $profit;
                                                $markup = $price - $gross / $costs
                                                ?>
                                                <tr class="bg-primary text-white">
                                                    <td>$ {{$price}}</td>
                                                    <td>$ {{$productPrice}}</td>
                                                    <td>$ {{$laborPrice}}</td>
                                                    <td>{{ceil($laborMargin)}} %</td>
                                                    <td>$ {{$acquisitionPrice}}</td>
                                                    <td>$ {{number_format($gross, 2)}}</td>
                                                    <td>{{number_format($profit)}} %
                                                    @if($profit < 66) <span class="text-danger"> ( {{number_format($badProfit)}} ) %</span> @endif
                                                    </td>
                                                    <td> {{round($markup)}} %</td>
                                                </tr>
                                                <?php
                                                $array = explode(',', $packages->package->upsale);
                                                $upsale = \Vanguard\Services::whereIn('id', $array)->get();
                                                ?>

                                                @if($upsale)
                                                    @foreach($upsale as $row)
                                                        <?php
                                                        $rowPrice = $price + $row->charge;
                                                        $rowProductPrice = $productPrice + $row->productPrice;
                                                        $rowLaborPrice = $laborPrice + $row->laborCost;

                                                        $rowLaborMargin =  $rowLaborPrice / $rowPrice * 100;
                                                        $rowCosts =$rowLaborPrice + $rowProductPrice;
                                                        $rowGross = $rowPrice - $rowLaborPrice - $rowProductPrice;
                                                        $rowProfit = $rowGross / $rowPrice * 100;
                                                        $rowBadProfit = 66 - $rowProfit;
                                                        $rowMarkup = $rowPrice - $rowGross / $rowCosts
                                                        ?>
                                                    <tr>
                                                        <td colspan="7" class="text-center">{{$row->description}} - {{$row->charge}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>$ {{$rowPrice}}</td>
                                                        <td>$ {{$rowProductPrice}}</td>
                                                        <td>$ {{$rowLaborPrice}}</td>
                                                        <td>{{ceil($rowLaborMargin)}} %</td>
                                                        <td>$ 0.00</td>
                                                        <td>$ {{number_format($rowGross, 2)}}</td>
                                                        <td>{{number_format($rowProfit)}} %
                                                            @if($rowProfit < 66) <span class="text-danger"> ( {{number_format($rowBadProfit)}} ) %</span> @endif
                                                        </td>
                                                        <td> {{round($rowMarkup)}} %</td>
                                                    </tr>

                                                    @endforeach

                                                @endif

                                            </table>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
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
<!--
    <div class="col-xl-6 col-xl--12">
        <div class="row">
            <div class="col-xl-12">
                <h2>Add on Services</h2>
                <div class="card">
                    <div class="card-body py-0 px-0 px-sm-3">
                        <div class="list-wrapper">
                            <ul class="d-flex flex-column text-white todo-list todo-list-custom">

                                <li>
                                    <div class="col-xl-1 text-center">
                                        Qty
                                    </div>
                                    <div class="col-xl-4 text-center">
                                        Service Added
                                    </div>
                                    <div class="col-xl-2 text-center">
                                        Discount
                                    </div>
                                    <div class="col-xl-3 text-center">
                                        Cost
                                    </div>
                                    <div class="col-xl-2">
                                        Actions
                                    </div>
                                </li>
                                @if($estimate->services)
                                @foreach($estimate->services as $service)
                                <li>
                                    <div class="col-xl-1 text-center">
                                        {{$service->quanity ?? 'Unk'}}
                                    </div>
                                    <div class="col-xl-4 text-center">
                                        {{$service->service->description}}
                                    </div>
                                    <div class="col-xl-2 text-center">
                                        {{$service->discount ?? '0'}}
                                    </div>
                                    <div class="col-xl-3 text-center">
                                        List Price: ${{$service->listPrice}} <br>
                                        Total: ${{$service->chargedPrice}}
                                    </div>
                                    <div class="col-xl-2">
                                        @if($estimate->status != 4)<a href="/removeService/{{$service->id}}"><span class="text-danger"><i class="fad fa-eraser"></i></span></a>@endif
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

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
-->
</div>
