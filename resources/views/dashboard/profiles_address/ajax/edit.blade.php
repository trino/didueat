<?php printfile("views/ajax/addresse_edit.blade.php"); ?>

<div id="message" class="alert alert-danger" style="display: none;">
    <h1 class="block">Error</h1>
</div>

{!! Form::open(array('url' => 'user/addresses/', 'id'=>'addressesEditForm', 'class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}

<div class="form-group row">
    <label class=" col-sm-3">Location Name</label>
    <div class="col-sm-9">
        <input type="text" name="location" class="form-control" placeholder="Location Name" value="{{ (isset($addresse_detail->location))? $addresse_detail->location : old('location') }}">
    </div>
</div>

<?php echo view("common.editaddress", array("addresse_detail" => $addresse_detail, "apartment" => true, "dontinclude" => true)); ?>

<button type="submit" class="btn btn-primary pull-right">Submit</button>
<button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button>

<input type="hidden" name="id" value="{{ (isset($addresse_detail->id))?$addresse_detail->id:'' }}"/>
{!! Form::close() !!}
<div class="clearfix"></div>

<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>-->