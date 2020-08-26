<!-- Modal -->
<div class="modal fade" id="addServicesModal" tabindex="-1" role="dialog" aria-labelledby="addServicesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServicesModalLabel">Add Service To Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="addServices">
                <form action="#" method="POST">
                    <div class="form-group mb-2">
                        <label for="discountType"> Select Service  <span class="text-danger">*</span></label>
                        <select class="js-example-basic-single" name="serviceId" id="serviceId" style="width:100%" onchange="serviceUpdate()" required>
                            <option selected >Select Service</option>
                            <option value="0">Custom Service</option>
                            <option value="1">Other Options</option>
                        </select>
                    </div>

                    <button type="submit" id="serviceButton" class="btn btn-primary btn-lg btn-block">Add Service To Package</button>
                </form>

                <form id="addCustomServiceForm">
                    <div class="form-group mb-2">
                        <label for="description"> Service Description <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" name="description" id="description" required/>
                    </div>

                    <div class="form-group mb-2">
                        <label for="price"> Service Price <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" name="price" id="price" required/>
                    </div>

                    <button type="submit" id="customServiceButton" class="btn btn-primary btn-lg btn-block">Add Service To Package</button>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>

            </div>
        </div>
    </div>
</div>
