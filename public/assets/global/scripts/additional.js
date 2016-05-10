function overlay_loader_show(){
    shownat = Date.now();
    $('.overlay_loader').show();
}

function overlay_loader_hide(){
    $('.overlay_loader').hide();
    var text = "Loading took: " + (Date.now() - shownat) + " ms";
    if (debugmode) {
        $("#p-footer").append(text);
        console.log(text);
    }
}

//duplicate of check_enabled
$('.is_active').live('change',function(){
    var stat = 0;
    if($(this).is(':checked')) {
        stat = 1;
    }
    var id = $(this).closest('.newmenu').attr('id').replace('newmenu','');
    var $_parent = $(this).closest('.modal-content').find('.newmenu');
    var cat_id = $_parent.find('.cat_id').val();
    var $thi = $(this);
   $.ajax({
            url:base_url+'restaurant/check_enable/'+id+'/'+cat_id+'/25/'+stat,
            success:function(res) {
                res = res.trim();
                //alert('0_'+res+'_'+'0');
                /*if(res=='0') {
                    alert('You can only enable 25 items');
                    $thi.prop('checked', false);
                }*/
            }
        }) 
})

//handles the enabling/disabling of menu items
//id: menu item id
//cat_id: unknown
//stat: status (0/1)
//$thi: the element to uncheck if something goes wrong
//base_url: mirror of the base)url global variable
function check_enabled(id,cat_id,stat,$thi,base_url) {
    var $ajax = $.ajax({
            url:base_url+'restaurant/check_enable/'+id+'/'+cat_id+'/25/'+stat,
            success:function(res) {
                res = res.trim();
                //alert('0_'+res+'_'+'0');
                if(res=='0') {
                    alert('You can enable up to 25 items only.', "check enabled in additional.js");
                    $thi.prop('checked', false);
                    overlay_loader_hide();
                }
            },
            async: false
    });
    //return $ajax.responseText;
    return '1';
}
/*
$(".sorting_child").live('click', function () {
    var pid = $(this).attr('id').replace('child_up_', '').replace('child_down_', '');
    var sort = 'down';
    if ($(this).attr('id') == 'child_up_' + pid) {
        sort = 'up';
    }

    var order = '';
    $(this).closest('.subcat').find('.cmore').each(function (index) {
        var val = $(this).attr('id').replace('cmore', '');
        if (order == '') {
            order = val;
        } else {
            order = order + ',' + val;
        }
    });
    $th = $(this);

    $.ajax({
        url: base_url+"restaurant/orderCat/" + pid + '/' + sort,
        data: 'ids=' + order + '&_token='+token,
        type: 'post',
        success: function (res) {
            $th.closest('.addmore').load(base_url+"restaurant/loadChild/" + res + '/0');
        }
    });
});
*/
//handles sorting of children
$(".sorting_child").live('click', function () {
    
    var start=0;
    var allpar = $(this).closest('.addmore');
    var pid = $(this).attr('id').replace('child_up_', '').replace('child_down_', '');
    var sort = 'down';
    if ($(this).attr('id') == 'child_up_' + pid) {
        sort = 'up';
    }
    var $real = $(this).closest('.cmore');
    var html1 = $real.html();
    var id1 = $real.attr('id');
    
    if(sort=='up'){
        var html2 = $(this).closest('.cmore').prev().html();
        var id2 = $(this).closest('.cmore').prev().attr('id');
        var $change = $(this).closest('.cmore').prev();
    } else {
        var html2 = $(this).closest('.cmore').next().html();
        var id2 = $(this).closest('.cmore').next().attr('id');
        var $change = $(this).closest('.cmore').next();
    }
    
    $real.html(html2);
    $real.attr('id',id2);
    
    $change.html(html1);
    $change.attr('id',id1);
    
    
    allpar.find('.cmore').each(function(){
        //alert('test');
        $(this).find('button').each(function(){
            $(this).removeAttr('disabled');
        })
    })
    allpar.find('.cmore').first().find('.moveup').attr('disabled','');
    allpar.find('.cmore').last().find('.movedown').attr('disabled','');
});

//handle sorting of addons
$(".addon_sorting").live('click', function () {
    var menu_id = $(this).closest('.newmenu').attr('id').replace('newmenu','');
    var pid = $(this).attr('id').replace('addon_up_', '').replace('addon_down_', '');
    if ($(this).attr('id') == 'addon_up_' + pid) {
        var sort = 'up';
    } else {
        var sort = 'down';
    }
    var order = '';// array to hold the id of all the child li of the selected parent
    $('#subcat'+menu_id+' .menuwrapper').each(function (index) {
        var val = $(this).attr('id').replace('sub', '');
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

//handle adding additons
$('.add_additional').live('click', function () {
    var id = $(this).attr('id').replace('add_additional', '').replace(';', '');
    $('.additional' + id).show();
    var c = 0;
    $('.newaction').each(function () {
        $(this).html('<a href="javascript:void(0)" class="btn btn-sm btn-danger removenormal">Remove</a>');
    });
    var ajax_load = '';
    $.ajax({
        url: base_url + 'restaurant/additional?menu_id=' + id,
        success: function (res) {
            $('.additional' + id).append(res);
        }
    });
})
//handle loading previuos additons
$('.loadPrevious').live('change', function () {
    var id = $(this).attr('id').replace('loadPrevious', '').replace(';', '');
    $('.additional' + id).show();
    var c = 0;
    $('.newaction').each(function () {
        $(this).html('<a href="javascript:void(0)" class="btn btn-sm btn-danger removenormal">Remove</a>');
    });
    var addon_id = $(this).val();
    var ajax_load = '';
    if(addon_id!=0)
    {
        $.ajax({
            url: base_url + 'restaurant/loadPrevious/'+addon_id,
            success: function (res) {
                $('.additional' + id).append(res);
            }
        });
    }
})

//handle removing of normal items
$('.removenormal').live('click', function () {
    $_this = $(this);
    if (confirm('Are you sure you want to delete this addon?')) {
        $_this.closest('.menuwrapper').remove();
    }
})

//handle removing the last item
$('.removelast').live('click', function () {
    $_this = $(this);
    var tot = $_this.closest('.newmenu').find('.newaction').length;
    var newmenu = $_this.closest('.newmenu').attr('id');
    var id = newmenu.replace('newmenu','');
    if (confirm('Are you sure you want to delete this addon?')) {
        $_this.closest('.menuwrapper').remove();
        var i = 0;
        $('#' + newmenu + ' .newaction').each(function () {
            i++;
            if (i == tot - 1) {
                if (i != 1){
                    $(this).html('<a href="javascript:void(0)" class="btn btn-sm btn-danger removelast">Remove</a>');
                }
                $(this).show();
            }
        })
    }
});

//unknown
$('.delcmore').live('click',function(){
    var $aitem = $(this).closest('.aitems');
   $(this).closest('.cmore').remove(); 
   var allpar = $aitem.find('.addmore');
            allpar.find('.cmore').each(function(){
                $(this).find('button').each(function(){
                    $(this).removeAttr('disabled');
                })
            })
            allpar.find('.cmore').first().find('.moveup').attr('disabled','');
            allpar.find('.cmore').last().find('.movedown').attr('disabled','');
});

//handle adding more something
$('.addmorebtn').live('click', function () {
    var id = 0;
    $(this).closest('.aitems').find('.addmore').append(
        '<div class="cmore m-b-1">' +
        '<div class=" ignore ignore2 ignore1">' +
        '<div class="col-md-4"><input class="form-control cctitle" type="text" placeholder="Item Name" value="" onblur="$(this).attr(\'value\',$(this).val());" /></div>' +
        '<div class="col-md-4"><input class="form-control ccprice pricechk" type="number" step="0.10" value="" min="0" placeholder="Optional Price" onblur="$(this).attr(\'value\',$(this).val());" /></div>' +
        '</div>' +
        '<div class="col-md-4">'+
        '<div class="btn-group pull-right" role="group" aria-label="Basic example">'+
        '<button href="javascript:void(0)" id="child_up_'+id+'" '+
        'class="btn btn-sm btn-secondary sorting_child moveup"><i class="fa fa-arrow-up"></i></button>'+
        '<button href="javascript:void(0)" disabled="disabled" id="child_down_'+id+'" '+
        'class="btn btn-sm btn-secondary sorting_child movedown"><i class="fa fa-arrow-down"></i></button>'+
        '<button href="javascript:void(0);" class="btn btn-sm btn-secondary delcmore" >'+
        '<i class="fa fa-times"></i> </button>'+
        '</div></div><div class="clearfix"></div></div>');
        var allpar = $(this).closest('.aitems').find('.addmore');
            allpar.find('.cmore').each(function(){
                $(this).find('button').each(function(){
                    $(this).removeAttr('disabled');
                })
            })
            allpar.find('.cmore').first().find('.moveup').attr('disabled','');
            allpar.find('.cmore').last().find('.movedown').attr('disabled','');
});

//unknown
$('.is_multiple').live('change', function () {
    if ($(this).val() == 0) {
        $(this).closest('.radios').find('.exact').show();
    }else {
        $(this).closest('.radios').find('.exact').hide();
    }
});

//handle discount days
$('.days_discount_all').live('click',function(){
   $_parent = $(this).closest('.newmenu');
   if($(this).is(':checked')) {
    $_parent.find('.days_discount').each(function(){
       if(!$(this).is(':checked'))
       $(this).click(); 
    });
   } else {
    $_parent.find('.days_discount').each(function(){
       if($(this).is(':checked'))
       $(this).click(); 
    });
   } 
});

//handle the save button
$('.savebtn').live('click', function () {
catObj=document.getElementById('catList');
for(var i=0;i<catObj.length;i++){
 if(catObj.options[i].text == document.getElementById('cat_name').value){
  catObj.selectedIndex=i;
  document.getElementById('cat_name').value="";
  break;
}

}
    overlay_loader_show();
    var id = $(this).attr('id').replace('save', '');
    $_parent = $(this).closest('.modal-content').find('.newmenu');
    var subber_html = '';
    var stop_id = 0;
    var stop_item = 0;
    var lim = 0;
    var mul = 0;
    $_parent.find('.mul_ch').each(function(){
        var $rad = $(this).closest('.radios');
        if($(this).is(':checked') && $rad.find('.up_t').val()!='2') {
            if($rad.find('.itemno').val()=='') {
                $rad.find('.itemno').attr('style','border:1px solid red');
                alert('Please select number of selection', "additional.js 306");
                scrollto($rad.find('.itemno'));
                overlay_loader_hide();
                $rad.find('.itemno').focus();
                mul = 1;
            }
        }
    });

    if(mul) {
        return false;
    }
    
    /*if($_parent.find('.mul_ch').is(':checked') && $_parent.find('.itemno').val() == '') {
        $_parent.find('.itemno').attr('style','border:1px solid red');
        return false;
    }*/

    $_parent.find('.subber').each(function(){
        var subber_id = $(this).attr('id').replace('sub','');
        subber_html = $('#addmore'+subber_id).text().replace(/ /g,'').length;
        if(subber_html<5) {
            stop_id = 1;
        }
    });

    var chi = 0;
    $('.additional'+id+ ' .subber').each(function(){
        chi++;
        var $_th = $(this);
        if($_th.find('.ctitle').val() == '') {
           $_th.find('.ctitle').attr('style','border-color:red');
            $_th.find('.ctitle').focus();
            stop_item = $_th.find('.ctitle');
        }
        $_th.find('.cctitle').each(function(){
           if($(this).val()=='') {
            $(this).attr('style','border-color:red');
            $(this).focus();
            stop_item = $(this);
           } 
        });
    })
    
    if(stop_item){//This is to check if Addon name is blank
        alert('Addon name cannot be blank', "additional.js 351");
        overlay_loader_hide();
        scrollto(stop_item);
        return false;
    }
    
    if(stop_id){// If addon is added but inserted nothing is sub addon
        alert('One or more of your options are empty', "additional.js 357");
        overlay_loader_hide();
        scrollto(stop_id);
        return false;
    }

    var cat_id = $_parent.find('.cat_id').val();
    var cat_name = $_parent.find('.cat_name').val();
    if ((!cat_id || cat_id == '')&& cat_name=='') {
        alert('Please select or create a category', "additional.js 365");
        scrollto($_parent.find('.cat_id'));
        $_parent.find('.cat_id').attr('style', 'border:1px solid red;');
        $_parent.find('.cat_name').attr('style', 'border:1px solid red;');
        $_parent.find('.cat_id').focus();
        overlay_loader_hide();
        return false;
    }
    var highestCatOrder = $_parent.find('#highestCatOrder').val();

    var ptitle = encodeURIComponent($_parent.find('.newtitle').val());
    if (ptitle == '') {
        alert('Title cannot be blank', "additional.js 376");
        scrollto($_parent.find('.newtitle'));
        $_parent.find('.newtitle').focus();
        $_parent.find('.newtitle').attr('style', 'border:1px solid red;');
        overlay_loader_hide();
        return false;
    }

    var pprice = $_parent.find('.newprice').val();
    if (pprice == '') {
        if(chi==0){
            alert('Price must be a number', "additional.js 386");
            scrollto($_parent.find('.newprice'));
            $_parent.find('.newprice').focus();
            $_parent.find('.newprice').attr('style', 'border:1px solid red;');
            overlay_loader_hide();
            return false;
        }
    }

    var discount_per = $_parent.find('.disc_per').val();
    if(discount_per == 'Choose Discount Percentage:')
    discount_per ='';
    var days_discount = '';
    var is_active = 0;
    if($_parent.find('.is_active').is(':checked')) {
        is_active = 1;
    }
    var ch_en = 1;
   // var ch_en = check_enabled(id,cat_id,is_active,$_parent.find('.is_active'),base_url);

    if(ch_en=='0') {
        return false;
    }
    
    if(!discount_per && $_parent.find('.allow_dis').is(':checked')) {
        alert('Discount Percentage cannot be empty', "$('.savebtn').live('click', function () {");
        scrollto($_parent.find('.disc_per'));
        $_parent.find('.disc_per').focus();
        $_parent.find('.disc_per').attr('style', 'border:1px solid red;');
        overlay_loader_hide();
        return false;
    } else {
        if(!$_parent.find('.allow_dis').is(':checked')) {
            discount_per = '';
            var has_discount = 0;
        } else {
            var has_discount = 1;
            $_parent.find('.days_discount').each(function(){
                if($(this).is(':checked')){
                    if(days_discount == '') {
                        days_discount = $(this).val();
                    } else {
                        days_discount = days_discount + ',' + $(this).val();
                    }
                }
            })
        }
    }

    var checkprc = 0;
    $_parent.find('.pricechk').each(function () {
        if (isNaN($(this).val())) {
            if ($(this).attr('style') == 'margin-left:10px;') {
                $(this).attr('style', 'border:1px solid red;margin-left:10px;');
            }else {
                $(this).attr('style', 'border:1px solid red;');
            }
            if ($(this).attr('placeholder') == 'Price') {
                $('html,body').animate({scrollTop: $(this).parent().parent().parent().parent().parent().parent().offset().top}, 'slow');
            } else {
                $('html,body').animate({scrollTop: $(this).parent().parent().parent().offset().top}, 'slow');
            }
            checkprc = 1;
        }
    });

    if (checkprc) {
        overlay_loader_hide();
        return false;
    }

    var phas_addon = 0;
    var img = $_parent.find('.hiddenimg').val();
    var pdesc = encodeURIComponent($_parent.find('.newdesc').val());
    var pprice = $_parent.find('.newprice').val();

    if ($_parent.find('.menuwrapper').length > 0) {
        phas_addon = 1;
    }
    
    $.ajax({
        url: base_url + 'restaurant/menuadd?id=' + id,
        data: '&menu_item=' + ptitle + '&description=' + pdesc + '&price=' + pprice + '&image=' + img + '&has_addon=' + phas_addon + '&parent=0&_token=' + token + '&cat_id=' + cat_id+'&has_discount='+has_discount+'&discount_per='+discount_per+'&days_discount='+days_discount+'&is_active='+is_active+'&restaurant_id='+$('#res_id').val()+'&cat_name='+cat_name+'&highestCatOrder='+highestCatOrder,
        type: 'post',
        success: function (res) {
            if ($_parent.find('.menuwrapper').length > 0) {
                var d_o = 0;
                var $_this = $(this);
                $_parent.find('.menuwrapper').each(function () {
                    d_o++;
                    var $_this2 = $(this);
                    var ctitle = encodeURIComponent($_this2.find('.ctitle').val());
                    var cdescription = $_this2.find('.cdescription').val();
                    var req_opt = $_this2.find('.is_req').val();
                    var sing_mul = $_this2.find('.is_mul').val();
                    var exact_upto = $_this2.find('.up_t').val();
                    var exact_upto_qty = $_this2.find('.itemno').val();

                    if ($_this2.find('cmore').length > 0) {
                        var has_addon2 = '2';
                    } else {
                        var has_addon2 = '0';
                    }
                        
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
                                    var cctitle = encodeURIComponent($(this).find('.cctitle').val());
                                    var ccprice = $(this).find('.ccprice').val();

                                    $.ajax({
                                        url: base_url + 'restaurant/menuadd',
                                        data: 'menu_item=' + cctitle + '&price=' + ccprice + '&parent=' + res2 + '&_token=' + token + '&display_order=' + di_o + '&cat_id=0',
                                        type: 'post',
                                        success: function (res2) {
                                            if ($_this2.find('.cmore').length == co) {
                                                window.location = base_url + 'restaurant/redfront/restaurants/' + $('#res_slug').val() + '/menu?menuadd=1';
                                            }
                                        }
                                    });
                                });
                            }
                        }
                    });
                });
            } else {
                window.location = base_url + 'restaurant/redfront/restaurants/' + $('#res_slug').val() + '/menu?menuadd=1';
            }
        }
    });
});


var morevisible=[false,false];

function toggleMore(id,msgIns){
    if(!morevisible[id]){
        document.getElementById('moreInfo'+id).style.display='block'
        document.getElementById('readmore'+id).innerHTML="Hide";
        morevisible[id]=true;
    } else{
        document.getElementById('moreInfo'+id).style.display='none'
        document.getElementById('readmore'+id).innerHTML=msgIns+" More";
        morevisible[id]=false;
    }
}

//handles the cuisine/genre check boxes
function chkCBs(cb){
    if(cb){
        if(cbchkd > 2){
            alert("You may check a maximum of only 3 genres. Please adjust your selection accordingly.");
            return false;
        } else{
            cbchkd++;
            return true;
        }
    } else{
        cbchkd--;
        return false;
    }
}