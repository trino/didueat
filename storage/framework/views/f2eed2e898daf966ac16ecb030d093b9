<div class="add_category_popup"><h2>Add Category</h2>
<div class="category_titles margin-bottom-10"><strong>Category Title :</strong>  <input type="text" class="form-control cat_title" /></div>
<p>
<a href="javascript:void(0);" class="btn btn-primary" id="save_cat">Save</a>
</p>
</div>

<script>
$(function(){
   $('#save_cat').click(function(){
    $('.overlay_loader').show();
    var cat = $('.cat_title').val();
    if(cat=='')
    {
      $('.overlay_loader').hide();
      alert('Please enter category title');
      return false;  
    }
    else
    {
    $.ajax({
        url:'<?php echo url('restaurant/saveCat/')?>',
        data:'title='+cat+'&_token=<?php echo csrf_token();?>&res_id=<?php echo $restaurant->id;?>',
        type:'post',
        success:function(){
            $('.overlay_loader').hide();
            alert('Category added successfully');
            $('.cat_title').val('');
            
        }
    });
    }
   }); 
});
</script>