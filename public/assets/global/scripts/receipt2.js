var total_items = 0;
var checkingout = false;
var allowbypassminumum = false;
var needsminimum = false;

$( document ).ready(function() {
    log("Receipt system version 2 initialized. Order ID: " + order_id);
});

window.onbeforeunload = function (e) {
    if (total_items && !checkingout && false) { // enable later when were more established
        var message = "You have not finished your order. Leaving this page will empty your cart.", e = e || window.event;
        if (e) {e.returnValue = message;}// For IE and Firefox
        return message;// For Safari
    }
};

//menu_id:      the id of the parent menu item
//ids:          the _ delimeted list of menu ids, starting with the parent item
//quantity:     of the parent menu item
//csr_action:   customer service action to take if something goes wrong
//app_title:    the HTML description of the entire item++extras
//extratitle:   the HTML description of just the extras
//dbtitle:      the HTML description going into the database
//uses: order_id
function additemtoreceipt(menu_id, ids, quantity, price, csr_action, app_title, extratitle, dbtitle){
    log("menu_id " + menu_id + " ids: " + ids + " quantity: " + quantity + " price: " + price + " csr_action: " + csr_action + " apptitle: " + app_title + " extratitle: " + extratitle + " dbtitle: " + dbtitle);
    $.post(baseurl + "/ajax", {
        type: "handlemenu",
        action: "additemtoreceipt",
        _token: token,
        order_id: order_id,

        parent_id: menu_id,
        id_list: ids,
        quantity: quantity,
        price: price,
        csr_action: csr_action,
        title: app_title,
        extratitle: extratitle,
        dbtitle: dbtitle
    }, function (result) {

        result = JSON.parse(result);
        if(!isundefined(result.HTML)) {
            result.HTML = decode(result.HTML);
            $(".orders").prepend(result.HTML);
        }

        calculatetotal(result);
    });
    //update cart: additemtoreceipt 3722 _3722_4665_4673 1 40.97 2
    //apptitle:    <b>Beef Mixed Vegetables</b> <br/>Select Drink:  Coke(+$1) x(2) <br/>Appetizers:  Spring Roll (2 pcs)(+$4)
    //extratitle:  <br/>Select Drink: Coke(+$1) x(2), <br/>Appetizers: Spring Roll (2 pcs)(+$4)
    //dbtitle:     <br/>Select Drink: Coke(+$1) x(2)% <br/>Appetizers: Spring Roll (2 pcs)(+$4)
    //updatecart("additemtoreceipt " + menu_id + " " + ids + " " + quantity + " " + price + " " + csr_action + " apptitle: " + app_title + " extratitle: " + extratitle + " dbtitle: " + dbtitle);
}

function calculatetotal(result){
    //log(simpleStringify(result));
    var subtotal = result.subtotal.toFixed(2);
    $(".subtotal").text("$" + subtotal);
    $('input.subtotal').val(subtotal);

    var tax = 0.13;
    tax = parseFloat(tax) * subtotal;
    tax = tax.toFixed(2);
    $('span.tax').text('$' + tax);
    $('input.tax').val(tax);

    var del_fee = 0;
    if ($('#delivery_flag').val() == '1' || true) {//only delivery
        del_fee = $("#delivery_fee").val();
    }
    del_fee = parseFloat(del_fee);

    var gtotal = calctip(Number(subtotal), Number(tax), Number(del_fee));
    gtotal = gtotal.toFixed(2);
    $('div.grandtotal').text('$' + gtotal);
    $('input.grandtotal').val(gtotal);
    $('#cart-total').text(gtotal);

    updatecart("calculatetotal");
}

function decode(input){
    input = input.replaceAll("&lt;", "<", input);
    input = input.replaceAll("&gt;", ">", input);
    return input;
}

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

function updatequantity(menuitem_id){
    var quantity = $("#selectitem_" + menuitem_id).val();
    $.post(baseurl + "/ajax", {
        type: "handlemenu",
        action: "changequantity",
        _token: token,
        order_id: order_id,

        menuitem_id: menuitem_id,
        quantity: quantity,
    }, function (result) {
        if(quantity == 0){
            $("#menuitem_" + menuitem_id).fadeOut(500);
        }
        calculatetotal(result);
    });
}














//legacy code required to run

//show the checkout form, if the cart has met the minimum requirements
function checkout() {
    var minimum_delivery = $('#minimum_delivery').val();
    var noitems = $('.subtotal').text() == '0' || $('#subtotal1').val() == '0'  || $('#subtotal1').val() == '0.00';
    var subtotal =  Number($('#subtotal1').val());

    if(Number($('#subtotal1').val()) == 0){
        if(!debugmode){
            alert('Please make a menu selection before checking out!');
            return false;
        }
    } else if(subtotal < Number(minimum_delivery) && needsminimum) {
        if (allowbypassminumum) {
            if (confirm('Minimum delivery fee not met! If you accept the additional charges, your subtotal would be $' + minimum_delivery)) {
                $('.subtotal').val(minimum_delivery);
                $('.subtotal').text(minimum_delivery);
                delivery('show');
            } else {
                return false;
            }
        } else if(debugmode) {
            if (!confirm("Minimum delivery fee not met! Bypass anyway? (DEBUG MODE)")){ return false; }
        } else {
            alert("Subtotal must be $"+minimum_delivery+" for delivery!");
            return false;
        }
    }

    if (noitems && !debugmode) {
        alert('No items yet');
    } else {
        if(noitems){
            alert('No items yet, but bypassing for debug mode');
        }
        $('.profiles').fadeIn("slow");
        scrolltocheckout();
        $('.profile_delivery_detail').show();
    }
}

//scroll down to the receipt
function scrolltocheckout(){
    $('html, body').animate({
        scrollTop: $("#cartsz").offset().top
    }, 1000);
}

function calctip(Subtotal, Tax, DeliveryFee){
    if(Subtotal==0){return 0;}
    var tiptype = $("#tip_percent").val();
    Tax = parseFloat(Subtotal * 0.13);
    var total = Number(Subtotal) + Number(Tax.toFixed(2));

    //alert("TOTAL: " + total);

    if (tiptype == "other"){
        var tipvalue = parseFloat($("#tip").val());
    } else {
        var tipvalue = parseFloat(tiptype) * total;
        tipvalue = tipvalue.toFixed(2);
        $("#tip").val(tipvalue);
    }
    console.log("Tip: " + tipvalue);
    return parseFloat(Number(total) + Number(tipvalue) + Number(DeliveryFee));
}

//updates the cart in the header
function updatecart(where){
    console.log("update cart: " + where);
    var total = $(".grandtotal").html();
    $("#cart-header").show();
    $(".cart-header-total").html(total);
    if( !(debugmode || profiletype == 1) ) {
        $("#checkout-btn").addClass("disabled");
    }
    if(total_items != "" && !isNaN(total_items)){
        $(".cart-header-items").html(total_items);
    }

    if( Number(total.replace("$", "")) > 0 ){
        $("#checkout-btn").removeClass("disabled");
        $("#checkout-btn").removeClass("btn-secondary");
        $("#checkout-btn").addClass("btn-primary");
    }

    $(".cart-header-show").hide();
    $(".cart-header-gif").show();
    setTimeout(function(){//add a delay so it's easier to notice
        $(".cart-header-show").show();
        $(".cart-header-gif").hide();
    }, 1000);
}

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

function delivery(action){

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

$(function(){
    //seems to be debug code, as it won't do anything but alert text
    $('.modal').on('hidden',function(){
        alert('blured', "receipt.js 193");
    })

    //appears to recalculate the total when switched from pickup to delivery
    $('.del-goods').live('click', function () {
        log(".del-goods event");
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
        var gtotal = calctip(Number(subtotal), Number(tax), Number(del_fee));
        if(subtotal==0){gtotal=0;}
        gtotal = gtotal.toFixed(2);
        $('div.grandtotal').text(gtotal);
        $('input.grandtotal').val(gtotal);
    });

    //handle add/remove span
    $('.addspan').live('click',function(){
        log("'.addspan click event");
        handlespan(this, true);
    });
    $('.remspan').live('click',function(){
        log("'.remspan click event");
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
        var menu_id = $("#addspan_" + id).parents('.modal').find('.add_menu_profile').attr('id').replace('profilemenu','');
        title[1]= title[1].replace(' x('+qty+")","");
        title[0] = title[0].replace('-'+qty,'');

        var newprice = Number($("#actualprice" + menu_id).val());
        if(dir) {
            qty = Number(qty) + Number(1);
            newprice = newprice + price;
        } else if(qty>0) {
            qty = Number(qty) - Number(1);
            newprice = newprice - price;
        } else {
            return false;
        }
        $("#actualprice" + menu_id).attr("value", newprice);

        $(tthis).parent().find('.span_'+id).html(qty);
        if(qty == 0) {
            chk.removeClass('checked');
            chk.removeAttr('checked');
            chk.prop('checked',false);
            newtitle= title[1];
            //newprice= price;
        } else {
            chk.prop('checked',true);
            chk.attr('checked','checked');
            if(!chk.hasClass('checked')) {
                chk.addClass('checked');
            }
            newtitle= title[1]+" x("+qty+")";
            //newprice= Number(price)*Number(qty);
        }

        //currentprice = calculateprice(tthis, menu_id, 0);
        //currentprice = $(".modalprice" + menu_id).text();
        //console.log("currentprice: " + currentprice);

        //alert(id + " qty " + qty + " <BR> ID: " + menu_id + "<BR> Price " + price + " <BR>currentprice " + currentprice + " newprice " + newprice);

        newtitle = title[0]+"_"+newtitle+"_"+newprice+"_"+title[3];
        newtitle = newtitle.replace(" x(1)","");
        $(tthis).parent().parent().find('.spanextra_'+id).attr('title',newtitle);
        $(tthis).parents('.buttons').find('label.changemodalP').click();
        $(tthis).parents('.buttons').find('label.changemodalP').click();
        if(price!=0) {
            $('.modalprice'+menu_id).html('$'+newprice.toFixed(2));
            showloader();
        }
    }

    //handle the +/- buttons on the receipt
    $('.decrease').live('click', function () {
        log(".decrease event");
        direction(this, false);
    });

    $('.increase').live('click', function () {
        log(".increase event");
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

        var gtotal = calctip(Number(subtotal), Number(tax), Number(del_fee));
        if(subtotal==0){gtotal=0;}
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
        updatecart("direction");
    }

    //not sure what this does
    $('body').on('click','.changemodalP',function(){
        log("'.body click event");
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
