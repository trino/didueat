<div class="add_category_popup">
    <?php
        printfile("views/common/add_category.blade.php");
        $alts = array(
            "save" => "Save changes"
        );
    ?>
    <h2>Add Category</h2>
    <div class="category_titles margin-bottom-10">
        <strong>Category Title :</strong>
        <input type="text" class="form-control cat_title"/>
    </div>
    <p>
        <a href="javascript:void(0);" class="btn btn-primary" title="{{ $alts["save"] }}" id="save_cat">Save</a>
    </p>
</div> 

<script>
    //adds a new category
    $(function() {
        $('#save_cat').click(function() {
            $('.overlay_loader').show();
            var cat = $('.cat_title').val();
            if (cat == '') {
                $('.overlay_loader').hide();
                alert('Please enter category title');
                return false;
            } else {
                $.ajax({
                    url: "{{ url('restaurant/saveCat/') }}",
                    data: 'title=' + cat + "&_token={{ csrf_token() }}&res_id={{ $restaurant->id }}",
                    type: 'post',
                    success: function() {
                        $('.overlay_loader').hide();
                        alert('Category added successfully');
                        $('.cat_title').val('');
                    }
                });
            }
        });
    });
</script>