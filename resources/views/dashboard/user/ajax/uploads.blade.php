<?php
    printfile("views/dashboard/user/ajax/uploads.blade.php<BR>");
    $ProfileName = select_field("profiles", "id", $userid)->name;
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

<div class="col-lg-12">
    <div class="card">
        <div class="card-header ">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="card-title">
                        Uploads by {{ $ProfileName }}
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

                        <TH>Price</TH>
                        <TH>Sales</TH>
                        <TH></TH>
                    </TR>
                    </THEAD>
                    <?php
                    $Restaurants = enum_all("restaurants");
                    foreach ($Query as $MenuItem) {
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

                        echo '<TD>' . asmoney($MenuItem->price, true) . '</TD>';
                        echo '<TD>' . $count . '</TD>';
                        if($Restaurant){



                            echo '<TD><a style="float:right;" ID="deleteitembtn' . $MenuItem->menu_item . '" class="" title="' . $alts["deleteitem"] . '" onclick="deleteitem(' . $MenuItem->id . ", '" .
                                    addslashes($MenuItem->menu_item) . "', '" . $Restaurant->slug . "'" . ');"><i id="delete93" class="fa fa-times"></i></a></TD></TR>';
                        }
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