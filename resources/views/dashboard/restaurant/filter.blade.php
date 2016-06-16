<div class="card " style="">
    <div class="card-header">
        <h4 class="card-title">Filter</h4>
    </div>

    <div class="card-block">

        {!! Form::open(array('url' => '/search/restaurants/ajax', 'id'=>'search-form', 'class'=>'search-form m-b-0','method'=>'post','role'=>'form', 'onkeypress' => 'return keypress(event);')) !!}
        <div class="sort search-form clearfix">

            <!--div class="p-l-0 p-r-1 pull-left">
                                    <div class="form-group">
                                        <input name="delivery_type" type="hidden" id="delivery_type"/>
                                        <label class="c-input c-checkbox ">
                                            <input type="checkbox" name="deliverycb" id="deliverycb"
                                                   value="is_delivery"
                                                   {{ $is_delivery_checked }}
                    onclick="setdeliverytype();"/>
             <span class="c-indicator"></span>
             Delivery
         </label>
     </div>
 </div>

 <div class="p-l-0 pull-left">
     <div class="form-group">
         <label class="c-input c-checkbox ">
             <input type="checkbox" name="pickupcb" id="pickupcb"
                    value="is_pickup"
                    {{ $is_pickup_checked }}
                    onclick="setdeliverytype();"/>
             <span class="c-indicator"></span>
             Pickup
         </label>
     </div>
 </div-->

            <div class="form-group">
                <input type="text" name="name" id="name" value="" class="form-control"
                       placeholder="Restaurant Name"
                       onkeyup="createCookieValue('cname', this.value)"/>
            </div>

            <div id="radius_panel" class="form-group row" style="display:none;">
                <div class=" col-md-6">
                    <label id="radius_panel_label">Distance (<?= MAX_DELIVERY_DISTANCE; ?>
                        km)</label>
                </div>
                <div class=" col-md-6">
                    <input type="range" name="radius" id="radius" min="1"
                           max="<?= MAX_DELIVERY_DISTANCE; ?>" value="5"
                           class="form-control"
                           onchange="$('#radius_panel_label').html('Distance (' + $(this).val() + ' km)');">

                    <!--input type="range" name="radius" id="radius" min="1"
                                       max="<?= MAX_DELIVERY_DISTANCE; ?>" value="<?= MAX_DELIVERY_DISTANCE; ?>"
                                       class="form-control"
                                       onchange="$('#radius_panel_label').html('Distance (' + $(this).val() + ' km)');"-->

                </div>
                <div class="clearfix"></div>
            </div>


        </div>
    </div>
    <div class="card-footer text-xs-right">
        <div class="">     <input type="button" name="clearSearch" id="clearSearch" class="btn btn-secondary-outline" value="Reset"/>
            <input type="button" name="search" class="btn btn-primary" value="Filter"
                   id="search-form-submit"
                   onclick="submitform(event, 0, 'search onclick');"/>

        </div>
    </div>
    {!! Form::close() !!}
</div>

<SCRIPT>
    var p = document.getElementById("radius");
    p.addEventListener("input", function () {
        $("#radius").trigger("change");
    }, false);
</SCRIPT>