

<input type='hidden' name='hiddenShowDataEntries' id='hiddenShowDataEntries' value='{!! ($per_page)?$per_page:5; !!}' />
<input type='hidden' name='hiddenSearchResult' id='hiddenSearchResult' value='{!! ($searchResults)?$searchResults:""; !!}' />
<input type='hidden' name='hiddenShowMeta' id='hiddenShowMeta' value='{!! ($meta)?$meta:"id"; !!}' />
<input type='hidden' name='hiddenShowOrder' id='hiddenShowOrder' value='{!! ($order)?$order:"ASC"; !!}' />
<input type='hidden' name='hiddenPage' id='hiddenPage' value='{!! ($page)?$page:1; !!}' />

<div id="ajaxBlock"></div>
