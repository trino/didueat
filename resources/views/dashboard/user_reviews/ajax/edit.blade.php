<?php printfile("views/dashboard/user_reviews/ajax/edit.blade.php"); ?>

<div class="form-group row">
    <label for="rating" class="col-sm-3">Rating</label>
    <div class="col-sm-9">
        <input type="number" min = "1" max = "5"  name="rating" class="form-control" id="rating" value="{{ (isset($user_review_detail->rating))?$user_review_detail->rating:'' }}" required="">
    </div>
</div>

<div class="form-group row">
    <label for="comment" class="col-sm-3">Comment</label>
    <div class="col-sm-9">
        <textarea class="form-control" name="comments" id="comments" rows="5" required>{{ (isset($user_review_detail->comments))?trim($user_review_detail->comments):'' }}</textarea>
    </div>
</div>

<input type="hidden" name="id" value="{{ (isset($user_review_detail->id))?$user_review_detail->id:'' }}" />