<meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>

<?php printfile("views/ajax/addresse_edit.blade.php"); ?>

<div id="message" class="alert alert-danger" style="display: none;">
    <h1 class="block">Error</h1>
</div>

{!! Form::open(array('url' => 'user/addresses/', 'id'=>'addressesEditForm', 'class'=>'form-horizontal','method'=>'post','role'=>'form', 'autocomplete' => 'false')) !!}

<div class="form-group row">
    <label class=" col-sm-3">Location Name</label>
    <div class="col-sm-9">
        <input type="text" name="location" class="form-control" placeholder="Location Name" value="<?php if(isset($addresse_detail->location)) { echo $addresse_detail->location;} ?>">
    </div>
</div>

<?php echo view("common.editaddress", array("addresse_detail" => $addresse_detail, "apartment" => true, "dontinclude" => true)); ?>

<button type="submit" class="btn btn-primary pull-right">Submit</button>
<button type="button" class="btn btn-secondary pull-right" data-dismiss="modal" TITLE="Close" TITLE="Close">Close</button>

<input type="hidden" name="id" value="{{ (isset($addresse_detail->id))?$addresse_detail->id:'' }}"/>
    {!! Form::close() !!}
<div class="clearfix"></div>