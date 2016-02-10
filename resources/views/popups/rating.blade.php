<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="ratingModalLabel">Your Feedback</h4>
            </div>

            {!! Form::open(array('id'=>'rating-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                <div class="modal-body">

                    <?php printfile("views/common/popups/rating.blade.php"); ?>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="message-error" class="alert alert-danger" style="display: none;"></div>
                            <div id="message-success" class="alert alert-success" style="display: none;"></div>
                            <div class="form-group">
                                <h4>Comments: </h4>
                                <textarea rows="4" id="ratingInput" class="form-control" maxlength="5000" required></textarea>
                            </div>
                            <div class="form-group" id="display-rating-starts">
                                {!! select_rating_starts((session('session_id'))?"rating":"static-rating", "menu") !!}
                            </div>
                            <button class="btn btn-primary pull-right">Save Rating</button>

                        </div>


                        <input type="hidden" id="rating_id" value=""/>
                        <input type="hidden" id="data-rating-id" value=""/>
                        <input type="hidden" id="data-target-id" value=""/>
                        <input type="hidden" id="data-type" value=""/>
                        <input type="hidden" id="ratingInputHidden" value=""/>


                    </div>
                </div>

            {!! Form::close() !!}
            <div class="row">
                <!-- we need this to populate user reviews -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" id="reviews"></div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" id="modal_contents"><img src="{{ asset('assets/images/loader.gif') }}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>