//handles the add_item (not additem) button
$('.add_item').live('click', function () {
    log(".add_item event");
    var id = $(this).attr('id').replace('add_item', '');
    if (id == 0) {
        $('.addnew').show();
        $('.addnew').load(base_url + 'restaurant/menu_form/0/' + $('.rest_id').val(), function () {
            ajaxuploadbtn('newbrowse0_1');
        });
    } else {
        $('#parent' + id).load(base_url + 'restaurant/menu_form/' + id + '/' + $('.rest_id').val(), function () {
            ajaxuploadbtn('newbrowse' + id + '_1');
        });
    }
});

//handles the additem (not add_item) button
$('.additem').live('click', function () {
    log(".additem event");
    $('.savebtn').remove();
    $('.add_additional').remove();
    $('.loadPrevious').remove();
    var id = $(this).attr('id').replace('add_item', '');


    if ($("#res_id").length == 0) {
        var res_id = 0;
    } else {
        var res_id = $("#res_id").val();
    }
    if (id == 0) {
        overlay_loader_show();
    }

    $('#menumanager2').load(base_url + 'restaurant/menu_form/' + id + '/' + res_id, function () {
        overlay_loader_hide();
        ajaxuploadbtn('newbrowse' + id + '_1');

        $.ajax({
            url: base_url + 'restaurant/alladdons/' + res_id,
            success: function (addons) {
                $('#addMenuModel .modal-footer').prepend('<select class="loadPrevious btn" id="loadPrevious' + id + '" style="max-width: 300px;">' + addons + '</select><a id="add_additional' + id + '" class="btn btn-secondary add_additional ignore ignore2 ignore1" href="javascript:void(0)">Add Addon</a>' +
                    '<a id="save' + id + '" class="btn  btn-primary savebtn ignore ignore2 ignore1" href="javascript:void(0)">Save</a>');
            }
        })


    });
});

var toggleMenuImgH = true;
function toggleFullSizeMenu(path, imgroot) {
    if (toggleMenuImgH) {
        var img = new Image();
        img.src = path + "/big-" + imgroot;
        document.getElementById('zoomMsg').innerHTML = "Loading...";
        img.onload = function () {
            document.getElementById('zoomMsg').innerHTML = "Click Image to Zoom Out";
        }
        document.getElementById('menuImage').src = path + "/big-" + imgroot;
        document.getElementById('menuImage').style.left = "-16px";
        document.getElementById('menuImage').style.cursor = "zoom-out";
        toggleMenuImgH = false;
    }
    else {
        document.getElementById('zoomMsg').innerHTML = "Click Image to Zoom In";
        document.getElementById('menuImage').src = path + "/small-" + imgroot;
        document.getElementById('menuImage').style.left = "0px";
        document.getElementById('menuImage').style.cursor = "zoom-in";
        toggleMenuImgH = true;
    }
////
}

var cntr1 = 0;
function reduceFile(button_id) {

    var msgElem = document.getElementById(button_id).parentNode
    msgElem.childNodes[1].innerHTML = "Uploading...";
    var dataurl = null;
    var preview = document.getElementById('imgPre');
    var file = document.getElementById('photoUpload').files[0];
    var reader = new FileReader();
    var thispath = base_url + '/assets/images/restaurant';

    /*

     var imgName=file.name.toLowerCase()
     imgName=imgName.split(/(\\|\/)/g).pop();
     imgNameSpl=imgName.split(".");
     var imgName=imgNameSpl[0];

     document.getElementById('imgName').value=imgName;

     */

    reader.addEventListener("load", function () {
        preview.src = reader.result;

        preview.onload = function (reader) {

            var canvas = document.createElement("canvas");
            var ctx = canvas.getContext("2d");
            ctx.drawImage(preview, 0, 0);
            var MAX_WIDTH = 600;
            var MAX_HEIGHT = 5000;
            var width = preview.width;
            var height = preview.height;

            if (width > height) {
                if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width;
                    width = MAX_WIDTH;
                }
            } else {
                if (height > MAX_HEIGHT) {
                    width *= MAX_HEIGHT / height;
                    height = MAX_HEIGHT;
                }
            }
            canvas.width = width;
            canvas.height = height;
            var ctx = canvas.getContext("2d");
            ctx.drawImage(preview, 0, 0, width, height);
            dataurl = canvas.toDataURL("image/jpeg");

            if (cntr1 == 0) {
                document.getElementById('imgPre').style.width = width + "px";
                document.getElementById('imgPre').style.height = height + "px";
                document.getElementById('menuImage').style.display = "none"
                document.getElementById('imgPre').src = dataurl;
                document.getElementById('hiddenimg').value = dataurl
                document.getElementById('hiddenimg').readOnly = true;
                msgElem.style.display = "none";
                document.getElementById('imgPre').style.display = "none";
                if (document.getElementById('deleteMenuImg')) {
                    document.getElementById('deleteMenuImg').style.display = "none";
                }
                document.getElementById('browseMsg').innerHTML = "<span class='instruct bd'>Click Save to Finish Uploading</span>";
                document.getElementById('zoomMsg').style.display = "none";
                cntr1++;
                return;
            }

            if (reader.removeEventListener) {
                reader.removeEventListener("load", arguments.callee, false);
            } else if (reader.detachEvent) {
                reader.detachEvent("load", arguments.callee, false);
            }

            return true;

        }
    }, false);

    reader.readAsDataURL(file);


}
/*

 function ajaxuploadbtn(button_id, doc) {
 // remove reference to this in jQuery
 }

 */

//handles ajax uploading of an image
function ajaxuploadbtn(button_id, doc) {
    if (preUpRe) {
        return false;
    }
    var button = $('#' + button_id), interval;
    var act = base_url + 'restaurant/uploadimg';
    new AjaxUpload(button, {
        action: act,
        name: 'myfile',
        data: {'_token': token, 'setSize': 'No'},
        onSubmit: function (file, ext) {
            var thisext = ext.toLowerCase();
            var imgTypes = ['jpg', 'png', 'gif', 'jpeg'];
            if (imgTypes.indexOf(thisext) == -1) {
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
            document.getElementById(button_id).style.display = "none";
            document.getElementById('menuImage').style.display = "none";
            $('#imgName').val(1);
            if (document.getElementById('deleteMenuImg')) {
                document.getElementById('deleteMenuImg').style.display = "none";
            }
            document.getElementById('browseMsg').innerHTML = "<img src='" + base_url + "assets/images/uploaded-checkbox.png' border='0' />&nbsp;<span class='instruct bd'>Click Save to Finish Uploading</span>";
            this.enable();
            $('.hiddenimg').val(img);

        }
    });
}


function deleteMenuItem(catID, menID, bndboxDisplayOrder) {
    // first save menu order changes to db before deleting, so that the new order can be calculated properly

    var thisCatName = "";
    for (var i = 0; i < catOrigPosns.length; i++) {
        if (catOrigPosns[i] == catID) {
            thisCatName = catNameA[i];
            break;
        }
    }

    if (menuSortChngs[catID]) {
        // 1st save with saveMenuOrder(), which will then redirect to deleteMenuItemFn upon finishing save
        if (confirm("Note, this will cause all menu sorting changes you have made to the category " + thisCatName + " this session to be saved. If you do not want this, please click Cancel")) {
            saveMenuOrder(catID, menID, bndboxDisplayOrder);
        }
    }
    else {
        // otherwise, just send directly to delete item
        deleteMenuItemFn(catID, menID, bndboxDisplayOrder, false);
    }

}


function deleteMenuItemFn(catID, menID, bndboxDisplayOrder, fromSaveMenuOrder) {
    // bndboxDisplayOrder is bounding box display order, not the current item's original order

    if (confirm('This will delete the menu item. Do you wish to proceed?\n\nOptionally, you can disable the display of this particular menu item by deselecting the Enable Item checkbox on the menu list.\n\nThis will save the menu item for possible use in the future.')) {

        var thisMenuDisplayOrder = itemPosn[catID][menID]; // the index (display order) to be deleted
        var catMenuCnt = Object.keys(itemPosn[catID]).length;
        var thisURL = base_url + 'restaurant/deleteMenu';

        $.ajax({
            url: thisURL,
            data: 'id=' + menID + '&slug=' + restSlug + '&catID=' + catID + '&thisMenuDisplayOrder=' + thisMenuDisplayOrder + '&catMenuCnt=' + catMenuCnt + '&_token=' + token,
            type: 'post',
            success: function (res) {
                // now delete item and update correct values into JavaScript objects and arrays
                // shift each item up 1

//            document.getElementById('parent'+catID+'_'+thisMenuDisplayOrder).innerHTML="";
//            document.getElementById('parent'+catID+'_'+thisMenuDisplayOrder).style.display="none";


                var itemNewOrder = "";
                var cnt = 1;

                for (var key in itemPosn[catID]) { // itemPosn[catID]=menuID:displayOrder

                    if ((cnt + 1) > catMenuCnt) {

                        // set last item key order Posn before ending loop and deleting last container
                        itemNewOrder = (itemPosn[catID][key] - 1);
                        itemPosn[catID][key] = itemNewOrder; // add updated values this catID and key (menID)
                        itemPosnOrig[catID][key] = itemNewOrder;

                        // means last item in active list, which will now be set to hidden and empty (ie, deleted)
                        document.getElementById('parent' + catID + '_' + catMenuCnt).innerHTML = "";
                        document.getElementById('parent' + catID + '_' + catMenuCnt).style.display = "none";

                        // clear this posn in the object
                        delete itemPosn[catID][menID];
                        delete itemPosnOrig[catID][menID];

                        break;
                    }

//           alert("cnt:  "+cnt+"  --  "+itemPosn[catID][key] +"  --  "+ thisMenuDisplayOrder)
                    if (itemPosn[catID][key] >= thisMenuDisplayOrder) {
                        var oneHigher = (itemPosn[catID][key] + 1);

//alert("Is "+itemPosn[catID][key] +" > "+ thisMenuDisplayOrder + "  --  oneHigher: "+oneHigher)
                        if (document.getElementById('parent' + catID + '_' + oneHigher)) {
                            document.getElementById('parent' + catID + '_' + itemPosn[catID][key]).innerHTML = document.getElementById('parent' + catID + '_' + oneHigher).innerHTML;
                        }

                        if ((cnt + 1) == catMenuCnt) {
                            // meaning last one to display, so remove down array
                            document.getElementById('down_parent_' + key + "_" + catID).style.visibility = "hidden";
                        }
                        if (cnt == thisMenuDisplayOrder && document.getElementById('up_parent_' + key + "_" + catID)) {
                            // means this is the first posn, and previous item was deleted, so remove up arrow
                            document.getElementById('up_parent_' + key + "_" + catID).style.visibility = "hidden";
                        }

                        itemNewOrder = (itemPosn[catID][key] - 1);

                    }
                    else {
                        itemNewOrder = itemPosn[catID][key]; // unchanged
                    }
//               alert("New item order:  "+itemNewOrder)
                    if (key != menID) {
                        itemPosn[catID][key] = itemNewOrder; // add updated values this catID and key (menID)
                        itemPosnOrig[catID][key] = itemNewOrder;
                    }

                    cnt++;
                }

                /*
                 itemPosn[catID] = temp_itemPosnObj; // add updated values back to this catID index
                 itemPosnOrig[catID] = temp_itemPosnObj;
                 itemPosn[cat][id2]=currentItemPosn1;
                 itemPosn[cat][id]=currentItemPosn2;
                 */

                if (fromSaveMenuOrder) {
                    menuSortChngs[catID] = false;
                    timer2 = setTimeout("hideMenuOrderMsg(" + catID + ")", 250);
                }

            }
        });

// window.location = base_url + 'restaurant/deleteMenu/' + menID + '/' + restSlug + '/'  + thisMenuDisplayOrder + '/' + catMenuCnt;

    }
    else {
        return false;
    }


////
}


function hideMenuOrderMsg(indx) {
    if (document.getElementById('saveMenuOrderMsg' + indx)) {
        document.getElementById('saveMenuOrderMsg' + indx).innerHTML = "";
    }
    if (document.getElementById('saveMenus' + indx)) {
        document.getElementById('saveMenus' + indx).style.display = "none"
    }
    ;
    clearTimeout(timer2);
////
}

function hideCatOrderMsg(indx) {
    document.getElementById('saveCatOrderMsg' + indx).innerHTML = "";
    document.getElementById('saveCatOrderMsg').innerHTML = "";
    if (indx != "") {
        document.getElementById('save' + indx).style.display = "none";
    }
    document.getElementById('saveOrderChngBtn').style.display = "none";
    clearTimeout(timer1);
////
}


function dump(v, howDisplay, recursionLevel) {
    howDisplay = (typeof howDisplay === 'undefined') ? "alert" : howDisplay;
    recursionLevel = (typeof recursionLevel !== 'number') ? 0 : recursionLevel;


    var vType = typeof v;
    var out = vType;

    switch (vType) {
        case "number":
        /* there is absolutely no way in JS to distinguish 2 from 2.0
         so 'number' is the best that you can do. The following doesn't work:
         var er = /^[0-9]+$/;
         if (!isNaN(v) && v % 1 === 0 && er.test(3.0))
         out = 'int';*/
        case "boolean":
            out += ": " + v;
            break;
        case "string":
            out += "(" + v.length + '): "' + v + '"';
            break;
        case "object":
            //check if null
            if (v === null) {
                out = "null";

            }
            //If using jQuery: if ($.isArray(v))
            //If using IE: if (isArray(v))
            //this should work for all browsers according to the ECMAScript standard:
            else if (Object.prototype.toString.call(v) === '[object Array]') {
                out = 'array(' + v.length + '): {\n';
                for (var i = 0; i < v.length; i++) {
                    out += repeatString('   ', recursionLevel) + "   [" + i + "]:  " +
                        dump(v[i], "none", recursionLevel + 1) + "\n";
                }
                out += repeatString('   ', recursionLevel) + "}";
            }
            else { //if object    
                sContents = "{\n";
                cnt = 0;
                for (var member in v) {
                    //No way to know the original data type of member, since JS
                    //always converts it to a string and no other way to parse objects.
                    sContents += repeatString('   ', recursionLevel) + "   " + member +
                        ":  " + dump(v[member], "none", recursionLevel + 1) + "\n";
                    cnt++;
                }
                sContents += repeatString('   ', recursionLevel) + "}";
                out += "(" + cnt + "): " + sContents;
            }
            break;
    }

    if (howDisplay == 'body') {
        var pre = document.createElement('pre');
        pre.innerHTML = out;
        document.body.appendChild(pre)
    }
    else if (howDisplay == 'alert') {
        alert(out);
    }

    return out;
}

function repeatString(str, num) {
    out = '';
    for (var i = 0; i < num; i++) {
        out += str;
    }
    return out;
}


timer2 = "";
function saveMenuOrder(catID, menID, bndboxDisplayOrder) {

    var newMenuOrder = "";
    var catNameAIndx = "";
    for (var i = 0; i < catOrigPosns.length; i++) {
        if (catOrigPosns[i] == catID) {
            catNameAIndx = i;
            break;
        }
    }
    var catName = catNameA[catNameAIndx];

    var itemPosnCnt = 0;
    for (var key in itemPosn[catID]) { // [catID]={menuID:displayOrder}
        comma = ",";
        if (itemPosnCnt == 0) {
            comma = "";
        }
        newMenuOrder += comma + key + ":" + itemPosn[catID][key];  // string with comma delimited menuID:displayOrder
        itemPosnCnt++;
    }


    $.ajax({
        url: base_url + 'restaurant/menuOrderSort',
        data: 'newMenuOrder=' + newMenuOrder + '&_token=' + token,
        type: 'post',
        success: function (res) {

            document.getElementById('saveMenus' + catID).style.display = "none";
            document.getElementById('saveMenuOrderMsg' + catID).innerHTML = " <br/>Your menu sort order has been saved for " + catName;


            if (menID != false) {
                // on successfully updating menus, we can now delete the item that called this fn:
                deleteMenuItemFn(catID, menID, bndboxDisplayOrder, true); // true means it's from saveMenuOrder()
            }
            else {
                menuSortChngs[catID] = false;
                timer2 = setTimeout("hideMenuOrderMsg(" + catID + ")", 250);
            }
        }
    });
////
}

timer1 = "";
function saveCatOrderChngs(indx) {
    var newCatOrder = "";

    for (var i = 0; i < catPosns.length; i++) {
        comma = ",";
        if (i == 0) {
            comma = "";
        }
        newCatOrder += comma + catOrigPosns[i] + ":" + catPosns[i];
    }

    $.ajax({
        url: base_url + 'restaurant/menuCatSort',
        data: 'newCatOrder=' + newCatOrder + '&_token=' + token,
        type: 'post',
        success: function (res) {
            for (var i = 0; i < catPosns.length; i++) { // reset save order button for all
                document.getElementById('save' + i).style.display = "none";
            }
            if (indx != "") {
                document.getElementById('saveCatOrderMsg' + indx).innerHTML = " <br/>Your category sort order has been saved";
            }
            else {
                document.getElementById('saveCatOrderMsg').innerHTML = " <br/>Your category sort order has been saved";
            }

            timer1 = setTimeout("hideCatOrderMsg(" + indx + ")", 250);

            catSortChngs = false;
        }
    });

////
}

// menuSortChngs array set on menus.blade page
function menuItemSort(id, cat, displayOrder, direction, catMenuCnt) {
//  alert(id +"  --  "+ cat+"  --  "+ displayOrder+"  --  "+ direction+"  --  "+catMenuCnt)

    currentItemPosn1 = itemPosn[cat][id];

    (direction == "down") ? currentItemPosn2 = (currentItemPosn1 + 1) : currentItemPosn2 = (currentItemPosn1 - 1);

    var id2 = "";
    for (var key in itemPosn[cat]) {
        if (itemPosn[cat][key] == currentItemPosn2) {
            id2 = key;
            break;
        }
    }

    var tempHTML1 = document.getElementById('parent' + cat + '_' + currentItemPosn1).innerHTML;
    var tempHTML2 = document.getElementById('parent' + cat + '_' + currentItemPosn2).innerHTML;
    var tempUpVisib1 = document.getElementById('up_parent_' + id + "_" + cat).style.visibility;
    var tempDownVisib1 = document.getElementById('down_parent_' + id + "_" + cat).style.visibility;
    var tempUpVisib2 = document.getElementById('up_parent_' + id2 + "_" + cat).style.visibility;
    var tempDownVisib2 = document.getElementById('down_parent_' + id2 + "_" + cat).style.visibility;

    document.getElementById('parent' + cat + '_' + currentItemPosn1).innerHTML = tempHTML2;
    document.getElementById('parent' + cat + '_' + currentItemPosn2).innerHTML = tempHTML1;

    itemPosn[cat][id2] = currentItemPosn1;
    itemPosn[cat][id] = currentItemPosn2;

// now that the categories have moved, flip the up/down arrows according to new position
    document.getElementById('up_parent_' + id + "_" + cat).style.visibility = tempUpVisib2;
    document.getElementById('down_parent_' + id + "_" + cat).style.visibility = tempDownVisib2;
    document.getElementById('up_parent_' + id2 + "_" + cat).style.visibility = tempUpVisib1;
    document.getElementById('down_parent_' + id2 + "_" + cat).style.visibility = tempDownVisib1;


    document.getElementById('saveMenus' + cat).style.display = "block";

    menuSortChngs[cat] = true;


////
}

catSortChngs = false;
function chngCatPosn(thisIndx1, direction) {
    // since display permits only permissisable moves where up or down is possible, we don't need to test the index before applying function

    var currentOrderPosn1 = catPosns[thisIndx1]; // thisIndx represents original assignment from $thisCatCnt

    (direction == "down") ? currentOrderPosn2 = (currentOrderPosn1 + 1) : currentOrderPosn2 = (currentOrderPosn1 - 1);

    var thisIndx2 = "";
    for (var i = 0; i < catPosns.length; i++) {
        if (catPosns[i] == currentOrderPosn2) {
            thisIndx2 = i; // thisIndx2 represents original assignment from $thisCatCnt
            break;
        }
    }
//  alert(currentOrderPosn1+": "+thisIndx1+"  --  "+currentOrderPosn2+": "+thisIndx2)

    var tempHTML1 = document.getElementById('c' + currentOrderPosn1).innerHTML;
    var tempHTML2 = document.getElementById('c' + currentOrderPosn2).innerHTML;
    var tempUpVisib1 = document.getElementById('up' + thisIndx1).style.visibility;
    var tempDownVisib1 = document.getElementById('down' + thisIndx1).style.visibility;
    var tempUpVisib2 = document.getElementById('up' + thisIndx2).style.visibility;
    var tempDownVisib2 = document.getElementById('down' + thisIndx2).style.visibility;

    document.getElementById('c' + currentOrderPosn1).innerHTML = tempHTML2;
    document.getElementById('c' + currentOrderPosn2).innerHTML = tempHTML1;

    catPosns[thisIndx2] = currentOrderPosn1;
    catPosns[thisIndx1] = currentOrderPosn2;

// now that the categories have moved, flip the up/down arrows according to new position
    document.getElementById('up' + thisIndx1).style.visibility = tempUpVisib2;
    document.getElementById('down' + thisIndx1).style.visibility = tempDownVisib2;
    document.getElementById('up' + thisIndx2).style.visibility = tempUpVisib1;
    document.getElementById('down' + thisIndx2).style.visibility = tempDownVisib1;

    document.getElementById('saveOrderChngBtn').style.display = "block";
    document.getElementById('save' + thisIndx1).style.display = "block";
    document.getElementById('save' + thisIndx2).style.display = "block";

    catSortChngs = true;

////
}