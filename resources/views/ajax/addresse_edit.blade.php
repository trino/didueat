<meta name="_token" content="{{ csrf_token() }}"/>

<?php printfile("views/ajax/addresse_edit.blade.php"); ?>

<div id="message" class="alert alert-danger" style="display: none;">
    <h1 class="block">Error</h1>
</div>

{!! Form::open(array('url' => 'user/addresses/', 'id'=>'addressesEditForm', 'class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}

<div class="form-group row">
    <label class=" col-sm-3">Location Name</label>
    <div class="col-sm-9">
        <input type="text" name="location" class="form-control" placeholder="Location Name" value="<?php if(isset($addresse_detail->location)) { echo $addresse_detail->location;} ?>">
    </div>
</div>

<?php echo view("common.editaddress", array("addresse_detail" => $addresse_detail)); ?>

<div class="form-group row">
    <label class=" col-sm-3">Apartment </label>
    <div class="col-sm-9">
        <input type="text" name="apartment" class="form-control" placeholder="Apartment" value="{{ (isset($addresse_detail->apartment))?$addresse_detail->apartment:'' }}" required>
    </div>
</div>

<div class="form-group row">
    <label class=" col-sm-3">Buzz Code </label>
    <div class="col-sm-9">
        <input type="text" name="buzz" class="form-control" placeholder="Buzz Code" value="{{ (isset($addresse_detail->buzz))?$addresse_detail->buzz:'' }}" required>
    </div>
</div>

<button type="submit" class="btn btn-primary pull-right">Submit</button>
<button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button>

<input type="hidden" name="id" value="{{ (isset($addresse_detail->id))?$addresse_detail->id:'' }}"/>
    {!! Form::close() !!}
<div class="clearfix"></div>