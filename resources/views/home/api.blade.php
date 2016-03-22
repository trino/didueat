@extends('layouts.default')
@section('content')
    <?php
        printfile("views/home/about.blade.php");
        $CN = 0;

        function requiredfields($Fields, $Returns = false){
            if($Returns){$Returns = "<TR><TD>Returns:</TD><TD>" . $Returns . '</TD></TR>';}
            if(is_array($Fields)){
                $Fields2 = array();
                foreach($Fields as $ID => $Field){
                    if(is_numeric($ID)) {
                        $Fields[$Field] = "String";
                        unset($Fields[$ID]);
                    }
                }
                foreach($Fields as $ID => $Field){
                    $OnClick = "";
                    switch (strtolower($Field)){
                        case "password":
                            $Fields[$ID] = "String with a minimum of 3 digits";
                            break;
                        case "email":
                            $Fields[$ID] = "Valid Email Address";
                            break;
                        case "uniqueemail":
                            $Fields[$ID] = "Valid Unused Email Address";
                            break;
                        case "phone":
                            $Fields[$ID] = "Valid Canadian Phone Number";
                            break;
                        case "postalcode":
                            $Fields[$ID] = "Valid Canadian Postal code";
                            break;
                        case "number":
                            $Fields[$ID] = "A number";
                            break;
                        case "genres":
                            $Fields[$ID] = "A comma delimeted list of 1-3 genres";
                            $OnClick = "$('#Genres').trigger('click');";
                            break;
                    }
                    if($OnClick){$OnClick = ' ONCLICK="' . $OnClick . '"';}
                    $Fields2[] = '<A TITLE="' . $Fields[$ID] . '"' . $OnClick  . '>' . $ID . '</A>';
                }
                return '<TABLE><TR><TD NOWRAP>Required fields:</TD><TD>' . implode(", ", $Fields2) . '</TD></TR>' . $Returns . '<TR><TD>Purpose:</TD><TD>';
            }
        }

        function newFAQ($currentNumber, $Name = false, $Purpose = false, $RequiredFields = false, $Returns = false){
            if(is_numeric($currentNumber)){ ?>
                <div class="col-lg-1"></div>
                <div class="col-lg-11">
                    <?php $currentNumber++; ?>
                    <button type="button" class="btn btn-info col-lg-12 btn-responsive2 questions" data-toggle="collapse" data-target="#faq{{ $currentNumber }}" onclick="chngIcon({{ $currentNumber }})" id="{{ $Name }}">{{ $Name }}<div id="ic{{ $currentNumber }}" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></div>
                    </button>

                    <div id="faq{{ $currentNumber }}" class="collapse col-lg-12 faqTxt">
                        <?php
                            $ret = requiredfields($RequiredFields, $Returns);
                            echo $ret . $Purpose;
                            if($ret){echo '</TD></TR></TABLE>';}
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <?php
                $GLOBALS["sections"][ $GLOBALS["currentsection"] ][] = $Name;
                return $currentNumber;
            }
            $GLOBALS["currentsection"] = $currentNumber;
            echo '<div class="col-lg-12"><button class="btn btn-danger col-lg-12 questions btn-responsive2" style="cursor:not-allowed;font-weight:bold">' . $currentNumber . '</button></div>';
        }
    ?>
    <script>
        //togle the visibility of an element
        function toggleDisplay(id,b){
            if(document.getElementById("faq"+id).style.display=="none"){
                document.getElementById("faq"+id).style.display="block";
            } else{
                document.getElementById("faq"+id).style.display="none";
            }
            if(b){
                chngIcon(id,b);
            }
        }

        //change the icon class of an element
        function chngIcon(idn,b){
            if($('#ic'+idn).attr('class') == "glyphicon glyphicon-chevron-down pull-right glyphUp padL"){
                $('#ic'+idn).attr('class','glyphicon glyphicon-chevron-up pull-right glyphUp padL')
            } else{
                $('#ic'+idn).attr('class','glyphicon glyphicon-chevron-down pull-right glyphUp padL')
            }
        }

        function collapseall(value){
            var temp;
            $(".questions").each(function() {
                temp = $(this).next().attr('aria-expanded');
                if(temp == null || temp === undefined){temp = "false";}
                if (temp == value){
                    $(this).trigger("click");
                }
            });
        }
    </script>
    <div class="container">
        <div class="card-block">
            <div class="row">
                <div class="col-md-10">

                    <div class="clearfix"></div>

                    <?php
                        newFAQ("API");
                        $CN = newFAQ($CN, "How to use the API", 'All API calls are directed to <A HREF="' . url("ajax") . '">' . url("ajax") . '</A> with a POST or GET array. <BR>
                            Successful API calls will return a JSON object with "Status" = true, and usually another value containing the results of the API call<BR>
                            Unsuccessful API calls will return "Status" = false, and "Reason" containing more data about why it failed<BR>
                            The "type" value will specify which API call to be used from the following:');

                        $CN = newFAQ($CN, "login", 'To log in as a user using the specified credentials', array("email" => "email", "password" => "password"), '"_token" containing the csrf_token() used for other API calls');

                        $CN = newFAQ($CN, "checkaddress", 'Checks Google Maps for addresses', array("address"), 'Google MAPs information on the address specified. Use this to get the Latitude/Longitude');

                        $CN = newFAQ($CN, "createuser", "Creates a new user",  array("name", "email" => "uniqueemail", "password" => "password"), '"id" containing the id of the created user');

                        $CN = newFAQ($CN, "createrestaurant", 'Creates a new restaurant<BR><A HREF="' . url("ajax") . '?type=createrestaurant&address=183%20Lottridge%20Street&province=Ontario&country=canada&city=hamilton&postal_code=L7P3C3&restname=testrest&name=rest%20owner&email=roy+testrest@gmail.com&password=123456&phone=9055123067&mobile=9055123067&latitude=43.2331903&longitude=-79.76136639999999&cuisines=bbq">Example API call</A>',  array("restname", "name", "email" => "uniqueemail", "password" => "password", "phone" => "phone", "mobile" => "phone", "cuisines" => "genres", "city", "province", "country", "postal_code" => "postalcode", "latitude" => "number", "longitude" => "number"), '"id" containing the id of the created restaurant');

                        newFAQ("Info");
                        $CN = newFAQ($CN, "Genres", "Valid genres are: " . implode(", ", cuisinelist()));
                    ?>
                </div>
                <div class="col-md-2">
                    <A onclick="collapseall('true');">Collapse All</A><BR>
                    <A onclick="collapseall('false');">Expand All</A>
                </div>
            </div>
        </div>
    </div>
@stop

