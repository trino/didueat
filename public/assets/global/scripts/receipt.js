total_items = 0;

function changeqty(id, opr) {
    var num = Number($('.number' + id).text());
    if (num == '1') {
        if (opr == 'plus') {
            num++;
        }
    } else {
        (opr == 'plus') ? num++ : --num;
    }
    $('.number' + id).text(num);
     var price = $('.Mprice'+id).val();
        var new_price = num*Number(price);
        $('.modalprice'+id).text('$'+new_price.toFixed(2));
    
}

function clearCartItems() {
   var con = confirm('Are you sure you want to clear your cart?');
   if(con==true) {
        $('.receipt_main table.orders tr').remove();
        $('.subtotal').val(0);
        $('.subtotal').text('$0.00');
        $('.tax').val(0);
        $('.tax').text('$0.00');
        if($('#pickup1').hasClass('deliverychecked')) {
            $('.grandtotal').val(0);
            $('.grandtotal').text('$0.00');
        } else {
            var d_fee = $('.df input').val();
            if(!d_fee){d_fee=Number(0);} else {d_fee = Number(d_fee);}
            $('.grandtotal').val(d_fee);
            $('.grandtotal').text('$'+d_fee.toFixed(2));
        }
        total_items = 0;
        updatecart();
   } else {
       return false;
   }
}

function checkout() {
    var del = $('#delivery_flag').val();
    var minimum_delivery = $('#minimum_delivery').val();
    
    var noitems = $('.subtotal').text() == '0' || $('#subtotal1').val() == '0'  || $('#subtotal1').val() == '0.00';
    if($('#pickup1').hasClass('deliverychecked')) {
        //donothing
    } else {
        if(Number($('#subtotal1').val()) == 0){
            if(!debugmode){
                alert('Please make a menu selection before checking out!');
                return false;
            }
        }
        else if(Number($('#subtotal1').val())< Number(minimum_delivery)) {
            alert('Minimum delivery fee not met!');
            return false;
        }
    }
    if (noitems && !debugmode) {
        alert('No items yet');
    } else {
        if(noitems){
            alert('No items yet, but bypassing for debug mode');
        }
        //$('.receipt_main').hide();

       // $('.profiles').show().effect("pulsate", { times:1 }, 1000);
        $('.profiles').fadeIn("slow");

        $('html, body').animate({
            scrollTop: $(".profiles").offset().top
        }, 2000);
        $('#checkoutModal').modal('show'); //show the modal
    }
}

function delivery(t) {
    var df = $('input.df').val();
    if (t == 'show') {
        $('.profile_delivery_detail input, .profile_delivery_detail select').each(function(){
            if($(this).attr('name')=='apartment' || $(this).attr('name')=='address'){
                //do nothing
                //alert($(this).attr('name'));
            } else {
                $(this).attr('required','required');
            }
        });

        $('#df').show();
        $('.profile_delevery_type').text('Delivery');
        $('.profile_delivery_detail').show();

        var tax = $('.maintax').val();

        var grandtotal = 0;
        var subtotal = $('input.subtotal').val();
        grandtotal = Number(grandtotal) + Number(df) + Number(subtotal) + Number(tax);
        $('.df').val(df);
        $('div .grandtotal').text('$'+grandtotal.toFixed(2));
        $('input .grandtotal').val(grandtotal.toFixed(2));
        $('#delivery_flag').val('1');
        $('#cart-total').text('$' + grandtotal.toFixed(2));

    } else {

        $('.profile_delevery_type').text('Pickup');
        $('.profile_delivery_detail').hide();
        $('.profile_delivery_detail input, .profile_delivery_detail select').each(function(){
            $(this).removeAttr('required');
        });

        if ($('#pickup1').hasClass("deliverychecked")) {
            //alert('sss');
        } else {
            var grandtotal = Number($('input.grandtotal').val());
            if($('#subtotal1').val()!= 0) {
                grandtotal = Number(grandtotal) - Number(df);
            }
            $('div .grandtotal').text('$'+grandtotal.toFixed(2));
            $('input .grandtotal').val(grandtotal.toFixed(2));
            $('#df').hide();
            $('#delivery_flag').val('0');
            $('#cart-total').text('$' + grandtotal.toFixed(2));
        }
    }
}

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

$(function(){

    $('.modal').on('hidden',function(){
        alert('blured');
    })
        
    $('.del-goods').live('click', function () {
        $(this).parent().remove();
        var subtotal = 0;
        $('.total').each(function () {
            var sub = $(this).text().replace('$', '');
            subtotal = Number(subtotal) + Number(sub);
        })
        subtotal = parseFloat(subtotal);
        //subtotal = Number(subtotal) - Number(amount);
        subtotal = subtotal.toFixed(2);
        $('div.subtotal').text(subtotal);
        $('input.subtotal').val(subtotal);

        var tax = $('#tax').text();
        tax = parseFloat(tax);
        tax = (tax / 100) * subtotal;
        tax = tax.toFixed(2);
        $('div.tax').text(tax);
        $('input.tax').val(tax);
        var del_fee = 0;
        if ($('#delivery_flag').val() == '1') {
            del_fee = $('.df').val();
        }
        del_fee = parseFloat(del_fee);
        var gtotal = Number(subtotal) + Number(tax) + Number(del_fee);
        gtotal = gtotal.toFixed(2);
        $('div.grandtotal').text(gtotal);
        $('input.grandtotal').val(gtotal);
    });
    
    $('.addspan').live('click',function(){
        var td = $(this).parent().parent().closest('td');
        var td_id =td.attr('id');
        td_id = td_id.replace('td_','');
        var extra_no = $('#extra_no_' + td_id).val();

        var upto = $('#upto_' + td_id).val();
        var ut = 'exactly';
        if(upto=='0') {
            ut = 'up to';
        }
        var all = 1;
        td.find('.allspan').each(function(){
           all += Number($(this).text());
        });

        if(all >extra_no) {
            $('.error_'+td_id).show();
            $('.error_' + td_id).html("Cannot select more than " + extra_no+' options');
            $('.error_'+td_id).fadeOut(2000);
            return false;
        }

        var nqty = '';
        var id = $(this).attr('id').replace('addspan_','');
        var qty = Number($(this).parent().find('.span_'+id).text());
        var price  = Number($('.span_'+id).attr('id').replace('sprice_',""));
        var chk = $(this).parent().parent().find('#extra_'+id);
         
        
        var tit = chk.attr('title');
        var title = tit.split("_");
        title[1]= title[1].replace(' x('+qty+")","");
        title[0] = title[0].replace('-'+qty,'');
        //alert(id+","+qty+","+price+","+tit);
        qty = Number(qty)+ Number(1);
        $(this).parent().find('.span_'+id).html(qty);
        if(qty ==0) {
            chk.removeAttr('checked');
            newtitle= title[1];
            newprice= price;
        } else {
            chk.prop('checked',true);
            chk.attr('checked','checked');
            if(!chk.hasClass('checked'))
                chk.addClass('checked');
            newtitle= title[1]+" x("+qty+")";
            newprice= Number(price)*Number(qty);
            title[0] = title[0]+"-"+qty;
        }

        newtitle = title[0]+"_"+newtitle+"_"+newprice+"_"+title[3];
        newtitle = newtitle.replace(" x(1)","");
        //alert(newtitle);
        $(this).parent().parent().find('.spanextra_'+id).attr('title',newtitle);
        $(this).parents('.buttons').find('label.changemodalP').click();
        $(this).parents('.buttons').find('label.changemodalP').click();
        
    });

    $('.remspan').live('click',function(){
        
        var td = $(this).parent().parent().closest('td');
        var td_id =td.attr('id');
        td_id = td_id.replace('td_','');
        var extra_no = $('#extra_no_' + td_id).val();
        var nqty = '';
        var upto = $('#upto_' + td_id).val();
        var all = 0;
        td.find('.allspan').each(function(){
           all += Number($(this).text());
        });

        if(all <=extra_no) {
            $('.error_' + td_id).html("");
        }
        var id = $(this).attr('id').replace('remspan_','');
        var qty = Number($(this).parent().find('.span_'+id).text());
        var price  = Number($('.span_'+id).attr('id').replace('sprice_',""));
        var chk = $(this).parent().parent().find('#extra_'+id)
        var tit = chk.attr('title');
        
        var title = tit.split("_");
        if(qty !=0) {
            title[1]= title[1].replace('x('+qty+")","");
            title[0] = title[0].replace('-'+qty,'');
            qty = Number(qty) -Number(1);
            $(this).parent().find('.span_'+id).html(qty);
        }
        if(qty ==0) {
            chk.removeClass('checked');
            chk.removeAttr('checked');
            chk.prop('checked',false);
            newtitle = title[1];
            newprice = price;
        } else {
            chk.prop('checked',true);
            chk.attr('checked','checked');
            if(!chk.hasClass('checked'))
                chk.addClass('checked');
            newtitle= title[1]+" x("+qty+")";
            newprice= Number(price)*Number(qty);
            title[0] = title[0]+"-"+qty;
        }

        newtitle = title[0]+"_"+newtitle+"_"+newprice+"_"+title[3];
        newtitle = newtitle.replace(" x(1)","");
        //alert(newtitle);
        $(this).parent().parent().find('.spanextra_'+id).attr('title',newtitle);
        $(this).parents('.buttons').find('label.changemodalP').click();
        $(this).parents('.buttons').find('label.changemodalP input').click();
        
        //$(this).parents('.buttons').find('label.changemodalP').click();
        
    });
        
    $('.decrease').live('click', function () {
        var menuid = $(this).attr('id');
        var numid = menuid.replace('dec', '');

        var quant = $('#list' + numid + ' span.count').text();
        quant = quant.replace('x', '');

        var amount = $('#list' + numid + ' .amount').val();
        amount = parseFloat(amount);

        var subtotal = 0;
        $('.total').each(function () {
            var sub = $(this).text().replace('$', '');
            subtotal = Number(subtotal) + Number(sub);
        })
        subtotal = parseFloat(subtotal);
        subtotal = Number(subtotal) - Number(amount);
        subtotal = subtotal.toFixed(2);
        $('div.subtotal').text('$'+subtotal);
        $('input.subtotal').val(subtotal);

        //var tax = $('#tax').text();
        var tax = 13;
        tax = parseFloat(tax);
        tax = (tax / 100) * subtotal;
        tax = tax.toFixed(2);
        $('span.tax').text('$'+tax);
        $('input.tax').val(tax);

        var del_fee = 0;
        if ($('#delivery_flag').val() == '1') {
            del_fee = $('.df').val();
        }

        del_fee = parseFloat(del_fee);

        var gtotal = Number(subtotal) + Number(tax) + Number(del_fee);
        gtotal = gtotal.toFixed(2);
        $('div.grandtotal').text('$'+gtotal);
        $('input.grandtotal').val(gtotal);

        var total = $('#list' + numid + ' .total').text();
        total = total.replace("$", "");
        total = parseFloat(total);
        total = Number(total) - Number(amount);
        total = total.toFixed(2);
        $('#list' + numid + ' .total').html('<div class="pull-right">$' + total+"</div>");
         $('#list' + numid + ' .prs').val(total);

        quant = parseFloat(quant);
        //alert(quant);
        if (quant == 1) {
            $('#list' + numid).remove();
            $('#profilemenu' + numid).text('Add');
            $('#profilemenu' + numid).attr('style', '');
            $('#profilemenu' + numid).addClass('add_menu_profile');
            $('#profilemenu' + numid).removeAttr('disabled');
            var ccc = 0;
            $('.total').each(function () {
                ccc++;
            });
            if (ccc < 4) {
                $('.orders').removeAttr('style');
            }
            $('.orders').show();
        } else {
            quant--;
            $('#list' + numid + ' span.count').text(quant);
            $('#list' + numid + ' input.count').val(quant);
            //$('#list'+numid+' .count').val(quant-1);
        }
       
        total_items--;
        updatecart();
    });

    $('.increase').live('click', function () {
        var menuid = $(this).attr('id');
        var numid = menuid.replace('inc', '');
        var quant = '';
        quant = $('#list' + numid + ' span.count').text();
        quant = quant.replace('x', '');
        quant = parseFloat(quant);
        var amount = $('#list' + numid + ' .amount').val();
        amount = parseFloat(amount);
        var subtotal = $('#subtotal1').val();
       
        subtotal = parseFloat(subtotal);
        subtotal = Number(subtotal) + Number(amount);
        subtotal = subtotal.toFixed(2);
        $('div.subtotal').text('$'+subtotal);
        $('input.subtotal').val(subtotal);
        //var tax = $('#tax').text();
        var tax = 13;
        tax = parseFloat(tax);
        tax = (tax / 100) * subtotal;
        tax = tax.toFixed(2);
        $('span.tax').text('$'+tax);
        $('input.tax').val(tax);
        var del_fee = 0;
        if ($('#delivery_flag').val() == '1') {
            del_fee = $('.df').val();
        }
        del_fee = parseFloat(del_fee);
        var gtotal = Number(subtotal) + Number(tax) + Number(del_fee);
        gtotal = gtotal.toFixed(2);
        $('div.grandtotal').text('$'+gtotal);
        $('input.grandtotal').val(gtotal);
        var total = $('#list' + numid + ' .total').text();
        total = total.replace("$", "");
        total = parseFloat(total);
        total = Number(total) + Number(amount);
        total = total.toFixed(2);
        $('#list' + numid + ' .total').html('<div class="pull-right">$' + total+"</div>");
        $('#list' + numid + ' .prs').val(total);
        
        quant++;
        $('#list' + numid + ' span.count').text(quant);
        $('#list' + numid + ' input.count').val(quant);
       
        total_items++;
        updatecart();
    });
    
          
        $('body').on('click','.changemodalP',function(){
                var menu_id = $(this).parents('.modal').find('.add_menu_profile').attr('id').replace('profilemenu','');
                var ids = "";
                var app_title = "";
                var price = 0;
                var extratitle = "";
                var dbtitle = "";
                var err = 0;
                var catarray = [];
                var td_index = 0;
                var td_temp = 9999;
                var n_counter = 0;
                $('.subitems_' + menu_id).find('input:checkbox, input:radio').each(function (index) {
                   
                    if ($(this).hasClass('checked')||($(this).is(':checked') && $(this).attr('title') != "" && $(this).attr('title')!='___')) {
                        
                         var tit = $(this).attr('title');
                        //alert(tit);
                        var title = tit.split("_");
                        var x = index;
                        if (title[0] != "") {
                            ids = ids + "_" + title[0];
                        }
                        app_title = app_title + "," + title[1];
                        price = Number(price) + Number(title[2]);
                    }
                });
            $('.modalprice'+menu_id).html('$'+price.toFixed(2));
            $('.Mprice'+menu_id).val(price);
        })
        
}) 


function updatecart(){
    var total = $(".grandtotal").html();
    $("#cart-header").show();
    $(".cart-header-total").html(total);
    if(total_items != "" && !isNaN(total_items)){
      $(".cart-header-items").html(total_items);
    }
}