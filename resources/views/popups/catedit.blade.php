<?php
    printfile("views/popups/catedit.blade.php");

    $category = select_field("category", "id", $id);

    if(!$category){
        echo "<BR>Category " . $id . " failed to load";
        die();
    }

    $restaurant = select_field("restaurants", "id", $category->res_id);
    $categories = select_field("category", "res_id", $restaurant->id, false);
    $categorycount = count($categories);

    foreach(array("cat_id" => $id) as $key => $value){
        echo '<INPUT TYPE="HIDDEN" NAME="' . $key . '" VALUE="' . $value . '">';
    }
?>
<DIV CLASS="form-group">
    <label class="c-input c-radio">
        <input type="radio" value="rename" name="action" onclick="show('rename');" CHECKED>
        <span class="c-indicator"></span>
        Rename
    </label>
    @if($categorycount>1)
        <label class="c-input c-radio">
            <input type="radio" value="merge" name="action" onclick="show('merge');">
            <span class="c-indicator"></span>
            Merge
        </label>
    @endif
</DIV>
<?php
    if($categorycount>1){
        echo '<SELECT CLASS="form-control show-all show-merge" name="merge" id="mergeid">';
        foreach($categories as $thecategory){
            if($thecategory->id!= $id){
                echo '<OPTION VALUE="' . $thecategory->id . '">' . $thecategory->title . '</OPTION>';
            }
        }
        echo '</SELECT>';
    }
?>
<INPUT TYPE="TEXT" NAME="newname" id="newname" VALUE="{{ $category->title }}" CLASS="form-control show-all show-rename">
<SCRIPT>
    show('rename');
    function show(type){
        $(".show-all").hide();
        $(".show-" + type).show();
    }

    function savecat(){
        var action = $("input[name=action]:checked").val();
        switch(action){
            case "rename":
                var destination = $("#newname").val();
                break;
            case "merge":
                var destination = $("#mergeid").val();
                break;
        }

        $.post("{{ url('ajax') }}", {
            type: "editcategory",
            action: action,
            destination: destination,
            id: "{{ $id }}",
            _token: "{{ csrf_token() }}"
        }, function (result) {
            if(result){alert(result);}
            window.location.reload();
        });
    }
</SCRIPT>
