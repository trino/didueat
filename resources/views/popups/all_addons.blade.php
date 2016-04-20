<option value="0">Addons</option>
<?php
    foreach($menus as $menu){
        $addons = \App\Http\Models\Menus::where('parent', $menu->id)->get();
        foreach($addons as $addon){
            echo  '<option value="' . $addon->id . '">' . $menu->menu_item . " - " . $addon->menu_item . '</option>';
        }
    }
?>
