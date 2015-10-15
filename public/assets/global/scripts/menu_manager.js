var path = window.location.pathname;
if(path.replace('didueat','')!=path)
var base_url = 'http://localhost/didueat/public/';
else
var base_url = 'http://didyoueat.ca/';
$('.add_item').live('click',function(){
    var id = $(this).attr('id').replace('add_item','');
    if(id==0){
    $('.addnew').show();
    $('.addnew').load(base_url+'restaurant/menu_form/0',function(){
        ajaxuploadbtn('newbrowse0_1');
    });
    }
    else
    {
    $('#parent'+id).load(base_url+'restaurant/menu_form/'+id,function(){
        ajaxuploadbtn('newbrowse'+id+'_1');
      });  
    }
});
$('.additem').live('click',function(){
    
    var id = $(this).attr('id').replace('add_item','');
    alert(id);
    if(id==0){
    $('.overlay_loader').show();
    $('#menumanager').load(base_url+'restaurant/menu_form/0',function(){
        $('.overlay_loader').hide();
        ajaxuploadbtn('newbrowse0_1');
    });
    }
    else
    {
    $('#parent'+id).load(base_url+'restaurant/menu_form/'+id,function(){
        $('.overlay_loader').hide();
        ajaxuploadbtn('newbrowse'+id+'_1');
      });  
    }
});
var token = '';
            $.ajax({
               url: base_url+'restaurant/getToken',
               success:function(res){
                token = res;
                //alert(token);
                
               // return token;
               } 
            });
            //alert(token);


function ajaxuploadbtn(button_id, doc) {
            
            
            var button = $('#' + button_id), interval;
            act = base_url+'restaurant/uploadimg';
            new AjaxUpload(button, {
                action: act,
                name: 'myfile',
                data:{'_token':token},
                onSubmit: function (file, ext) {
                    button.text('Uploading...');
                    this.disable();
                    interval = window.setInterval(function () {
                        var text = button.text();
                        if (text.length < 13) {
                            button.text(text + '.');
                        } else {
                            button.text('Uploading...');
                        }
                    }, 200);
                },
                onComplete: function (file, response) {
                    //alert(response);return;
                        //alert(response);
                        var resp = response.split('___');
                        var path = resp[0];
                        var img = resp[1];
                        button.html('Browse');
                    
                    window.clearInterval(interval);
                    this.enable();
                    
                        $("."+button_id.replace('newbrowse','menuimg')).html('<img src="'+path+'" /><input type="hidden" class="hiddenimg" value="'+img+'" />');
                        $("."+button_id.replace('newbrowse','menuimg')).attr('style','min-height:0px!important;')
                        //$('#client_img').val(response);
                    
//$('.flashimg').show();
                }
            });
        }
