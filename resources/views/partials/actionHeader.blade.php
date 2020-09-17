

        <div class="panel-header bg-primary-gradient mb-4">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">@yield('page-title')</h2>
                        <h3 class="text-white pb-2 fw-bold"> @yield('customer-info') </h3>
                        <h4 class="text-white pb-2 fw-bold"> @yield('estimate-number') </h4>
                        <h5 class="text-white op-7 mb-2"></h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <a href="/dashboard/manage" class="btn btn-white btn-border btn-round mr-2">Manage</a>
                        <a href="#" class="btn btn-secondary btn-round" data-toggle="modal" data-target="#customerModal">Add New Estimate</a>
                    </div>
                </div>
            </div>
        </div>



