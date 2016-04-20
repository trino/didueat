<div class="newmenu ignore" id="newmenu{{ $menu_id }}">
    <?php
        printfile("views/popups/menu_form.blade.php");
        $browseBtnTxt="Upload Image";
        $imgType="";
        $alts = array(
                "delete" => "Delete image",
                "imgPre" => ""
        );
        $cats_order=[];
    ?>

    <div class="ignore row">
        <div>
            <input type="hidden" class="rest_id" value="<?php if(isset($rest_id)){echo $rest_id;};?>" />
            <div>
                <div class="col-sm-6">
                    <select class="cat_id form-control form-group">
                        <option value="">Select Category</option>
                        @foreach($category as $cat)
                            <?php $cats_order[]=$cat->display_order;?>
                            <option value="{{ $cat->id }}~~{{ $cat->title }}" <?php if(isset($model) && $model->cat_id==$cat->id){?>selected="selected"<?php }?>>{{ $cat->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-6">
                    <input class="form-control cat_name form-group" type="text" placeholder="Or Create New Category"/>
                </div>
                <?php $highestCatOrder=max($cats_order); ?>

            </div>

            <div class=" ignore col-md-12" style="margin-bottom:3px; ">
                <div class="form-group">
                    @if(isset($model) || true)
                        <div class="menuimg ignore menuimg{{ $menu_id }}_1" style="min-height:0;">
                            <?php
                                if(isset($model) && $model->image && strpos($model->image, ".") !== false ){
                                
                                    $browseBtnTxt="Browse";

                                    $menuTSv2="";
                                    if(isset($menuTSv)){
                                      $menuTSv2=$menuTSv;
                                    }

                                    echo '<span id="zoomMsg">Click Image to Zoom In</span><br/><img id="menuImage" class="ignore" alt="'.$alts["imgPre"].'" src="'.asset('assets/images/restaurants/' . $model->restaurant_id . '/menus/' . $model->id . '/small-' . $model->image).'" style="position:relative;cursor:zoom-in;padding-bottom:3px" onclick="toggleFullSizeMenu(\''.asset('assets/images/restaurants/' . $model->restaurant_id . '/menus/' . $model->id) .'\',\''.$model->image.$menuTSv2.'\')" />';

                                } else{
                                   echo '<span id="zoomMsg"></span><img id="menuImage" class="ignore" src="'.asset('assets/images/spacer.gif').'" />';
                                }
                            ?>
                            <input type="hidden" name="image" id="hiddenimg" class="hiddenimg" />
                            <input name="imgName" type="hidden" id="imgName" />
                            <input name="highestCatOrder" id="highestCatOrder" type="hidden" value='{{ (isset($highestCatOrder))? $highestCatOrder:'' }}' />
                            <img src="{{ asset('assets/images/spacer.gif') }}" id="imgPre" style="z-index:0">
                        </div>

                        <?php

							if(isset($_COOKIE['pvrbck'])){
							   echo '<span class="btn btn-sm btn-file btn-success blue newbrowse ignore" id="menuImgUp">
							        <span>'.$browseBtnTxt.'</span><input type="file" onchange="reduceFile(\'photoUpload\')" name="photoUpload" id="photoUpload"></span>';
							} else{
                                echo '<a href="javascript:void(0)" class="btn btn-sm btn-success blue newbrowse ignore" id="newbrowse'. $menu_id.'_1">'.$browseBtnTxt.'</a>';
							}

                        ?>

                        @if(isset($model) && $model->image)
                            <a href="{{ url("restaurant/deletemenuimage/" . $menu_id) }}" id="deleteMenuImg" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete the image for this menu item?');" title="{{ $alts["delete"] }}">Delete image</a>
                        @endif
                        <div id="browseMsg" class="label  text-muted" > (Min. 600x600px)</div>
                    @else
                        Save the item before uploading an image
                    @endif
                    
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

    <div class="row">
        @include('popups.show_discount')
        <div class="col-md-12">
            <div class="additional additional{{ $menu_id }} ignore" style="<?php if(isset($cmodel) && count($cmodel)){?> display:block;<?php }else{?> display:none;<?php }?>">
            <?php
                $k = 0;
                if(isset($cmodel)){
                    if (isset($_GET['menu_id'])) {
                         $menu_id = $_GET['menu_id'];
                    }
                    foreach($cmodel as $child){
                        $k++;
                        if ($k == 1){
                            echo "<div class='ignore subcat' id='subcat" . $menu_id . "'>";
                        }
                        ?>
                            @include('popups.additional')
                        <?php
                    }
                    if ($k > 0){
                        echo "</div>";
                    }
                }
            ?>
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
