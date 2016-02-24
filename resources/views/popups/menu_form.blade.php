@if(!$menu_id)
@endif


<div class="newmenu ignore" id="newmenu{{ $menu_id }}">
    <?php printfile("views/popups/menu_form.blade.php"); ?>

    <div class=" ignore row">
        <div class="display:none;">

            <div class="col-md-6 "  style="display:none;">
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

            @if(false)
            @if(count($category))
                <!--div class="catblock" style="display: none;">
                    <input type="text" class="form-control cat_title" placeholder="Add new category"/>
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary" id="save_cat">Create</a>
                    <div class="clearfix"></div>
                </div-->


            @else
                <input type="text" placeholder="Add new category" class="form-control cat_id"/>
            @endif
            @endif

        <input name="menuImgTemp" type="hidden" id="menuImgTemp"/>
            <div class=" ignore col-md-12" style="margin-bottom:3px; ">
                <div class="form-group">
                    <div class="menuimg ignore menuimg{{ $menu_id }}_1"
                        @if(isset($model) && $model->image && strpos($model->image, ".") !== false )
                            style="min-height:0;">
                            <img src="{{ asset('assets/images/restaurants/' . $model->restaurant_id . "/menus/" . $model->id . '/small-' . $model->image) }}" class="ignore" style="max-width:100%;"/>
                            <input type="hidden" class="hiddenimg ignore" value="{{ $model->image }}"/>
                        @else
                            >
                        @endif
                        <span id="fullSize" class="smallT"></span>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-sm btn-success blue newbrowse ignore" id="newbrowse{{ $menu_id }}_1">Upload Image</a><div id="browseMsg" class="label smRd"></div>
                </div>
            </div>

            <div class="col-md-9 ">
                <div class="form-group">
                    <input class="form-control newtitle ignore" type="text" placeholder="Name" value="{{ (isset($model->menu_item))? $model->menu_item : "" }}"/></div>
                </div>

                <div class="col-md-3 ">
                    <div class="form-group">
                        <input class="form-control newprice pricechk ignore" min="0" type="number" placeholder="Price" value="{{ (isset($model->price))? $model->price : "" }}"/>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <textarea class="form-control newdesc ignore" placeholder="Description">{{ (isset($model->description))? $model->description : "" }}</textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <input type="hidden" id="res_slug" value="{{ $res_slug }}"/>
                    </div>
                </div>
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
            echo "<div class='ignore subcat' id='subcat" . $menu_id . "'>";

        ?>
        @include('popups.additional')
        <?php
        }
        if ($k > 0)
            echo "</div>";
        ?>
        <script class="ignore ignore2 ignore1">
            $(function () {
                
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
