<div class="newmenu" id="newmenu0">
    <?php printfile("views/common/menu_form.blade.php"); ?>
    <p>&nbsp;</p> 
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="col-sm-5 col-xs-12 nopadd">
            <div class="menuimg menuimg{{ $menu_id }}_1" @if(isset($model) && $model->image) style="min-height:0;" @endif>
                @if(isset($model) && $model->image)
                    <img src="{{ asset('assets/images/products/'.$model->image) }}" />
                    <input type="hidden" class="hiddenimg" value="{{ $model->image }}" />
                @endif
            </div>
            <br />
            <a href="javascript:void(0)" class="btn btn-success newbrowse" id="newbrowse{{ $menu_id }}_1">Image</a>
        </div>
        <div class="col-sm-7 col-xs-12 lowheight">
            <input class="form-control newtitle" type="text" placeholder="Title" value="{{ (isset($model->menu_item))? $model->menu_item : '' }}" /><br />
            <input class="form-control newprice" type="text" placeholder="$" value="{{ (isset($model->price))? $model->price : '' }}" /><br />
            <textarea class="form-control newdesc" placeholder="Description">{{ (isset($model->description))? $model->description : '' }}</textarea>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @if(!isset($ccount) || (isset($ccount) && $ccount==0))
            <div class="newaction">
                <a href="javascript:void(0)" class="btn red btn-info add_additional" id="add_additional{{ $menu_id }}">Add Addons</a>
                <a href="javascript:void(0)" id="save0" data-id="{{ $menu_id }}" class="btn red btn-info savebtn">Save</a>
            </div>
            @endif
        </div>
    </div>
    <div class="clearfix"></div>

    <hr />

    <div class="additional additional{{ $menu_id }}" style="@if(isset($cmodel)&& $cmodel) display:block; @endif">
        <div class="col-md-12 col-sm-12 col-xs-12"><h2>Addons</h2></div>
        <div class="clearfix"></div>
        <?php
        $k=0;
            if(isset($cmodel)){
                foreach($cmodel as $child){
                    $k++;
                    if($k==1)
                    echo "<div id='subcat'>";
                    ?>
                    @include('common.additional')
                    <?php
                }
                if($k>0)
                echo "</div>";
            }
        ?>
    </div>
    <div class="clearfix"></div>
</div>

<script>
$(function(){
        $('#subcat').sortable({
            update: function(event, ui) {
                var order = '';// array to hold the id of all the child li of the selected parent
                $('.parentinfo li').each(function(index) {
                    var val = $(this).attr('id').replace('parent', '');
                    //var val=item[1];
                    if (order == '') {
                        order = val;
                    } else {
                        order = order + ',' + val;
                    }
                });
                $.ajax({
                    url: "{{ url('restaurant/orderCat/') }}",
                    data: 'ids=' + order +"&_token={{ csrf_token() }}",
                    type: 'post',
                    success: function() {
                        //
                    }
                });
            },
            items : ':not(.col-md-12)',
            items : ':not(.clearfix)',
        });
    });
</script>