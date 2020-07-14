@csrf

<div class="form-group">
    <label for="customer">Select Customer</label>
    <select class="js-example-basic-single" id="customer" name="customer" style="width: 100%" onchange="customerChange()" >
        <option selected> Select Customer or Add New Customer </option>
        <option value="0"> Add New Customer </option>
        @foreach($customers as $customer)
            <option value="{{$customer->id}}"> {{$customer->lastName ?? 'Unknown Customer'}} {{$customer->firstName ?? ''}}</option>
        @endforeach
    </select>
</div>

<div id="newCustomer">
    <div class="form-group">
        <label for="firstName">First Name</label>
        <input class="form-control" id="firstName" name="firstName" />
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input class="form-control" id="lastName" name="lastName" />
    </div>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input class="form-control" id="email" name="email" />
        <span class="text-danger" style="display: none">This email is taken</span>
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input class="form-control" id="address" name="address" />
    </div>
    <div class="form-group">
        <label for="phone">Phone Number</label>
        <input class="form-control" id="phone" name="phoneNumber" />
    </div>
</div>
