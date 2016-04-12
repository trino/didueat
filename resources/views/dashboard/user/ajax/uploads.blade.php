<?php
    printfile("views/dashboard/user/ajax/uploads.blade.php<BR>");
    $ProfileName = select_field("profiles", "id", $userid)->name;
    //    $Restaurants = enum_anything("restaurants", "uploaded_by", $userid);
    /*$ProfilePics = array();
    $dir = public_path("assets/images/users/" . $userid);
    if (is_dir($dir)) {
        $ProfilePics = scandir($dir);
    }
    unset($ProfilePics[0]);//. (root)
    unset($ProfilePics[1]);//.. (up a dir)
    */
    $alts = array(
            "deletepic" => "Delete this picture",
            "deleteitem" => "Delete this menu item"
    );
?>

    @if(false)
        @if($Restaurants)
            @include('dashboard.restaurant.ajax.list', array("Query" => $Restaurants, "recCount" => count($Restaurants), "note" => "Uploaded by " . $ProfileName))
        @else
            No restaurants uploaded by this user
        @endif
    @endif
</div>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header ">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="card-title">
                        Menu Items Uploaded by {{ $ProfileName }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="card-block p-a-0">
            @if($Query)
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
                    foreach ($Query as $MenuItem) {

                        //try {
                        //SELECT * FROM reservations WHERE 3 IN (menu_ids)
                        //$count = first("SELECT COUNT(" . $MenuItem->id . " IN (menu_ids)) as count FROM reservations")["count"];
                        $count = iterator_count(select_query("SELECT * FROM reservations WHERE FIND_IN_SET(" . $MenuItem->id . ", menu_ids) > 0"));

                        $Restaurant = getIterator($Restaurants, "id", $MenuItem->restaurant_id);

                        echo '<TR ID="deleteitem' . $MenuItem->id . '"><TD>' . $MenuItem->id . '</TD>';
                        if($Restaurant){
                            echo '<TD>' . $Restaurant->name . '</TD>';
                            echo '<TD><A HREF="' . url('restaurants/' . $Restaurant->slug . '/menu?menuitem=') . $MenuItem->id . '">' . $MenuItem->menu_item . '</A></TD>';
                        } else {
                            echo '<TD>Missing Data</TD>';
                            echo '<TD>' . $MenuItem->menu_item . '</TD>';
                        }
                        echo '<TD>' . $MenuItem->cat_name . '</TD>';
                        echo '<TD>' . asmoney($MenuItem->price, true) . '</TD>';
                        echo '<TD>' . $count . '</TD>';
                        if($Restaurant){
                            echo '<TD><a style="float:right;" ID="deleteitembtn' . $MenuItem->menu_item . '" class="btn btn-danger-outline btn-sm" title="' . $alts["deleteitem"] . '" onclick="deleteitem(' . $MenuItem->id . ", '" . addslashes($MenuItem->menu_item) . "', '" . $Restaurant->slug . "'" . ');">X</a></TD></TR>';
                        }
                        /*} catch (Exception $e) {
                            echo $e->getMessage();
                        }*/

                    }
                    ?>
                </Table>
                <div class="card-footer clearfix">{!! $Pagination !!}</div>
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