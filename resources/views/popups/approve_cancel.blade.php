<INPUT TYPE="hidden" id="orderid">

<div id="approve-popup" class="popup-dialog" style="display:none;">
    <div class="login-pop-up">
        <div class="login-form" style="">
            <h1>Approve Order</h1>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <DIV ID="message" align="center"></DIV>
                {!! Form::open(array('url' => '/restaurant/orders/list/approve', 'id'=>'approve-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                <div class="form-group">
                    <label>Note: </label>
                    <textarea name="note" rows="6" id="approvetext" class="form-control" maxlength="5000" required></textarea>
                    <input type="hidden" name="id" value="" />
                </div>
                <div class="form-group">
                    <input class="btn red" type="submit" Value=" Approve " onclick="return confirm2('approve');">
                </div>
                <div class="clearfix"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div id="disapprove-popup" class="popup-dialog" style="display:none;">
    <div class="login-pop-up">
        <div class="login-form" style="">
            <h1>Disapprove Order</h1>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <DIV ID="message" align="center"></DIV>
                {!! Form::open(array('url' => '/restaurant/orders/list/disapprove', 'id'=>'disapprove-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                <div class="form-group">
                    <label>Note: </label>
                    <textarea name="note" rows="6" id="disapprove" class="form-control" maxlength="5000" required></textarea>
                    <input type="hidden" name="id" value="" />
                </div>
                <div class="form-group">
                    <input class="btn red" type="submit" Value=" Disapprove " onclick="return confirm2('disapprove');">
                </div>
                <div class="clearfix"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div id="cancel-popup" class="popup-dialog" style="display:none;">
    <div class="login-pop-up">
        <div class="login-form" style="">
            <h1>Cancel Order</h1>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div ID="message" align="center"></div>
                {!! Form::open(array('url' => '/restaurant/orders/list/cancel', 'id'=>'cancel-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                <div class="form-group">
                    <label>Note: </label>
                    <textarea name="note" id="canceltext" rows="6" class="form-control" maxlength="5000" required></textarea>
                    <input type="hidden" name="id" value="" />
                </div>
                <div class="form-group">
                    <input class="btn red" type="submit" Value=" Cancel " onclick="return confirm2('cancel');">
                </div>
                <div class="clearfix"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script>
    function setid(id){
       document.getElementById("orderid").value = id;
    }
    function getid(){
        return document.getElementById("orderid").value;
    }
    function confirm2(Action){
        var element = document.getElementById(Action + "text").value.length;
        if(element==0){
            return true;
        }
        return confirm('Are you sure you want to ' + Action + ' order # ' + getid() + '?');
    }

    $(document).ready(function (){
        $('body').on('click', '.approve-popup', function(){
            var id = $(this).attr('data-id');
            $('#approve-form textarea[name=note]').val('');
            $('#approve-form input[name=id]').val(id);
            setid(id);
        });

        $('body').on('click', '.disapprove-popup', function(){
            var id = $(this).attr('data-id');
            $('#disapprove-form textarea[name=note]').val('');
            $('#disapprove-form input[name=id]').val(id);
            setid(id);
        });

        $('body').on('click', '.cancel-popup', function(){
            var id = $(this).attr('data-id');
            $('#cancel-form textarea[name=note]').val('');
            $('#cancel-form input[name=id]').val(id);
            setid(id);
        });
    });
</script>