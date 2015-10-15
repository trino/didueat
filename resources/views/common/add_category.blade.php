<h2>Add Category</h2>
<strong>Category Title</strong> : <input type="text" class="form-control cat_title" />
<p>
<a href="javascript:void(0);" class="btn btn-primary" id="save_cat">Save</a>
</p>
<?php echo $restaurant->id;?>
<script>
$(function(){
   $('#save_cat').click(function(){
    var cat = $('.cat_title').val();
    $.ajax({
        url:'<?php echo url('restaurants/saveCat/')?>',
        data:'title='+cat+'&_token=<?php echo csrf_token();?>&res_id=<?php echo $restaurant->id;?>',
        type:'post',
        success:function(){
            //do nothing
        }
    })
   }); 
});
</script>