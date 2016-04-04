<option value="0">Choose Addon</option>
<?php 
foreach($menus as $menu)
{
    $addons = \App\Http\Models\Menus::where('parent',$menu->id)->get();
    foreach($addons as $addon){
    ?>
        <option value="{{$addon->id}}">{{$addon->menu_item}}</option>
<?php
    
    }
}

?>
