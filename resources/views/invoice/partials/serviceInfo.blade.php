<div class="card">
    <div class="card-body py-0 px-0 px-sm-3">

            @if($estimate->vehicle)
            <div class="row ">
                <div class="col-5 col-sm-7 col-xl-8 p-0">
                    <h4 class="mb-1 mb-sm-0">Customer Information</h4>
                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        Vehicle Year:
                    </p>
                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        Vehicle Make:
                    </p>
                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        Vehicle Model:
                    </p>
                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        Vehicle Color:
                    </p>
                </div>

                <div class="col-4 text-right">
                    <i class="fas fa-edit"></i>
                </div>
            </div>
            @else
                <div class="row">
                    <h4 class="mb-1 mb-sm-0">Customer Information</h4>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="button"  class="btn btn-primary" style="width: 100%" data-toggle="modal" data-target="#vehicleModal">Add New Vehicle</button>
                    </div>
                </div>

            @endif



    </div>
</div>
