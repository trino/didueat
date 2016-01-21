var path = window.location.pathname;
if (path.replace('didueat', '') != path)
    var base_url = 'http://localhost/didueat/public/';
else
    var base_url = 'http://didueat.ca/';
var token = '';
$.ajax({
    url: base_url + 'restaurant/getToken',
    success: function (res) {
        token = res;
        //alert(token);
        // return token;
    }
});
$(".addon_sorting").live('click', function () {
            var menu_id = $(this).closest('.newmenu').attr('id').replace('newmenu','');
            //alert(menu_id);
            //var menu_id = $par.find('.savebtn').attr('id').replace('newmenu','');
            // alert('test');
            var pid = $(this).attr('id').replace('addon_up_', '').replace('addon_down_', '');
            if ($(this).attr('id') == 'addon_up_' + pid) {
                var sort = 'up';
            } else {
                var sort = 'down';
            }
            var order = '';// array to hold the id of all the child li of the selected parent
            $('#subcat'+menu_id+' .menuwrapper').each(function (index) {
                var val = $(this).attr('id').replace('sub', '');
                //var val=item[1];
                if (order == '') {
                    order = val;
                } else {
                    order = order + ',' + val;
                }
            });

            $.ajax({
                url: base_url+"restaurant/orderCat/" + pid + '/' + sort,
                data: 'ids=' + order + "&_token="+token,
                type: 'post',
                success: function (res) {
                    $('#menumanager2').load(base_url + 'restaurant/menu_form/' + res, function () {
                        ajaxuploadbtn('newbrowse' + res + '_1');
                    });
                }
            });

        });
$('.add_additional').live('click', function () {

    var id = $(this).attr('id').replace('add_additional', '').replace(';', '');

    $('.additional' + id).show();
    var c = 0;
    $('.newaction').each(function () {
        //c++;
        //if(c!=1)
        $(this).html('<a href="javascript:void(0)" class="btn btn-sm btn-danger removenormal">Remove</a>');
        //else
        //$(this).hide();
    });
    var ajax_load = '';
    $.ajax({
        url: base_url + 'restaurant/additional?menu_id=' + id,
        success: function (res) {
            $('.additional' + id).append(res);
        }
    });
})

$('.removenormal').live('click', function () {
    $_this = $(this);
    if (confirm('Are you sure you want to delete this item?'))
        $_this.closest('.menuwrapper').remove();
})

$('.removelast').live('click', function () {
    $_this = $(this);
    var tot = $_this.closest('.newmenu').find('.newaction').length;
    var newmenu = $_this.closest('.newmenu').attr('id');
    var id = newmenu.replace('newmenu','');
    //alert(tot);
    if (confirm('Are you sure you want to delete this item?')) {
        $_this.closest('.menuwrapper').remove();
        var i = 0;
        $('#' + newmenu + ' .newaction').each(function () {
            i++;
            if (i == tot - 1) {
                if (i == 1){
                    //$(this).html('<a class="btn btn-sm btn-info add_additional" id="add_additional'+id+'" href="javascript:void(0)">Add Addons</a> <a class="btn btn-sm btn-info savebtn" id = "save'+id+'" href="javascript:void(0)">Save</a>');
                    }
                else{
                    //$(this).html('<a class="btn btn-sm btn-info add_additional" id="add_additional'+id+'" href="javascript:void(0)">Add Addons</a> <a class="btn btn-sm btn-info savebtn" id = "save'+id+'" href="javascript:void(0)">Save</a><br/> <a href="javascript:void(0)" class="btn btn-sm btn-danger removelast">Remove</a>');
                    $(this).html('<a href="javascript:void(0)" class="btn btn-sm btn-danger removelast">Remove</a>');
                    }
                $(this).show();
            }
        })
    }
});
$('.addmorebtn').live('click', function () {
    $(this).closest('.aitems').find('.addmore').append(
        '<div class="cmore"><p style="margin-bottom:0;height:7px;">&nbsp;</p><div class="col-md-8 col-sm-8 col-xs-8 nopadd ignore ignore2 ignore1">' +
        '<div class="col-md-6 padding-left-0"><input class="form-control cctitle" type="text" placeholder="Item" /></div>' +
        '<div class="col-md-6 padding-left-0"><input class="form-control ccprice pricechk" type="text" placeholder="Price" /></div>' +
        '</div>' +
        '<div class="col-md-2 col-sm-2 col-xs-2 ignore top-padd ignore2">' +
        '<a href="javascript:void(0);" class="btn btn-sm btn-danger btn-small" onclick="$(this).parent().parent().remove();"><span class="fa fa-close"></span></a>' +
        '</div><div class="clearfix"></div></div>');
});
$('.is_multiple').live('change', function () {
    if ($(this).val() == 0)
        $(this).closest('.radios').find('.exact').show();
    else
        $(this).closest('.radios').find('.exact').hide();
});
$('.days_discount_all').live('click',function(){
   $_parent = $(this).closest('.newmenu');
   if($(this).is(':checked'))
   {
    $_parent.find('.days_discount').each(function(){
       if(!$(this).is(':checked'))
       $(this).click(); 
    });
   }
   else
   {
    $_parent.find('.days_discount').each(function(){
       if($(this).is(':checked'))
       $(this).click(); 
    });
   } 
});
$('.savebtn').live('click', function () {
    //var $_this = $(this);
    $('.overlay_loader').show();
    var id = $(this).attr('id').replace('save', '');
    //alert(id);
    //var id = $(this).attr('data-id');
    $_parent = $(this).closest('.modal-content').find('.newmenu');
    var cat_id = $_parent.find('.cat_id').val();
    var cat_name = $_parent.find('.cat_name').val();
    if (!cat_id || cat_id == '') {
        alert('Please select a category');
        $_parent.find('.cat_id').attr('style', 'border:1px solid red;');
        $_parent.find('.cat_id').focus();
        $('.overlay_loader').hide();
        return false;
    }
    var ptitle = $_parent.find('.newtitle').val();
    if (ptitle == '') {
        alert('Title cannot be blank');
        $_parent.find('.newtitle').focus();
        $_parent.find('.newtitle').attr('style', 'border:1px solid red;');
        $('.overlay_loader').hide();
        return false;
    }
    var pprice = $_parent.find('.newprice').val();
    if (pprice == '') {
        alert('Price cannot be blank');
        $_parent.find('.newprice').focus();
        $_parent.find('.newprice').attr('style', 'border:1px solid red;');
        $('.overlay_loader').hide();
        return false;
    }
    var discount_per = $_parent.find('.disc_per').val();
    if(discount_per == 'Choose Discount Percentage:')
    discount_per ='';
    var days_discount = '';
    if($_parent.find('.is_active').is(':checked'))
    {
        var is_active = 1;
    }
    else
    var is_active = 0;
    if(!discount_per && $_parent.find('.allow_dis').is(':checked'))
    {
        alert('Discount Percentage cannot be empty');
        $_parent.find('.disc_per').focus();
        $_parent.find('.disc_per').attr('style', 'border:1px solid red;');
        $('.overlay_loader').hide();
        return false;
    }
    else
    {
        if(!$_parent.find('.allow_dis').is(':checked'))
        {
            discount_per = '';
            var has_discount = 0;
            //alert('here');
        }
        else
        {
            //alert('there');
            
            var has_discount = 1;
            $_parent.find('.days_discount').each(function(){
                if($(this).is(':checked')){
                    if(days_discount == '')
                    {
                        days_discount = $(this).val();
                    }
                    else
                    days_discount = days_discount+','+$(this).val();
                }
               // alert(days_discount);
            })
        }
    }
    var checkprc = 0;
    $_parent.find('.pricechk').each(function () {
        if (isNaN($(this).val())) {
            if ($(this).attr('style') == 'margin-left:10px;')
                $(this).attr('style', 'border:1px solid red;margin-left:10px;');
            else
                $(this).attr('style', 'border:1px solid red;');
            if ($(this).attr('placeholder') == 'Price') {
                $('html,body').animate({scrollTop: $(this).parent().parent().parent().parent().parent().parent().offset().top}, 'slow');
            }
            else
                $('html,body').animate({scrollTop: $(this).parent().parent().parent().offset().top}, 'slow');
            checkprc = 1;
        }
    });
    if (checkprc) {
        $('.overlay_loader').hide();
        return false;
    }

    // $_parent.find('.savebtn').attr('disabled','disabled');
    var phas_addon = 0;
    var img = $_parent.find('.hiddenimg').val();

    var pdesc = $_parent.find('.newdesc').val();

    var pprice = $_parent.find('.newprice').val();


    if ($_parent.find('.menuwrapper').length > 0)
        phas_addon = 1;
    
    $.ajax({
        url: base_url + 'restaurant/menuadd?id=' + id,
        data: 'menu_item=' + ptitle + '&description=' + pdesc + '&price=' + pprice + '&image=' + img + '&has_addon=' + phas_addon + '&parent=0&_token=' + token + '&cat_id=' + cat_id+'&has_discount='+has_discount+'&discount_per='+discount_per+'&days_discount='+days_discount+'&is_active='+is_active+'&restaurant_id='+$('#res_id').val()+'&cat_name='+cat_name,
        type: 'post',
        success: function (res) {
            // alert(res);
            //console.log(res); return;
            if ($_parent.find('.menuwrapper').length > 0) {
                var d_o = 0;
                var $_this = $(this);
                $_parent.find('.menuwrapper').each(function () {
                    d_o++;
                    var $_this2 = $(this);
                    var ctitle = $_this2.find('.ctitle').val();
                    var cdescription = $_this2.find('.cdescription').val();
                    var req_opt = $_this2.find('.is_req').val();
                    var sing_mul = $_this2.find('.is_mul').val();
                    var exact_upto = $_this2.find('.up_t').val();
                    var exact_upto_qty = $_this2.find('.itemno').val();

                    if ($_this2.find('cmore').length > 0) {
                        var has_addon2 = '2';
                    }
                    else
                        var has_addon2 = '0';
                    $.ajax({
                        url: base_url + 'restaurant/menuadd',
                        data: 'menu_item=' + ctitle + '&description=' + cdescription + '&has_addon=' + has_addon2 + '&parent=' + res + '&req_opt=' + req_opt + '&sing_mul=' + sing_mul + '&exact_upto=' + exact_upto + '&exact_upto_qty=' + exact_upto_qty + '&_token=' + token + '&display_order=' + d_o + '&cat_id=0',
                        type: 'post',
                        success: function (res2) {
                            var di_o = 0;
                            var co = 0;
                            if ($_this2.find('.cmore').length > 0) {

                                $('.cmore', $_this2).each(function () {
                                    co++;
                                    di_o++;
                                    var cctitle = $(this).find('.cctitle').val();
                                    var ccprice = $(this).find('.ccprice').val();

                                    $.ajax({
                                        url: base_url + 'restaurant/menuadd',
                                        data: 'menu_item=' + cctitle + '&price=' + ccprice + '&parent=' + res2 + '&_token=' + token + '&display_order=' + di_o + '&cat_id=0',
                                        type: 'post',
                                        success: function (res2) {
                                            if ($_this2.find('.cmore').length == co) {
                                                if(d_o==$_parent.find('.menuwrapper').length && di_o==$_this2.find('.cmore').length)
                                                alert('Item saved successfully!');
                                                window.location = base_url + 'restaurant/redfront/restaurants/' + $('#res_slug').val() + '/menus';
                                            }
                                        }
                                    });
                                });
                            }
                        }
                    });
                });
            } else {
                alert('Item saved successfully!');
                window.location = base_url + 'restaurant/redfront/restaurants/' + $('#res_slug').val() + '/menus';
            }
        }
    });
});
/*function check_enable($this,$menu)
{
    $_parent = $this.closest('.par_wrap');
    if($_parent.find('.cat_id').val()=='')
    {
        alert('Please choose category');
        $_parent.find('.cat_id').attr('style', 'border:1px solid red;margin-left:10px;');
        $this.prop('checked', false); 
        $('.disabled').hide();
        return false;
    }
    else
    {
    var cat_id =  $_parent.find('.cat_id').val(); 
    if(cat_id == '1') 
    {
        var num = 7;
    }
    else
    {
        var num = 3;
    }
    if($this.is(':checked'))
    {
        var enable = 1;
    }
    else
    var enable = 0;
    
    $.ajax({
       url: base_url + 'restaurant/check_enable/'+$menu+'/'+cat_id+'/'+num+'/'+enable,
       success:function(res)
       {
        if(res==1)
        {
            if(enable==1){
            $_parent.find('.enabled').show();
            $_parent.find('.disabled').hide();
            }
            else{
            $_parent.find('.disabled').show();
            $_parent.find('.enabled').hide();
            }
        }
        else
        {
            alert(num+" item already selected. Please disable any other item to enable this item.");
            if($this.is(':checked'))
            $this.prop('checked', false); 
            $('.disabled').hide();
        }
       } 
    });
    }
}*/
