<script src="{{ asset('assets/global/scripts/jquery.timepicker.js') }}"></script>
<link href="{{ asset('assets/global/css/timepicker.css') }}" rel="stylesheet"/>

@if(Request::path() == '/' || (isset($searchTerm) && Request::path() == "restaurants/".$searchTerm) || (isset($slug) && Request::path() == "restaurants/".$slug."/menu"))



    <FORM ID="addressbar" class="m-a-0 p-a-1" onsubmit="return false;">
        <DIV style="color:red;" ID="skippedreason"></DIV>
        <div style="font-size: 110%;">
            <?php
            $Type = 'HIDDEN';// iif(debugmode(), 'TEXT" TITLE="THESE ARE ONLY VISIBLE IN DEBUG MODE', 'HIDDEN'); //address search bar
            $alts = array(
                    "search" => "Search for restaurants",
                    "reset" => "Reset the search"
            );
            ?>

            <span style="text-wrap: none; white-space: nowrap;float:left;clear:both; ">

            <i class="fa fa-map-marker"></i>

            <input style="margin-left:3px;border: 0 !important;background: transparent !important;" type="text"
                   name="formatted_address"
                   id="formatted_address2"
                   class="formatted_address autosize" placeholder="Enter Delivery Address"
                   onchange="change_address_event();"
                   @if(isset($_GET["search"]))
                   value="{{ $_GET["search"] }}"
                   @endif
                   onpaste="this.onchange();">

</span><br>
            <span style="text-wrap: none; white-space: nowrap;float:left;clear:both; ">
            <i class="fa fa-clock-o"></i>

            <select style="border: 0 !important;background: transparent !important;" name="delivery-time"
                    class="resizeselect m-r-2" id="delivery-time" onchange="searchtimechange();">
                <option value="">Order ASAP</option>
                {{ get_time_interval() }}
            </select>

</span>
                <br>
            <span style="text-wrap: none; white-space: nowrap;float:left;clear:both; ">

            <i class="fa fa-cutlery"></i>
            <select style="border: 0 !important;background: transparent !important;" name="cuisine" id="cuisine"
                    class="resizeselect m-r-2"
                    onchange="createCookieValue('cuisine', this.value); $(this).removeClass('redborder');">
                <option value="">Select Cuisine</option>
                @foreach($cuisine as $value)
                    <option>{{ $value }}</option>
                @endforeach
            </select>
</span>
            <span style="text-wrap: none; white-space: nowrap;float:left;clear:both; ">

            <button class="btn btn-success"
                    onclick="runsearch('search button');" title="{{ $alts["search"] }}">
                <!--i class="fa fa-search"></i--> Bring Me Food
            </button>

            <button style="float: right;" class="btn btn-warning"
                    onclick="resetsearch();" title="{{ $alts["reset"] }}">
                <i class="fa fa-times"></i>
            </button>
</span>

            <!--script>
                (window.navigator.userAgent.indexOf("MSIE") != -1 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) ? document.getElementById('formatted_address2').style.height = '53px' : '';
            </script-->

            <input type="{{ $Type }}" name="latitude" id="latitude" class="latitude" style="color: black;"
                   placeholder="latitude">
            <input type="{{ $Type }}" name="longitude" id="longitude" class="longitude" style="color: black;"
                   placeholder="longitude">
            <input type="{{ $Type }}" name="city" id="city" style="color: black;" placeholder="city">
            <input type="{{ $Type }}" name="province" id="province" style="color: black;" placeholder="province">
            <input type="{{ $Type }}" name="postal_code" id="postal_code" style="color: black;"
                   placeholder="postal_code">
            <input type="{{ $Type }}" name="country" id="country" style="color: black;" placeholder="country">

            @if(debugmode())
                <A class="btn" onclick="googlemap(this);" target="_blank"><i class="fa fa-globe"
                                                                             style="color:blue;"></i></A>
            @endif
<div  class="clearfix"
        </div>

    </FORM>
    <!-- Or view all restaurants from <A class="stroke-black-1px" onclick="setaddress('Hamilton, ON, Canada');">Hamilton</A> or <A class="stroke-black-1px" onclick="cities();">a list of cities</A> -->

    <script>
        var formatted_address2, formatted_address3;

        function skipped(reason, selector) {
            $("#skippedreason").text(reason);
            if (!reason) {
                $(".redborder").removeClass("redborder")
            }
            if (selector) {
                $(selector).addClass("redborder");
            }
        }

        function resetsearch() {
            $('#addressbar input, #addressbar select').val('').trigger('change');
            saveaddresscookie("", "", "", "", "", "", "", "");
            //runsearch("resetsearch");
            location.reload();
        }

        function googlemap(element) {
            $(element).attr("href", 'http://maps.google.com/?q=' + $("#latitude").val() + ',' + $("#longitude").val());
        }

        function initAutocomplete2() {
            formatted_address2 = initAutocompleteWithID('formatted_address2');
            formatted_address3 = initAutocompleteWithID('formatted_address3');
        }

        function setaddress(Address) {
            document.getElementById("formatted_address2").value = Address;
            $("#formatted_address2").trigger("focus");
            $("#formatted_address2").trigger("change");

            setTimeout(function () {
                $(".pac-container.pac-logo").hide();
            }, 100);

            $('#formatted_address2').trigger('blur');
        }

        function change_address_event() {
            $("#formatted_address2").removeClass('redborder');
            setTimeout(function () {
                if ($("#search-form").length) {
                    $("#header-search-button").show();
                }

                if ($("#formatted_address2").val()) {
                    //runsearch("change_address_event");
                }
            }, 100);
        }

        function runsearch(where) {
            log("Runsearch: " + where);
            $('#search-form-submit').trigger('click');
            //submitform(event, 0, "Runsearch: " + where);
        }

        function cities() {
            $('#restuarant_bar').html('');
            $('#parentLoadingbar').show();
            $('#start_up_message').hide();
            // $('#icons_show').hide();
            $('#results_show').show();
            $.post("{{ url('/restaurant/cities') }}", {token: token}, function (result) {
                var quantity = 0;
                $('#parentLoadingbar').hide();
                $('#restuarant_bar').html(result);
            });
        }

        function searchtimechange() {
            var time = $("#delivery-time").val();
            $("#ordered_on_time").val(time);
            createCookieValue('delivery-time', time);
        }

        if (getCookie("cuisine")) {
            $("#cuisine").val(getCookie("cuisine"));
        }
        if (getCookie("delivery-time")) {
            $("#delivery-time").val(getCookie("delivery-time"));
        }

        (function ($, window) {
            var arrowWidth = 40;

            $.fn.resizeselect = function (settings) {
                return this.each(function () {

                    $(this).change(function () {
                        var $this = $(this);

                        // create test element
                        var text = $this.find("option:selected").text();
                        var $test = $("<span>").html(text);

                        // add to body, get width, and get out
                        $test.appendTo('body');
                        var width = $test.width();
                        $test.remove();

                        // set select width
                        $this.width(width + arrowWidth);

                        // run on start
                    }).change();

                });
            };

            // run by default
            $("select.resizeselect").resizeselect();

        })(jQuery, window);


        $.fn.textWidth = function (_text, _font) {//get width of text with font.  usage: $("div").textWidth();
            var fakeEl = $('<span>').hide().appendTo(document.body).text(_text || this.val() || this.text()).css('font', _font || this.css('font')),
                    width = fakeEl.width();
            fakeEl.remove();
            return width;
        };

        $.fn.autoresize = function (options) {//resizes elements based on content size.  usage: $('input').autoresize({padding:10,minWidth:0,maxWidth:100});
            options = $.extend({padding: 10, minWidth: 0, maxWidth: 10000}, options || {});
            $(this).on('input', function () {
                $(this).css('width', Math.min(options.maxWidth, Math.max(options.minWidth, $(this).textWidth() + options.padding)));
            }).trigger('input');
            return this;
        }

        $('.autosize').on('change', function (e) {
            $(this).trigger('input');
        });
        $(document).ready(function () {
            $('.autosize').trigger('input');
        });

        $(".autosize").autoresize({padding: 20, minWidth: 200, maxWidth: 500});

    </script>

    <?php
    printfile("views/common/search_bar.blade.php");
    includeJS(url("assets/global/scripts/provinces.js"));
    if (!includeJS("https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete2&source=header", "async defer")) {
        echo '<SCRIPT>initAutocomplete2();</SCRIPT>';
    }
    ?>
    <script>
        <?php if ($first) {
            echo '$("#addy' . $first . '").trigger("click");';
        } ?>
    </script>
@endif










<!-- delete from here -->


@if(read("id") && false)
    <div class="input-group-btn">
        <?php
        //this is the address dropdown search bar that used to go in the header
        $addresses = \App\Http\Models\ProfilesAddresses::where('user_id', read("id"))->orderBy('order', 'ASC')->get();
        if($addresses->count()){
        ?>
        <button type="button" class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>&nbsp;<i class="fa fa-caret-down"></i>&nbsp;
        </button>
        <div class="dropdown-menu dropdown-menu-left">
            <?php
            foreach ($addresses as $address) {
                if (!$first) {
                    $first = $address->id;
                }
                if (!trim($address->location)) {
                    $address->location = "Address: " . $address->id;
                }
                echo '  <a class="dropdown-item" href="#" id="addy' . $address->id . '" onclick="setaddress(' . "'" . addslashes($address->address) . "'" . ');">';
                echo $address->location . ' [' . $address->address . ']</a>';
            }
            ?>
        </div>
        <?php } ?>
    </div>
@endif


<!--div class="input-group" style="margin-bottom:0 !important; width: 100%">
            <TABLE class="searchtable" width="100%">
                    <TD width="15%"> At </TD>
                    <TD width="20%">
                        <INPUT TYPE="TEXT" CLASS="form-control time col-xs-4" name="delivery-time" id="delivery-time" placeholder="ASAP" onchange="$('#ordered_on_time').val( $('#delivery-time').val() );">
                    </TD>
                    <TD width="20%"> Bring </TD>
                    <TD width="25%">
                        <select name="cuisine" id="cuisine" class="form-control" onchange="createCookieValue('cuisine', this.value)">
                            <option value="">All Cuisine</option>
                            @foreach($cuisine as $value)
    <option>{{ $value }}</option>
                            @endforeach
        </select>
    </TD>
    <TD width="20%"> To </TD>
</TABLE>
</div-->

