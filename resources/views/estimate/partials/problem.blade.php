<div class="col-xl-12">
    <form>
        <div class="col-xl-12 mb-2">
            <label>Reported Problem</label>
            <textarea  id="mytextarea" name="mytextarea" style="width: 100%">
              {{$estimate->problem ?? ''}}
            </textarea>
        </div>
        <div class="col-xl-12">
            <button type="submit" class="btn btn-primary btn-sm btn-block">Update Reported Problem</button>
        </div>
    </form>
</div>

