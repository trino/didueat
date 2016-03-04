{{ printfile("views/dashboard/notifications_address/ajax/list.blade.php") }}

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-9">
                <h4 class="card-title">
                    Order Notifications
                    <a class="btn btn-primary btn-sm" id="addNew" data-toggle="modal" data-target="#editModel">Add</a>
                </h4>

                <p class="card-subtitle text-muted">Notify me by these methods when I receive an order</p>
            </div>

        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0">
            @if ($recCount > 0)
                <thead>
                    <tr>
                        <th>Enable</th>
                        <th>Notify</th>
                        <th>Note</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
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

                                       if($candisable){
                                           echo '<label class="c-input c-checkbox pull-left">';
                                           echo '<INPUT TYPE="CHECKBOX" ID="add_enable_' . $value->id . '" CLASS="fullcheck" ONCLICK="add_enable(' . $value->id . ');"';
                                           if ($value->enabled) {
                                               echo ' CHECKED';
                                           }
                                           echo '><span class="c-indicator"></span></label>';
                                       } else {
                                           //echo " CHECKED DISABLED";
                                           $value->note = "This is required";
                                       }
                                   ?>

                            </td>

                            <td>{{ $value->type }}: {{ $value->address }}</td>
                            <td id="note_{{ $value->id }}" value="{{ $value->note }}" onclick="editnote({{ $value->id }});">{{ $value->note }}</td>

                            <td>
                                <div class=" pull-right ">
                                    @if (Session::get('session_type_user') == "super")
                                        <a class="btn btn-secondary-outline btn-sm editRow " data-toggle="modal" data-target="#editModel"
                                           data-id="{{ $value->id }}">Edit</a>
                                    @endif
                                    @if($candisable)
                                        <a href="{{ url('notification/addresses/delete/'.$value->id) }}"
                                            class="btn btn-secondary-outline btn-sm"
                                            onclick="return confirm('Are you sure you want to delete {{ addslashes($value->address) }}?');"><i class="fa fa-times"></i></a>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @endforeach
            @else
                <tbody>
                    <tr>
                        <td><span class="text-muted">No Notifcations Yet</span></td>
                    </tr>
            @endif
            </tbody>
        </table>
    </div>

    @if(Session::get('session_type_user') == "super"  && $recCount > 10)
        <div class="card-footer clearfix">
            {!! $Pagination !!}
        </div>
    @endif
</div>