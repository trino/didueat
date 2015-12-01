
<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="rating" class="col-md-12 col-sm-12 col-xs-12">Rating <span class="required">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="number"min = "1" max = "5"  name="rating" class="form-control" id="rating" placeholder="{{ (isset($user_review_detail->rating))?$user_review_detail->rating:'' }}" value="{{ (isset($user_review_detail->rating))?$user_review_detail->rating:'' }}" required="">
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="comment" class="col-md-12 col-sm-12 col-xs-12">Comment <span class="required">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
            <textarea name="comments" id="comments" cols="35" rows="5" required>
                {{ (isset($user_review_detail->comments))?$user_review_detail->comments:'' }}
            </textarea>                
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="modal-footer">
    <button type="submit" class="btn red">Save changes</button>
    <input type="hidden" name="id" value="{{ (isset($user_review_detail->id))?$user_review_detail->id:'' }}" />
</div>
