<?php printfile("views/dashboard/user_reviews/ajax/edit.blade.php"); ?>

<?php

echo newrow(false, "Rating", "", true); ?>
        <input type="number" min="0" max="5" class="form-control" id="rating" value="{{ (isset($user_review_detail->rating))?$user_review_detail->rating:'' }}">
    </div>
</div>


<?php

echo newrow(false, "Comments", "", true); ?>

        <textarea class="form-control" name="comments" id="comments" rows="4" required>{{ (isset($user_review_detail->comments))?trim($user_review_detail->comments):'' }}</textarea>
    </div>
</div>

<input type="hidden" name="id" value="{{ (isset($user_review_detail->id))?$user_review_detail->id:'' }}" />