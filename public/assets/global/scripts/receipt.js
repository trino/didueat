total_items = 0;

//change the quantity of an item
//id: id of the item
//opr: direction. "plus" is up, "minus" is down
function changeqty(id, opr) {
    var num = Number($('.number' + id).text());
    if (isNaN(opr)) {
        if (opr == 'plus') {
            num++;
        } else if(opr == 'minus' && num > 1) {
            num--;
        } else {
            return false;
        }
        $("#select" + id).val(num);
    } else {
        num = opr;
    }
    $('.number' + id).text(num);
    var price = $('.Mprice'+id).val();
    var new_price = num*Number(price);
    $('.modalprice'+id).text('$'+new_price.toFixed(2));
    showloader();
}


//show the loading blocker
function showloader(){
    $(".cart-addon-gif").show();
    $('.pricetitle').hide();
    setTimeout(function(){
        $('.pricetitle').show();
        $(".cart-addon-gif").hide();
    }, 200);
}

//clear the shopping cart
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
        $('.grandtotal').text('$0.00');
        total_items = 0;
        updatecart();
    } else {
        return false;
    }
}

//scroll down to the receipt
function scrolltocheckout(){
    $('html, body').animate({
        scrollTop: $("#cartsz").offset().top
    }, 1000);
}


//show the checkout form, if the cart has met the minimum requirements
function checkout() {
    var del = $('#delivery_flag').val();
    var minimum_delivery = $('#minimum_delivery').val();
    
    var noitems = $('.subtotal').text() == '0' || $('#subtotal1').val() == '0'  || $('#subtotal1').val() == '0.00';
    if($('#pickup1').is(':checked')) {// if($('#pickup1').hasClass('deliverychecked')) {
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

        scrolltocheckout();
        $('#checkoutModal').modal('show'); //show the modal
    }
}

//handle the pickup/delivery radio buttons
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
        $('#pickup1').removeClass('deliverychecked');
        $('#df').show();
        $('#df2').show();
        $('.profile_delevery_type').text('Delivery');
        $('.profile_delivery_detail').show();
        createCookieValue('delivery_type', 'is_delivery');
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
        createCookieValue('delivery_type', 'is_pickup');
        $(this).addClass('deliverychecked');
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
            $('#df2').hide();
            $('#delivery_flag').val('0');
            $('#cart-total').text('$' + grandtotal.toFixed(2));
        }
    }
}

//handle the printer
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

$(function(){
    //seems to be debug code, as it won't do anything but alert text
    $('.modal').on('hidden',function(){
        alert('blured');
    })

    //appears to recalculate the total when switched from pickup to delivery
    $('.del-goods').live('click', function () {
        $(this).parent().remove();
        var subtotal = 0;
        $('.total').each(function () {
            var sub = $(this).text().replace('$', '');
            subtotal = Number(subtotal) + Number(sub);
        })
        subtotal = parseFloat(subtotal);
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

    //handle add/remove span
    $('.addspan').live('click',function(){
        handlespan(this, true);
    });
    $('.remspan').live('click',function(){
        handlespan(this, false);
    });

    function showerror(td_id, text){
        $('.error_'+td_id).stop(true, true);
        $('.error_'+td_id).show();
        $('.error_' + td_id).html(text);
        $('.error_'+td_id).fadeOut(2000);
        return false;
    }
    function handlespan(tthis, dir){
        var td = $(tthis).parent().parent().closest('td');
        var td_id =td.attr('id');
        td_id = td_id.replace('td_','');
        var extra_no = $('#extra_no_' + td_id).val();

        var upto = $('#upto_' + td_id).val();
        var ut = 'exactly';
        if(upto=='0') {
            ut = 'up to';
        }
        var all = 1;

        $(tthis).parent().parent().parent().parent().find('.allspan').each(function(){
            all += Number($(this).text());
        });

        $('.error_' + td_id).html("");
        if(dir) {
            if (all > extra_no && upto!='2') {
                return showerror(td_id, "Cannot select more than " + extra_no + ' options');
            }
        }

        var nqty = '';
        var id = $(tthis).attr('id').replace('addspan_', '').replace('remspan_','');
        var qty = Number($(tthis).parent().find('.span_'+id).text());
        var price  = Number($('.span_'+id).attr('id').replace('sprice_',""));
        var chk = $(tthis).parent().parent().find('#extra_'+id);
        
        var tit = chk.attr('title');
        var title = tit.split("_");
        title[1]= title[1].replace(' x('+qty+")","");
        title[0] = title[0].replace('-'+qty,'');

        if(dir) {
            qty = Number(qty) + Number(1);
        } else if(qty>0) {
            qty = Number(qty) - Number(1);
        } else {
            return false;
        }
        $(tthis).parent().find('.span_'+id).html(qty);
        if(qty == 0) {
            chk.removeClass('checked');
            chk.removeAttr('checked');
            chk.prop('checked',false);
            newtitle= title[1];
            newprice= price;
        } else {
            chk.prop('checked',true);
            chk.attr('checked','checked');
            if(!chk.hasClass('checked')) {
                chk.addClass('checked');
            }
            newtitle= title[1]+" x("+qty+")";
            newprice= Number(price)*Number(qty);
        }

        newtitle = title[0]+"_"+newtitle+"_"+newprice+"_"+title[3];
        newtitle = newtitle.replace(" x(1)","");
        $(tthis).parent().parent().find('.spanextra_'+id).attr('title',newtitle);
        $(tthis).parents('.buttons').find('label.changemodalP').click();
        $(tthis).parents('.buttons').find('label.changemodalP').click();
        if(price!=0)
        showloader();
    }


    //handle the +/- buttons on the receipt
    $('.decrease').live('click', function () {
        direction(this, false);
    });

    $('.increase').live('click', function () {
        direction(this, true);
    });
    function direction(tthis, dir){
        var menuid = $(tthis).attr('id');
        var numid = menuid.replace('dec', '').replace('inc', '');

        var quant = $('#list' + numid + ' span.count').text();
        quant = parseFloat(quant.replace('x', ''));

        var amount = parseFloat( $('#list' + numid + ' .amount').val());

        var del_fee = 0;
        if ($('#delivery_flag').val() == '1') {
            del_fee = $('.df').val();
        }
        del_fee = parseFloat(del_fee);

        var subtotal = 0;
        $('.total').each(function () {
            var sub = $(this).text().replace('$', '');
            subtotal = Number(subtotal) + Number(sub);
        });

        subtotal = parseFloat(subtotal);
        if(dir){
            subtotal = Number(subtotal) + Number(amount);
        } else {
            subtotal = Number(subtotal) - Number(amount);
        }
        subtotal = subtotal.toFixed(2);
        $('div.subtotal').text('$'+subtotal);
        $('input.subtotal').val(subtotal);

        //var tax = $('#tax').text();
        var tax = 13;
        tax = parseFloat(tax);
        tax = (tax / 100) * (subtotal + del_fee);
        tax = tax.toFixed(2);
        $('span.tax').text('$'+tax);
        $('input.tax').val(tax);

        var gtotal = Number(subtotal) + Number(tax) + Number(del_fee);
        gtotal = gtotal.toFixed(2);
        $('div.grandtotal').text('$'+gtotal);
        $('input.grandtotal').val(gtotal);

        var total = $('#list' + numid + ' .total').text();
        total = total.replace("$", "");
        total = parseFloat(total);
        if(dir) {
            total = Number(total) + Number(amount);
        } else {
            total = Number(total) - Number(amount);
        }
        total = total.toFixed(2);
        $('#list' + numid + ' .total').html('<div class="pull-right">$' + total+"</div>");
        $('#list' + numid + ' .prs').val(total);

        if(dir){//increase
            quant++;
            $('#list' + numid + ' span.count').text(quant);
            $('#list' + numid + ' input.count').val(quant);
            total_items++;
        } else {//decrease
            quant = parseFloat(quant);
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
            }
            if(subtotal==0) {
                $('div.grandtotal').text('$0.00');
                $('input.grandtotal').val('0.00');
            }
            total_items--;
        }
        updatecart();
    }

    //not sure what this does
    $('body').on('click','.changemodalP',function(){
        var menu_id = $(this).parents('.modal').find('.add_menu_profile').attr('id').replace('profilemenu','');
        var ids = "";
        var app_title = "";
        var price = 0;

        $('.subitems_' + menu_id).find('input:checkbox, input:radio').each(function (index) {

            if ($(this).hasClass('checked')||($(this).is(':checked') && $(this).attr('title') != "" && $(this).attr('title')!='___')) {
                var tit = $(this).attr('title');
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
        if($('.strikedprice'+menu_id).text()!="") {
            var sP = $('.mainPrice'+menu_id).val();
            sP = Number(sP);
            $('.strikedprice'+menu_id).text('$'+Number(price+sP-Number($('.displayprice'+menu_id).val())).toFixed(2));
        }
    })

})

//updates the cart in the header
function updatecart(){
    var total = $(".grandtotal").html();
    $("#cart-header").show();
    $(".cart-header-total").html(total);
    if(total_items != "" && !isNaN(total_items)){
        $(".cart-header-items").html(total_items);
    }

    $(".cart-header-show").hide();
    $(".cart-header-gif").show();
    setTimeout(function(){//add a delay so it's easier to notice
        $(".cart-header-show").show();
        $(".cart-header-gif").hide();
    }, 1000);
}

var checkingout = false;
window.onbeforeunload = function (e) {
    if (total_items && !checkingout && false) { // enable later when were more established

        var message = "You have not finished your order. Leaving this page will empty your cart.", e = e || window.event;
        if (e) {e.returnValue = message;}// For IE and Firefox
        return message;// For Safari
    }
};