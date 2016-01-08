
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
    }

    function clearCartItems() {
        $('.receipt_main ul.orders li').remove();
        $('.subtotal').val(0);
        $('.subtotal').text('0');
        $('.tax').val(0);
        $('.tax').text('0');
        $('.df').val(0);
        $('.df').text('0');
        $('#delivery_flag').val(0);
        $('.grandtotal').val(0);
        $('.grandtotal').text('0');
    }

    function checkout() {
        var del = $('#delivery_flag').val();

        if ($('.subtotal').text() == '0' || $('#subtotal1').val() == '0') {
            alert('Please select an item.');
        } else {
            $('.receipt_main').hide();
            $('.profiles').show();
        }
    }

    function delivery(t) {
        var df = $('input.df').val();
        if (t == 'show') {
            $('#df').show();
            $('.profile_delevery_type').text('Delivery Detail');
            $('.profile_delivery_detail').show();
            $('.profile_delivery_detail input').each(function () {
                $(this).attr('required', 'required');
            });
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
            $('.profile_delevery_type').text('Pickup Detail');
            $('.profile_delivery_detail').hide();
            if ($('#pickup1').hasClass("deliverychecked")) {
                //alert('sss');
            } else {
                var grandtotal = $('input.grandtotal').val();
                grandtotal = Number(grandtotal) - Number(df);
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
            var id = $(this).attr('id').replace('addspan_','');
            var qty = Number($(this).parent().find('.span_'+id).text());
            
            var price  = Number($('.span_'+id).attr('id').replace('sprice_',""));
            var chk = $(this).parent().parent().find('#extra_'+id);
            chk.attr('checked','checked');
            var tit = chk.attr('title');
            var title = tit.split("_");
            title[1]= title[1].replace(' x('+qty+")","");
            //alert(id+","+qty+","+price+","+tit);
            qty = Number(qty)+ Number(1);
            $(this).parent().find('.span_'+id).html('&nbsp;&nbsp;'+qty+'&nbsp;&nbsp;');
            if(qty ==0)
            {
                newtitle= title[1];
                newprice= price;
                
            }
            else
            {
                newtitle= title[1]+" x("+qty+")";
                newprice= Number(price)*Number(qty);
                
            }
            
            newtitle = title[0]+"_"+newtitle+"_"+newprice+"_"+title[3];
            newtitle = newtitle.replace(" x(1)","");
            //alert(newtitle);
            $(this).parent().parent().find('.spanextra_'+id).attr('title',newtitle)
        });
        $('.remspan').live('click',function(){
            
            var id = $(this).attr('id').replace('remspan_','');
            var qty = Number($(this).parent().find('.span_'+id).text());
            var price  = Number($('.span_'+id).attr('id').replace('sprice_',""));
            var chk = $(this).parent().parent().find('#extra_'+id)
            var tit = chk.attr('title');
            var title = tit.split("_");
            if(qty !=0)
            {
                title[1]= title[1].replace('x('+qty+")","")
                qty = Number(qty) -Number(1);
                $(this).parent().find('.span_'+id).html('&nbsp;&nbsp;'+qty+'&nbsp;&nbsp;');
            }
            if(qty ==0)
            {
                chk.removeAttr('checked');
                newtitle = title[1];
                newprice = price;
                
                
            }
            else
            {
                newtitle= title[1]+" x("+qty+")";
                newprice= Number(price)*Number(qty);
                
            }
            
            newtitle = title[0]+"_"+newtitle+"_"+newprice+"_"+title[3];
            newtitle = newtitle.replace(" x(1)","");
            //alert(newtitle);
            $(this).parent().parent().find('.spanextra_'+id).attr('title',newtitle) 
        });
        
        $('.decrease').live('click', function () {
        //alert('test');
        var menuid = $(this).attr('id');
        var numid = menuid.replace('dec', '');

        var quant = $('#list' + numid + ' span.count').text();
        quant = quant.replace('x ', '');

        var amount = $('#list' + numid + ' .amount').text();
        amount = parseFloat(amount);

        var subtotal = 0;
        $('.total').each(function () {
            var sub = $(this).text().replace('$', '');
            subtotal = Number(subtotal) + Number(sub);
        })
        subtotal = parseFloat(subtotal);
        subtotal = Number(subtotal) - Number(amount);
        subtotal = subtotal.toFixed(2);
        $('div.subtotal').text(subtotal);
        $('input.subtotal').val(subtotal);

        var tax = $('#tax').text();
        var tax = 13;
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

        var total = $('#list' + numid + ' .total').text();
        total = total.replace("$", "");
        total = parseFloat(total);
        total = Number(total) - Number(amount);
        total = total.toFixed(2);
        $('#list' + numid + ' .total').text('$' + total);

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
            $('#list' + numid + ' span.count').text('x ' + quant);
            $('#list' + numid + ' input.count').val(quant);
            //$('#list'+numid+' .count').val(quant-1);
        }
    });

    $('.increase').live('click', function () {
        var menuid = $(this).attr('id');
        var numid = menuid.replace('inc', '');
        var quant = '';
        quant = $('#list' + numid + ' span.count').text();
        quant = quant.replace('x ', '');
        quant = parseFloat(quant);
        var amount = $('#list' + numid + ' .amount').text();
        amount = parseFloat(amount);
        var subtotal = $('.subtotal').text();
        subtotal = parseFloat(subtotal);
        subtotal = Number(subtotal) + Number(amount);
        subtotal = subtotal.toFixed(2);
        $('div.subtotal').text(subtotal);
        $('input.subtotal').val(subtotal);
        //var tax = $('#tax').text();
        var tax = 13;
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
        var total = $('#list' + numid + ' .total').text();
        total = total.replace("$", "");
        total = parseFloat(total);
        total = Number(total) + Number(amount);
        total = total.toFixed(2);
        $('#list' + numid + ' .total').text('$' + total);
        quant++;
        $('#list' + numid + ' span.count').text('x ' + quant);
        $('#list' + numid + ' input.count').val(quant);
    });
        
    })
    