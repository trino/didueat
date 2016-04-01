@extends('layouts.default')
@section('content')

    <meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>

    <script src="{{ asset('assets/global/scripts/custom-datatable/blockUI.js') }}" type="text/javascript"></script>
    <!--script src="{{ asset('assets/global/scripts/custom-datatable/toastr.min.js') }}"></script-->
    <script src="{{ asset('assets/global/scripts/custom-datatable/custom-plugin-datatable.js') }}" type="text/javascript"></script>
    <STYLE>
        .thumbnail{
            max-width: 128px;
            max-height: 128px;
        }
    </STYLE>

    <div class="container">
        <div class="row">
            @include('layouts.includes.leftsidebar')

            <div class="col-lg-9">
                <?php
                    printfile("views/dashboard/user/uploads.blade.php<BR>");
                    $ProfileName = select_field("profiles", "id", $userid)->name;
                    $Restaurants = enum_anything("restaurants", "uploaded_by", $userid);
                    $ProfilePics = array();
                    $dir = public_path("assets/images/users/" . $userid);
                    if (is_dir($dir)){
                        $ProfilePics = scandir($dir);
                    }
                    unset($ProfilePics[0]);//. (root)
                    unset($ProfilePics[1]);//.. (up a dir)
                    $MenuItems = enum_anything("menus", "uploaded_by", $userid);
                    $alts = array(
                            "deletepic" => "Delete this picture",
                            "deleteitem" => "Delete this menu item"
                    );
                ?>

                @if($Restaurants)
                    @include('dashboard.restaurant.ajax.list', array("Query" => $Restaurants, "recCount" => count($Restaurants), "note" => "Uploaded by " . $ProfileName))
                @else
                    No restaurants uploaded by this user
                @endif
            </div>

            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-lg-9">
                                <h4 class="card-title">
                                    Menu Items Uploaded by {{ $ProfileName }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-block p-a-0">
                        @if($MenuItems)
                        <table class="table table-responsive m-b-0">
                            <THEAD>
                                <TR>
                                    <TH>ID</TH>
                                    <TH>Restaurant</TH>
                                    <TH>Item name</TH>
                                    <TH>Category</TH>
                                    <TH>Price</TH>
                                    <TH>Sales</TH>
                                    <TH></TH>
                                </TR>
                            </THEAD>
                            <?php
                                $Restaurants = enum_all("restaurants");
                                foreach($MenuItems as $MenuItem){
                                    //SELECT * FROM reservations WHERE 3 IN (menu_ids)
                                    //$count = first("SELECT COUNT(" . $MenuItem->id . " IN (menu_ids)) as count FROM reservations")["count"];
                                    $count = iterator_count(select_query("SELECT * FROM reservations WHERE FIND_IN_SET(" . $MenuItem->id . ", menu_ids) > 0"));

                                    $Restaurant = getIterator($Restaurants, "id", $MenuItem->restaurant_id);
                                    echo '<TR ID="deleteitem' . $MenuItem->id . '"><TD>' . $MenuItem->id . '</TD>';
                                    echo '<TD>' . $Restaurant->name . '</TD>';
                                    echo '<TD><A HREF="' . url('restaurants/' . $Restaurant->slug . '/menu?menuitem=') . $MenuItem->id . '">' . $MenuItem->menu_item . '</A></TD>';
                                    echo '<TD>' . $MenuItem->cat_name . '</TD>';
                                    echo '<TD>' . asmoney($MenuItem->price, true) . '</TD>';
                                    echo '<TD>' . $count . '</TD>';
                                    echo '<TD><a style="float:right;" ID="deleteitembtn' . $MenuItem->menu_item . '" class="btn btn-danger-outline btn-sm" title="' . $alts["deleteitem"] . '" onclick="deleteitem(' . $MenuItem->id . ", '" . addslashes($MenuItem->menu_item) . "', '" .  $Restaurant->slug . "'" . ');">X</a></TD></TR>';
                                }
                            ?>
                        </Table>
                        @else
                            No menu items uploaded by this user
                        @endif
                    </div>
                </div>
            </div>

            <!--div class="col-lg-9">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-lg-9">
                                <h4 class="card-title">
                                    Profile Pictures Uploaded by {{ $ProfileName }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-block p-a-0">
                        <?php /*
                            $PicID = 0;
                            foreach($ProfilePics as $ProfilePic){
                                echo '<div ID="deletepic' . $PicID . '" align="center" class="col-md-2"><IMG SRC="' . asset("assets/images/users/" . $userid . "/" . $ProfilePic) . '" class="thumbnail"><BR>';
                                echo $ProfilePic . ' <a style="float:right;" ID="deletepicbtn' . $PicID . '" class="btn btn-danger-outline btn-sm" title="' . $alts["deletepic"] . '" onclick="deletepic(' . $PicID . ', ' . $userid . ", '" . $ProfilePic . "'" . ');">X</a></div>';
                                $PicID++;
                            }
                        */ ?>
                    </div>
                </div>
            </div-->


        </div>

    </div>
    <SCRIPT>
        function deletepic(PicID, UserID, Filename){
            if(confirm('Are you sure you want to delete "' + Filename + '"?')) {
                $("#deletepicbtn" + PicID).html('<i class="fa fa-spinner fa-spin"></i>');
                $.post("{{ url('ajax')}}", {_token: "{{ csrf_token() }}", type: "deletepic", userid: UserID, filename: Filename}, function (result) {
                    $("#deletepic" + PicID).fadeOut();
                });
            }
        }

        function deleteitem(ID, Name, Slug){
            if(confirm('Are you sure you want to delete "' + Name + '"?')) {
                $("#deleteitembtn" + ID).html('<i class="fa fa-spinner fa-spin"></i>');
                $.post("{{ url('restaurant/deleteMenu')}}/" + ID + "/" + Slug, {_token: "{{ csrf_token() }}"}, function (result) {
                    $("#deleteitem" + ID).fadeOut();
                });
            }
        }
    </SCRIPT>
@stop