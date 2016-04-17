<?php
    printfile("views/dashboard/notifications_address/ajax/list.blade.php");
    $alts = array(
            "add" => "Add a notification method",
            "edit" => "Edit this notification method",
            "delete" => "Delete this notification method"
    );
?>

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-9">
                <h4 class="card-title">
                    Notification Methods
                    <a class="btn btn-primary btn-sm" id="addNew" data-toggle="modal" data-target="#editModel" title="{{ $alts["add"] }}">Add</a>
                </h4>

                <p class="card-subtitle text-muted">Notify me by these methods when I receive an order</p>
            </div>

        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0">
            <thead>
                <tr>
                    <th>Enable</th>
                    <th>Notify</th>
                    <th>Note</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($recCount == 0){
                        echo '<tr><td colspan="4"><span class="text-muted">No Notifcations Methods Yet. Defaulting to:</span></td></tr>';
                        $Query = array(array_to_object(array("id" => 0, "type" => "Email", "address" => $restaurant->email )));
                    }
                ?>
                @foreach($Query as $key => $value)
                    <tr class="rows" data-id="{{ $value->id }}" data-order="{{ $key }}">
                        <!--td style="min-width: 100px;">{{ $key+1 }}
                            @if($recCount > 1)
                                &nbsp;
                                <div class="btn-group-vertical">
                                    <a class="btn btn-secondary-outline up btn-sm"><i class="fa fa-arrow-up"></i></a>
                                    <a class="btn btn-secondary-outline down btn-sm"><i
                                                class="fa fa-arrow-down"></i></a>
                                </div>
                            @endif
                        </td-->

                        <td class="text-xs-center">
                           <?php
                               $candisable = true;
                               foreach(array("email", "phone", "mobile") as $field){
                                   if($value->address == $restaurant->$field){
                                       $candisable = false;
                                       break;
                                   }
                               }

                               echo '<label class="c-input c-checkbox pull-left"><INPUT TYPE="CHECKBOX" ID="add_enable_' . $value->id . '" CLASS="fullcheck"';
                               if($candisable){
                                   echo ' ONCLICK="add_enable(' . $value->id . ');"';
                                   if (isset($value->enabled) && $value->enabled) {

                                       echo ' CHECKED';
                                   }
                               } else {
                                   echo " CHECKED DISABLED";
                                   $value->note = "This is required";
                               }
                               echo '><span class="c-indicator"></span></label>';

                               if($value->type != "Email"){
                                   $value->address = phonenumber($value->address, true);
                               }
                           ?>
                        </td>

                        <td>{{ $value->type }}: {{ $value->address }}</td>
                        <td id="note_{{ $value->id }}" value="{{ $value->note }}" onclick="editnote({{ $value->id }});">{{ $value->note }}</td>

                        <td>
                            <div class=" pull-right ">
                                @if (Session::get('session_type_user') == "super" && $value->id)
                                    <a class="btn btn-secondary-outline btn-sm editRow " data-toggle="modal" data-target="#editModel" title="{{ $alts["edit"] }}" data-id="{{ $value->id }}">Edit</a>
                                @endif
                                @if($candisable)
                                    <a href="{{ url('notification/addresses/delete/'.$value->id) }}" class="btn btn-secondary-outline btn-sm" title="{{ $alts["delete"] }}"
                                        onclick="return confirm('Are you sure you want to delete {{ addslashes($value->address) }}?');"><i class="fa fa-times"></i></a>
                                @endif
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(Session::get('session_type_user') == "super"  && $recCount > 10)
        <div class="card-footer clearfix">
            {!! $Pagination !!}
        </div>
    @endif
</div>