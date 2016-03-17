//handles the add_item (not additem) button
$('.add_item').live('click', function () {
    var id = $(this).attr('id').replace('add_item', '');
    if (id == 0) {
        $('.addnew').show();
        $('.addnew').load(base_url + 'restaurant/menu_form/0', function () {
            ajaxuploadbtn('newbrowse0_1');
        });
    } else {
        $('#parent' + id).load(base_url + 'restaurant/menu_form/' + id, function () {
            ajaxuploadbtn('newbrowse' + id + '_1');
        });
    }
});

//handles the additem (not add_item) button
$('.additem').live('click', function () {
    $('.savebtn').remove();
    $('.add_additional').remove();
    var id = $(this).attr('id').replace('add_item', '');
    
    
    if ($("#res_id").length == 0) {
        var res_id = 0;
    } else {
        var res_id = $("#res_id").val();
    }
    if (id == 0) {
        $('.overlay_loader').show();
    }

    $('#menumanager2').load(base_url + 'restaurant/menu_form/' + id + '/' + res_id, function () {
        $('.overlay_loader').hide();
        ajaxuploadbtn('newbrowse' + id + '_1');
        $('#addMenuModel .modal-footer').prepend('<a id="add_additional'+id+'" class="btn btn-secondary-outline  add_additional ignore ignore2 ignore1" href="javascript:void(0)">Advance Addons</a>'+
'<a id="save'+id+'" class="btn  btn-primary savebtn ignore ignore2 ignore1" href="javascript:void(0)">Save</a>');
    });
});

var toggleMenuImgH=true;
function toggleFullSizeMenu(path,imgroot){
 if(toggleMenuImgH){
   var img = new Image();
			img.src = path+"/big-"+imgroot;
   document.getElementById('zoomMsg').innerHTML="Loading...";
			img.onload = function() {
     document.getElementById('zoomMsg').innerHTML="Click Image to Zoom Out";
}
   document.getElementById('menuImage').src=path+"/big-"+imgroot;
   document.getElementById('menuImage').style.left="-16px";
   document.getElementById('menuImage').style.cursor="zoom-out";
   toggleMenuImgH=false;
 }
 else{
   document.getElementById('zoomMsg').innerHTML="Click Image to Zoom";
   document.getElementById('menuImage').src=path+"/small-"+imgroot;
   document.getElementById('menuImage').style.left="0px";
   document.getElementById('menuImage').style.cursor="zoom-in";
   toggleMenuImgH=true;
 } 
////
}

//handles ajax uploading of an image
function ajaxuploadbtn(button_id, doc) {
    var button = $('#' + button_id), interval;
    var act = base_url + 'restaurant/uploadimg';
    new AjaxUpload(button, {
        action: act,
        name: 'myfile',
        data: {'_token': token, 'setSize': 'No'},
        onSubmit: function (file, ext) {
            var thisext = ext.toLowerCase();
            var imgTypes = ['jpg','png','gif','jpeg'];
            if(imgTypes.indexOf(thisext) == -1) {
              alert('Please Upload Only The Following Image Types:\n\njpg, jpeg, png or gif');
              return false;
            }
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
            var resp = response.split('___');
            var path = resp[0];
            var img = resp[1];
                window.clearInterval(interval);
                document.getElementById(button_id).style.display="none";
                document.getElementById('menuImage').style.display="none";
                if(document.getElementById('deleteMenuImg')){
                  document.getElementById('deleteMenuImg').style.display="none";
                }
                document.getElementById('browseMsg').innerHTML="<img src='"+base_url+"assets/images/uploaded-checkbox.png') }}' border='0' />&nbsp;<span class='instruct bd'>Click Save to Finish Uploading</span>";
                this.enable();
                $('.hiddenimg').val(img);

        }
    });
}