@if(!$menu_id)
@endif


<div class="newmenu ignore" id="newmenu{{ $menu_id }}">
    <?php printfile("views/popups/menu_form.blade.php"); ?>

    <div class=" ignore row">

        <div class=" ignore col-md-12" style="margin-bottom:5px; ">
            <div class="menuimg ignore menuimg{{ $menu_id }}_1"
                 @if(isset($model) && $model->image) style="min-height:0;" @endif>
                 @if(isset($model) && $model->image)
                    <img src="{{ asset('assets/images/restaurants/' . $model->restaurant_id . "/menus/" . $model->id . '/thumb_' . $model->image) }}" class="ignore" style="max-width:100%;"/>
                    <input type="hidden" class="hiddenimg ignore" value="{{ $model->image }}"/>
                 @endif
            </div>
            <br class="ignore"/>
            <a href="javascript:void(0)" class="btn btn-sm btn-success blue newbrowse ignore" id="newbrowse{{ $menu_id }}_1">Upload Image</a>

        </div>

        <div class="">
            @if(count($category))


            <div class="col-md-6 "  style="display: none;">
                <div><strong>Category:</strong></div>
                <input class="form-control cat_name" value="<?php if(isset($model) && $model->cat_name){echo $model->cat_name;}?>" />
                <div>
                <select class="cat_id form-control" >
                    <option value="">Category</option>
                    @foreach($category as $cat)
                        <option value="{{ $cat->id }}"
                                @if($cat->id == 1) selected="selected" @endif>{{ $cat->title }}</option>
                    @endforeach
                </select>
                </div>
            </div>

                <!--div class="catblock" style="display: none;">
                    <input type="text" class="form-control cat_title" placeholder="Add new category"/>
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary" id="save_cat">Create</a>
                    <div class="clearfix"></div>
                </div-->


            @else
                <input type="text" placeholder="Add new category" class="form-control cat_id"/>
            @endif






            <div class="col-md-9 "><input class="form-control newtitle ignore" type="text" placeholder="Title" value="{{ (isset($model->menu_item))? $model->menu_item : "" }}"/></div>
            <div class="col-md-3 "><input class="form-control newprice pricechk ignore" type="number" placeholder="Price $" value="{{ (isset($model->price))? $model->price : "" }}"/></div>



            <div class="col-md-12">

                    <textarea class="form-control newdesc ignore" placeholder="Description">{{ (isset($model->description))? $model->description : "" }}</textarea>

            </div>



            <input type="hidden" id="res_slug" value="{{ $res_slug }}"/>
        </div>
        <div class="clearfix ignore"></div>
    </div>







        <div class=" row">




        @include('popups.show_discount')




        <div class="col-md-12">

    <div class="additional additional{{ $menu_id }} ignore" style="<?php if(isset($cmodel) && count($cmodel)){?> display:block;<?php }else{?> display:none;<?php }?>">

        


        
        



        <?php
        $k = 0;
        if(isset($cmodel)){
            

        if (isset($_GET['menu_id'])) {
             $menu_id = $_GET['menu_id'];
             }
            // echo $menu_id;
        foreach($cmodel as $child){
            //die('here');
        $k++;
        if ($k == 1)
            echo "<div class='ignore' id='subcat" . $menu_id . "'>";

        ?>
        @include('popups.additional')
        <?php
        }
        if ($k > 0)
            echo "</div>";
        ?>
        <script class="ignore ignore2 ignore1">
            $(function () {
                $(".sorting_child").live('click', function () {
                    var pid = $(this).attr('id').replace('child_up_', '').replace('child_down_', '');
                    var sort = 'down';
                    if ($(this).attr('id') == 'child_up_' + pid) {
                        sort = 'up';
                    }

                    var order = '';
                    $('#subcat{{ $menu_id }} .cmore').each(function (index) {
                        var val = $(this).attr('id').replace('cmore', '');
                        if (order == '') {
                            order = val;
                        } else {
                            order = order + ',' + val;
                        }
                    });
                    $.ajax({
                        url: "{{ url('restaurant/orderCat') }}/" + pid + '/' + sort,
                        data: 'ids=' + order + '&_token={{ csrf_token() }}',
                        type: 'post',
                        success: function (res) {
                            $('#addmore' + res).load("{{ url('restaurant/loadChild') }}/" + res + '/0');
                        }
                    });
                });
            });
        </script>




        <?php }
        //} ?>


    </div>

    </div>
    </div>
    <div class="clearfix ignore"></div>


</div>















<script>
    $(function () {
        $('#save_cat').live('click', function () {
            $('.overlay_loader').show();
            var cat = $('.cat_title').val();
            if (cat == '') {
                $('.overlay_loader').hide();
                alert('Please enter category title');
                return false;
            } else {
                $.ajax({
                    url: "{{ url('restaurant/saveCat/') }}",
                    data: 'title=' + cat + "&_token={{ csrf_token() }}&res_id={{ (isset($restaurant->id))? $restaurant->id : $res_id }}",
                    type: 'post',
                    success: function (res) {
                        $('.overlay_loader').hide();
                        alert('Category added successfully');
                        $('.cat_id').append('<option value="' + res + '" selected="selected">' + cat + '</option>');
                        $('.cat_title').val('');
                        $('.catblock').fadeOut('slow');
                    }
                });
            }
        });

    });
</script>
