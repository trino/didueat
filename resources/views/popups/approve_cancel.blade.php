<div id="approve-popup" style="display:none;width:500px;">
    <div class="login-pop-up">
        <div class="login-form" style="">
            <h1>Approve Order</h1>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <DIV ID="message" align="center"></DIV>
                {!! Form::open(array('url' => '/restaurant/orders/list/approve', 'id'=>'approve-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                <div class="form-group">
                    <label>Note: </label>
                    <textarea name="note" rows="6" class="form-control" maxlength="5000" required></textarea>
                    <input type="hidden" name="id" value="" />
                </div>
                <div class="form-group">
                    <input class="btn red" type="submit" Value=" Approve " onclick="return confirm(' Are you sure you want to approve this order ? ');">
                </div>
                <div class="clearfix"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div id="cancel-popup" style="display:none;width:500px;">
    <div class="login-pop-up">
        <div class="login-form" style="">
            <h1>Cancel Order</h1>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div ID="message" align="center"></div>
                {!! Form::open(array('url' => '/restaurant/orders/list/cancel', 'id'=>'cancel-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                <div class="form-group">
                    <label>Note: </label>
                    <textarea name="note" rows="6" class="form-control" maxlength="5000" required></textarea>
                    <input type="hidden" name="id" value="" />
                </div>
                <div class="form-group">
                    <input class="btn red" type="submit" Value=" Cancel " onclick="return confirm(' Are you sure you want to cancel this order ? ');">
                </div>
                <div class="clearfix"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('body').on('click', '.approve-popup', function(){
            var id = $(this).attr('data-id');
            $('#approve-form textarea[name=note]').val('');
            $('#approve-form input[name=id]').val(id);
        });

        $('body').on('click', '.cancel-popup', function(){
            var id = $(this).attr('data-id');
            $('#cancel-form textarea[name=note]').val('');
            $('#cancel-form input[name=id]').val(id);
        });
    });
</script>