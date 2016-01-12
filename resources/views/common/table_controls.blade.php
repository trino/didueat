<!--div class="col-lg-3">
    <select size="1" name="showDataEntries" id="showDataEntries" class="form-control">
        <option value="10" {!! ($per_page == 10)?"selected":''; !!}>10</option>
        <option value="25" {!! ($per_page == 25)?"selected":''; !!}>25</option>
        <option value="50" {!! ($per_page == 50)?"selected":''; !!}>50</option>
        <option value="100" {!! ($per_page == 100)?"selected":''; !!}>100</option>
        <option value="300" {!! ($per_page == 300)?"selected":''; !!}>300</option>
        <option value="500" {!! ($per_page == 500)?"selected":''; !!}>500</option>
        <option value="1000" {!! ($per_page == 1000)?"selected":''; !!}>1000</option>
    </select>
</div-->
<div class="col-lg-3">

    <?php printfile("views/common/table_controls.blade.php"); ?>


    <input type="text" class="form-control" id='searchResult' value='<?php echo $searchResults; ?>' placeholder='Search...' autofocus='true' style=""/>
</div>

<input type='hidden' name='hiddenShowDataEntries' id='hiddenShowDataEntries' value='{!! ($per_page)?$per_page:5; !!}' />
<input type='hidden' name='hiddenSearchResult' id='hiddenSearchResult' value='{!! ($searchResults)?$searchResults:""; !!}' />
<input type='hidden' name='hiddenShowMeta' id='hiddenShowMeta' value='{!! ($meta)?$meta:"id"; !!}' />
<input type='hidden' name='hiddenShowOrder' id='hiddenShowOrder' value='{!! ($order)?$order:"ASC"; !!}' />
<input type='hidden' name='hiddenPage' id='hiddenPage' value='{!! ($page)?$page:1; !!}' />

<div id="ajaxBlock"></div>
