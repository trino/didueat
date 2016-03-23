<div class="modal" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="ratingModalLabel">Your Feedback</h4>
            </div>

            {!! Form::open(array('id'=>'rating-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
            <div class="modal-body">

                <?php
                    printfile("views/popups/rating.blade.php");
                    $alts = array(
                            "login" => "Log in as an existing user",
                            "loading" => "Loading..."
                    );
                ?>

                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="message-error" class="alert alert-danger" style="display: none;"></div>
                        <div id="message-success" class="alert alert-success" style="display: none;"></div>

                        <Div class="show-on-login" @if(!read("id")) style="display: none;" @endif >
                            <div class="form-group">
                                <textarea rows="4" placeholder="My Review" id="ratingInput" class="form-control" maxlength="5000" required></textarea>
                            </div>
                            <DIV CLASS="col-md-12 p-a-0" ID="rating-error" style="color: red;"></DIV>

                            <div class="pull-left">
                                <div class="form-group pull-right" id="display-rating-starts">
                                    <div class="pull-left" style="padding-top:3px; padding-right:7px;">Rating</div>
                                    <div class="pull-left">
                                        {!! select_rating_starts((session('session_id'))?"rating":"static-rating", "menu") !!}
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right">
                                <button class="btn btn-primary pull-right">Save</button>
                            </div>
                        </div>

                        @if(!read("id"))
                            <a href="#" class="btn btn-primary hide-on-login" data-toggle="modal" data-target="#loginModal" onclick="setupratinglogin();" title="{{ $alts["login"] }}">Log in to review</a>
                        @endif
                    </div>

                    <input type="hidden" id="rating_id" value=""/>
                    <input type="hidden" id="data-rating-id" value=""/>
                    <input type="hidden" id="data-target-id" value=""/>
                    <input type="hidden" id="data-type" value=""/>
                    <input type="hidden" id="ratingInputHidden" value=""/>

                    {!! Form::close() !!}
                </div>
            </div>


            <div class="row p-t-0 m-t-0">
                <!-- we need this to populate user reviews -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" id="reviews"></div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" id="modal_contents"><img src="{{ asset('assets/images/loader.gif') }}" alt="{{ $alts["loading"] }}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<SCRIPT>
    function setupratinglogin(){
        $('#ratingModal').modal('hide');
        needsrating = true;
    }

    $('body').on('submit', '#rating-form', function (e) {
        var ratingbox = $('#rating-form #ratingInputHidden').val();
        var rating = $('#rating-form #rating_id').val();
        var rating_id = $('#rating-form #data-rating-id').val();
        var target_id = $('#rating-form #data-target-id').val();
        var type = $('#rating-form #data-type').val();
        $("#rating-error").text("");
        if(!rating){
            $("#rating-error").text("Star rating is required");
            return false;
        }

        $.post("{{ url('rating/save') }}", {
            rating: rating,
            rating_id: rating_id,
            target_id: target_id,
            comments: ratingbox,
            type: type,
            _token: "{{ csrf_token() }}"
        }, function (json) {
            if (json.type == "error") {
                $('#rating-form #message-success').hide();
                $('#rating-form #message-error').show();
                $('#rating-form #message-error').text(json.response);
            } else {
                $('#rating-form #message-error').hide();
                $('#rating-form #message-success').show();
                $('#rating-form #message-success').text(json.response);
                $('#rating-form #ratingInput').val('');

                setTimeout(function () {
                    $('#ratingModal').modal('hide');
                    $('#parent' + target_id + ' .static-rating .rating-it-btn').attr('data-count-exist', 1);
                    $.each($('#parent' + target_id + ' .static-rating input[value="' + rating + '"]'), function (index, value) {
                        $(this).addClass("checked-stars");
                        $(this).attr("checked", true);
                    });
                    $('#restaurant_rating .static-rating .rating-it-btn').attr('data-count-exist', 1);
                    $.each($('#restaurant_rating .static-rating input[value="' + rating + '"]'), function (index, value) {
                        $(this).addClass("checked-stars");
                        $(this).attr("checked", true);
                    });

                    updatereview(target_id);
                }, 500);
                //$('#ratingModal #rating-form').hide();
            }
        });
        e.preventDefault();
    });
</SCRIPT>