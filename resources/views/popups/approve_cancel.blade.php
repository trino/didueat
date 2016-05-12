<INPUT TYPE="hidden" id="orderid" class="orderid">

<div class="modal" id="orderApproveModal" tabindex="-1" role="dialog" aria-labelledby="orderApproveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="orderApproveModalLabel">Accept Order</h4>
            </div>
            {!! Form::open(array('url' => '/orders/list/approve/'.$type, 'id'=>'approve-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
            <div class="modal-body">
                <?php
                    printfile("views/popups/approve_cancel.blade.php (approve)");
                    $alts = array(
                            "accept" => "Approve of this order",
                            "decline" => "Cancel this order",
                            "delivered" => "Mark the order as having been delivered",
                            "passed" => "Decline this order and pass it to another driver"
                    );
                ?>
                <DIV ID="message" align="center"></DIV>
                <label>Note to Customer:</label>
                @if($type=="driver" && false)
                    <BR>Your order has been accepted
                    <input type="hidden" name="note" value="Your order has been accepted"/>
                @else
                    <textarea name="note" rows="4" id="approvetext" class="form-control" maxlength="5000"></textarea>
                @endif
                <input type="hidden" name="id" class="orderid" value="" />
            </div>
            <div class="modal-footer">
                <!--button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button-->
                <button class="btn btn-primary" value=" Approve " onclick="overlay_loader_show();return confirm3('approve');" title="{{ $alts["accept"] }}">Accept</button>
                <div class="clearfix"></div>
            </div>
            {!! Form::close() !!}            
        </div>
    </div>
</div>


<div class="modal" id="orderCancelModal" tabindex="-1" role="dialog" aria-labelledby="orderCancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="orderCancelModalLabel">Decline Order</h4>
            </div>
            {!! Form::open(array('url' => '/orders/list/cancel/'.$type, 'id'=>'cancel-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
            <div class="modal-body">
                <?php printfile("views/popups/approve_cancel.blade.php (cancel)"); ?>
                <div ID="message" align="center"></div>
                <label>Note to Customer</label>
                <textarea name="note" id="canceltext" rows="4" class="form-control" maxlength="5000"></textarea>
                <input type="hidden" name="id" class="orderid" value="" />
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" onclick="overlay_loader_show();return confirm3('cancel');" title="{{ $alts["decline"] }}"/>Decline</button>
                <div class="clearfix"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal" id="orderDeliveredModal" tabindex="-1" role="dialog" aria-labelledby="orderDeliveredModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="orderDeliveredModalLabel">Order Delivered</h4>
            </div>
            <div class="modal-body">
                <?php printfile("views/popups/approve_cancel.blade.php (delivered)"); ?>
                <div ID="message" align="center"></div>
                <label>Note:</label>
                <textarea name="note" id="driver_note" rows="4" class="form-control" PLACEHOLDER="Add a note" maxlength="5000"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" onclick="savenote();" title="{{ $alts["delivered"] }}"/>Delivered</button>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="orderPassModal" tabindex="-1" role="dialog" aria-labelledby="orderPassModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="orderPassModalLabel">Pass on the order</h4>
            </div>
            <div class="modal-body">
                <?php printfile("views/popups/approve_cancel.blade.php (passed)"); ?>
                <div ID="message" align="center"></div>
                <label>Note:</label>
                <textarea name="note" id="passed_note" rows="4" class="form-control" PLACEHOLDER="Add a note" maxlength="5000"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" onclick="passnote();" title="{{ $alts["passed"] }}"/>Pass</button>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    //sets the order id
    function setid(id){
       document.getElementById("orderid").value = id;
    }
    //gets the order id
    function getid(){
        return document.getElementById("orderid").value;
    }

    function confirm3(Action){
        var element = document.getElementById(Action + "text").value.length;
        if(element==0){
            overlay_loader_show();
            return true;
        }
        $(".orderid").val(getid());
        element = confirm('Are you sure you want to ' + Action + ' order # ' + getid() + '?');
        overlay_loader_hide();
        return element;
    }

    //handle loading of modals
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