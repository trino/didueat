var path = window.location.pathname;
if(path.replace('didueat','')!=path)
var base_url = 'http://localhost/didueat/public/';
else
var base_url = 'http://didyoueat.ca/';


            
$('.add_additional').live('click',function(){
    
    var id = $(this).attr('id').replace('add_additional','').replace(';','');
    
    
    $('.additional'+id).show();
    var c=0;
    $('.newaction').each(function(){
        //c++;
        //if(c!=1)
       $(this).html('<a href="javascript:void(0)" class="btn btn-danger removenormal">Remove</a>'); 
       //else
       //$(this).hide();
    });
    var ajax_load = '';
    $.ajax({
        url:base_url+'restaurant/additional?menu_id='+id,
        success:function(res)
        {
            $('.additional'+id).append(res);
        }
    });
})

$('.removenormal').live('click',function(){
    $_this = $(this);
     if(confirm('Are you sure you want to delete this item?'))
   $_this.closest('.menuwrapper').remove();
})

$('.removelast').live('click',function(){
  $_this= $(this);  
 var tot = $_this.closest('.newmenu').find('.newaction').length;
    var newmenu = $_this.closest('.newmenu').attr('id');
    //alert(tot);
    if(confirm('Are you sure you want to delete this item?')){
        $_this.closest('.menuwrapper').remove();
    var i=0;
    $('#'+newmenu+' .newaction').each(function(){
        i++;
        if(i==tot-1)
        {
            if(i==1)
            $(this).html('<a class="btn btn-info add_additional" id="add_additional0" href="javascript:void(0)">Add Addons</a> <a class="btn btn-info savebtn" href="javascript:void(0)">Save</a>');
                else
                $(this).html('<a class="btn btn-info add_additional" id="add_additional0" href="javascript:void(0)">Add Addons</a> <a class="btn btn-info savebtn" href="javascript:void(0)">Save</a><br/> <a href="javascript:void(0)" class="btn btn-danger removelast">Remove</a>');
                
            $(this).show();
        }
        
    })
    
    }
    
});
$('.addmorebtn').live('click',function(){
    $(this).closest('.aitems').find('.addmore').append(
    '<div class="cmore"><p style="margin-bottom:0;height:7px;">&nbsp;</p><div class="col-md-8 col-sm-8 col-xs-8 nopadd ignore ignore2 ignore1">'+
    '<input class="form-control cctitle" type="text" placeholder="Item" />'+
    '<input class="form-control ccprice pricechk" type="text" placeholder="Price" style="margin-left:10px;" />'+   
    '</div>'+ 
    '<div class="col-md-2 col-sm-2 col-xs-2 ignore top-padd ignore2">'+
    '<a href="javascript:void(0);" class="btn btn-danger btn-small" onclick="$(this).parent().parent().remove();"><span class="fa fa-close"></span></a>'+  
    '</div><div class="clearfix"></div></div>');
});
$('.is_multiple').live('change',function(){
    if($(this).val()==0)
    $(this).parent().parent().find('.exact').show();
    else
    $(this).parent().parent().find('.exact').hide();
});

$('.savebtn').live('click',function(){
    
    //var $_this = $(this);
    var id = $(this).attr('id').replace('save','');
    //var id = $(this).attr('data-id');
    $_parent = $(this).closest('.newmenu');
    var checkprc = 0;
    $_parent.find('.pricechk').each(function(){
       if(isNaN($(this).val()))
       {
        if($(this).attr('style')=='margin-left:10px;')
        $(this).attr('style','border:1px solid red;margin-left:10px;');
        else
        $(this).attr('style','border:1px solid red;');
        if($(this).attr('placeholder')=='Price')
        {
            $('html,body').animate({ scrollTop: $(this).parent().parent().parent().parent().parent().parent().offset().top}, 'slow');
        }
        else
        $('html,body').animate({ scrollTop: $(this).parent().parent().parent().offset().top}, 'slow');
        checkprc = 1;
       } 
    });
    if(checkprc)
    return false;
    var phas_addon = 0;
    var img = $_parent.find('.hiddenimg').val();
    var ptitle = $_parent.find('.newtitle').val();
    var pprice = $_parent.find('.newprice').val();
    var pdesc = $_parent.find('.newdesc').val();
    var cat_id = $_parent.find('.cat_id').val();
    
    if($_parent.find('.menuwrapper').length > 0)
    phas_addon = 1;
    //alert(id);
    $.ajax({
       url:base_url+'restaurant/menuadd?id='+id,
       data:'menu_item='+ptitle+'&description='+pdesc+'&price='+pprice+'&image='+img+'&has_addon='+phas_addon+'&parent=0&_token='+token+'&cat_id='+cat_id,
       type:'post',
       success:function(res){
       // alert(res);
        //console.log(res); return;
        if($_parent.find('.menuwrapper').length > 0)
        {
            var d_o =0;
            var $_this = $(this);
            $_parent.find('.menuwrapper').each(function(){
                d_o++;
                var $_this2 = $(this);
                var ctitle = $_this2.find('.ctitle').val();
                var cdescription = $_this2.find('.cdescription').val();
                var req_opt = $_this2.find('.is_req').val();
                var sing_mul = $_this2.find('.is_mul').val();
                var exact_upto = $_this2.find('.up_t').val();
                var exact_upto_qty = $_this2.find('.itemno').val();
                
                if($_this2.find('cmore').length > 0)
                {
                    var has_addon2 = '2';
                }
                else
                var has_addon2 = '0';
                $.ajax({
                   url:base_url+'restaurant/menuadd',
                   data:'menu_item='+ctitle+'&description='+cdescription+'&has_addon='+has_addon2+'&parent='+res+'&req_opt='+req_opt+'&sing_mul='+sing_mul+'&exact_upto='+exact_upto+'&exact_upto_qty='+exact_upto_qty+'&_token='+token+'&display_order='+d_o+'&cat_id=0',
                   type:'post',
                   success:function(res2){
                    var di_o = 0;
                    var co = 0;
                    if($_this2.find('.cmore').length > 0)
                    {
                        
                        $('.cmore',$_this2).each(function(){
                            co++;
                            di_o++;
                            var cctitle = $(this).find('.cctitle').val();
                            var ccprice = $(this).find('.ccprice').val();
                            
                            $.ajax({
                               url:base_url+'restaurant/menuadd',
                               data:'menu_item='+cctitle+'&price='+ccprice+'&parent='+res2+'&_token='+token+'&display_order='+di_o+'&cat_id=0',
                               type:'post',
                               success:function(res2){
                                if($_this2.find('.cmore').length == co)
                                {
                                window.location=base_url+'restaurant/red/menus-manager';
                                }
                                
                               }
                            });
                            
                        });
                    }
                   }
                });
                
                
                
            });
        }
        else
        {
            window.location=base_url+'restaurant/red/menus-manager';     
        }
       
       }
    });
});

