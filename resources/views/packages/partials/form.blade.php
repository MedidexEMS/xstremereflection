<form action="" id="addPackageForm" method="post">
    @csrf
    <fieldset>
        <div class="form-group">
            <label for="description">Package Name (required, at least 2 characters)</label>
            <input id="description" class="form-control" name="description" minlength="2" type="text" required>
        </div>
        <div class="form-group">
            <label for="cost">Package Cost</label>
            <input id="cost" class="form-control" type="number" name="cost" required>
        </div>
        <div class="form-group">
            <label for="most_purchased"><input id="most_purchased" class="form-check-input" type="checkbox" value="1" name="most_purchased"> Mark item as most purchased (optional)</label>

        </div>
        <div class="form-group">
            <label>Select services which are included in this package.</label>
            <select class="js-example-basic-multiple" multiple="multiple" style="width:100%">
                <option value="AL">Alabama</option>
                <option value="WY">Wyoming</option>
                <option value="AM">America</option>
                <option value="CA">Canada</option>
                <option value="RU">Russia</option>
            </select>
        </div>
        <input class="btn btn-primary" type="submit" value="Submit">
    </fieldset>


</form>
