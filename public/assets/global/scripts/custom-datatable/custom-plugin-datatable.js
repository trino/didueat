loadData(page, '', '', showEntries, '', '');

$('body').on('click', 'ul.pagination li.clickable', function(){
    var page = $(this).attr('p');
    var meta = $('#hiddenShowMeta').val();
    var order = $('#hiddenShowOrder').val();
    var showEntries = $('#hiddenShowDataEntries').val();
    var searchResults = $('#hiddenSearchResult').val();
    var message = "You are at Pagination No [<b>"+page+"</b>]";
    loadData(page, meta, order, showEntries, searchResults, message);
    //loadData(page, meta, order, showEntries, '');
});

$('body').on('click', '.sortOrder', function(){
    var meta = $(this).attr('data-meta');
    var order = $(this).attr('data-order');
    var title = $(this).attr('data-title');
    var showEntries = $('#hiddenShowDataEntries').val();
    var searchResults = $('#hiddenSearchResult').val();
    var page = 1;//$('#hiddenPage').val();
    var message = "[<b>"+title+"</b>] Order Changed To [<b>"+order+"</b>]";
    loadData(page, meta, order, showEntries, searchResults, message);
    //loadData(page, meta, order, showEntries, '');
    //alert(order);
});

$('body').on('change', '#showDataEntries', function(){
    var showEntries = $(this).val();
    var searchResults = $('#searchResult').val();
    var searchResults = $('#hiddenSearchResult').val();
    var meta = $('#hiddenShowMeta').val();
    var order = $('#hiddenShowOrder').val();
    var page = 1;//$('#hiddenPage').val();
    var message = "Entries Showing [<b>"+showEntries+"</b>]";
    loadData(page, meta, order, showEntries, searchResults, message);
    //loadData(page, meta, order, showEntries, '');
    //alert(value);
});

$('body').on('keyup', '#searchResult', function(e){
    var searchResults = $(this).val();
    var showEntries = $('#hiddenShowDataEntries').val();
    var meta = $('#hiddenShowMeta').val();
    var order = $('#hiddenShowOrder').val();
    var page = 1;//$('#hiddenPage').val();

    var code = (e.keyCode ? e.keyCode : e.which);
    if(code == 13) {
        var message = "[<b>"+searchResults+"</b>] Keyword Searched";
        loadData(page, meta, order, showEntries, searchResults, message);
        //alert(showEntries);
    }
});

function loading_show(){
    //$('#loadPageData #ajaxloader').fadeIn('fast');
    $('.overlay_loader').show();
}
function loading_hide(){
    //$('#loadPageData #ajaxloader').fadeOut('fast');
    $('.overlay_loader').hide();
}

function block_show(){
   /* $('#loadPageData #ajaxBlock').block({ 
        message: '<h1>Processing ...</h1>', 
        css: { 
            width: '40%', 
            left: '250px', 
            border: '2px solid #5bc0de', 
            padding: '15px', 
            backgroundColor: '#0275d8', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: 1, 
            color: '#fff'
        }
    });*/
    $('.overlay_loader').show();
}

function block_hide(){
    //$('#loadPageData #ajaxBlock').unblock();
    $('.overlay_loader').hide(); 
}

function reloadData(page, meta, order, showEntries, searchResults, message){ 
    loading_show();
    $.ajax
    ({
        type: "POST",
        url: pageUrlLoad,
        data: "page="+page+"&meta="+meta+"&order="+order+"&showEntries="+showEntries+"&searchResults="+searchResults+"&message="+message+"&_token="+$('meta[name=_token]').attr('content'),
        success: function(response){
            $("#loadPageData").html(response);
            loading_hide();
        }
    });
}

function loadData(page, meta, order, showEntries, searchResults, message){
    loading_show()
    block_show();
    $.ajax
    ({
        type: "POST",
        url: pageUrlLoad,
        data: "page="+page+"&meta="+meta+"&order="+order+"&showEntries="+showEntries+"&searchResults="+searchResults+"&message="+message+"&_token="+$('meta[name=_token]').attr('content'),
        success: function(response){
            $("#loadPageData").html(response);
            block_hide();
            loading_hide();
        }
    });
}