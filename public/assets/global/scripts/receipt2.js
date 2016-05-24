var total_items = 0;

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

var checkingout = false;
window.onbeforeunload = function (e) {
    if (total_items && !checkingout && false) { // enable later when were more established
        var message = "You have not finished your order. Leaving this page will empty your cart.", e = e || window.event;
        if (e) {e.returnValue = message;}// For IE and Firefox
        return message;// For Safari
    }
};


function additemtoreceipt(menu_id, ids, pre_cnt, price, csr, app_title, extratitle, dbtitle){
    updatecart("additemtoreceipt " + menu_id + " " + ids + " " + pre_cnt + " " + price + " " + csr + " " + app_title + " " + extratitle + " " + dbtitle);
}