<?php printfile("views/common/delete_edituserreview.blade.php"); ?>

    <div class="form-group row">
        <label for="rating" class="col-sm-3">Rating</label>
        <div class="col-sm-9">
                <input type="number" min = "1" max = "5"  name="rating" class="form-control" id="rating" placeholder="{{ (isset($user_review_detail->rating))?$user_review_detail->rating:'' }}" value="{{ (isset($user_review_detail->rating))?$user_review_detail->rating:'' }}" required="">
        </div>
    </div>


    <div class="form-group row">
        <label for="comment" class="col-sm-3">Comment</label>
        <div class="col-sm-9">
            <textarea class="form-control" name="comments" id="comments" rows="5" required>{{ (isset($user_review_detail->comments))?$user_review_detail->comments:'' }}</textarea>
        </div>
    </div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
    <input type="hidden" name="id" value="{{ (isset($user_review_detail->id))?$user_review_detail->id:'' }}" />
</div>
