<INPUT TYPE="hidden" id="orderid">

<!--div id="approve-popup-dialog" class="popup-dialog" style="display:none;">
    <?php printfile("views/popups/approve_cancel.blade.php"); ?>
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
</div-->



<!--div id="cancel-popup-dialog" class="popup-dialog" style="display:none;">
    <?php printfile("views/popups/approve_cancel.blade.php"); ?>
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
</div-->






<div class="modal fade" id="orderApproveModal" tabindex="-1" role="dialog" aria-labelledby="orderApproveModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="orderApproveModalLabel">Approve Order</h4>
            </div>
            <div class="modal-body">
                <DIV ID="message" align="center"></DIV>
                {!! Form::open(array('url' => '/restaurant/orders/list/approve', 'id'=>'approve-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                <div class="form-group">
                    <label>Note to Customer</label>
                    <textarea name="note" rows="6" id="approvetext" class="form-control" maxlength="5000" required></textarea>
                    <input type="hidden" name="id" value="" />
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary"  Value=" Approve " onclick="return confirm2('approve');">Submit</button>
                <div class="clearfix"></div>
                {!! Form::close() !!}            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="orderCancelModal" tabindex="-1" role="dialog" aria-labelledby="orderCancelModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="orderCancelModalLabel">Cancel Order</h4>
            </div>
            <div class="modal-body">
                <div ID="message" align="center"></div>
                {!! Form::open(array('url' => '/restaurant/orders/list/cancel', 'id'=>'cancel-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                <div class="form-group">
                    <label>Note to Customer</label>
                    <textarea name="note" id="canceltext" rows="6" class="form-control" maxlength="5000" required></textarea>
                    <input type="hidden" name="id" value="" />
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <button class="btn btn-primary" type="submit" onclick="return confirm2('cancel');"/>Submit</button>
                {!! Form::close() !!}
                <div class="clearfix"></div>

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
        $('body').on('click', '.orderApproveModal', function(){
            var id = $(this).attr('data-id');
            $('#orderApproveModal textarea[name=note]').val('');
            $('#orderApproveModal input[name=id]').val(id);
            setid(id);
        });

        $('body').on('click', '.orderCancelModal', function(){
            var id = $(this).attr('data-id');
            $('#orderCancelModal textarea[name=note]').val('');
            $('#orderCancelModal input[name=id]').val(id);
            setid(id);
        });
        /*
         $('body').on('click', '.disapprove-popup', function(){
         var id = $(this).attr('data-id');
         $('#disapprove-form textarea[name=note]').val('');
         $('#disapprove-form input[name=id]').val(id);
         setid(id);
         });
         */
    });
</script>