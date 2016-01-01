<INPUT TYPE="hidden" id="orderid">

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
            {!! Form::open(array('url' => '/orders/list/approve/'.$type, 'id'=>'approve-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
            <div class="modal-body">
                <DIV ID="message" align="center"></DIV>
                <div class="form-group">
                    <label>Note to Customer</label>
                    <textarea name="note" rows="6" id="approvetext" class="form-control" maxlength="5000" required></textarea>
                    <input type="hidden" name="id" value="" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" value=" Approve " onclick="return confirm2('approve');">Submit</button>
                <div class="clearfix"></div>
            </div>
            {!! Form::close() !!}            
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
            {!! Form::open(array('url' => '/orders/list/cancel/'.$type, 'id'=>'cancel-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
            <div class="modal-body">
                <div ID="message" align="center"></div>
                <div class="form-group">
                    <label>Note to Customer</label>
                    <textarea name="note" id="canceltext" rows="6" class="form-control" maxlength="5000" required></textarea>
                    <input type="hidden" name="id" value="" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" onclick="return confirm2('cancel');"/>Submit</button>
                <div class="clearfix"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript">
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