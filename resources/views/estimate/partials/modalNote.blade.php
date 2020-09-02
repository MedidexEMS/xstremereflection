<!-- Modal -->
<div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="noteModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noteModelLabel">Add Note to Estimate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form action="/estimate/note/{{$estimate->id}}" method="post">
                    @csrf

                    <label for="note">Add Brief Note</label>
                    <input type="text" class="form-control" />

                    <button type="submit" class="btn btn-success btn-block"
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
