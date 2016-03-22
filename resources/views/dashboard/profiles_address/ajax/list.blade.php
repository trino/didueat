<?php
    printfile("views/dashboard/profiles_address/ajax/list.blade.php");
    $alts = array(
            "addnew" => "Create a new address",
            "moveup" => "Move this address up 1 spot",
            "movedown" => "Move this address down 1 spot",
            "edit" => "Edit this address",
            "delete" => "Delete this address"
    );
?>

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header ">
        <div class="row">
            <div class="col-lg-9">
                <h4 class="card-title">
                    Delivery Address
                    <a class="btn btn-primary btn-sm addNew" title="{{ $alts["addnew"] }}" id="addNew" data-toggle="modal" data-addOrEdit="add" data-target="#editModel">Add</a>
                </h4>
            </div>
            @if (Session::get('session_type_user') == "super" && $recCount > 10)
                @include('common.table_controls')
            @endif
        </div>
    </div>


    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0">
            @if (Session::get('session_type_user') == "super" && $recCount > 10)
                <thead>
                    <tr>
                        @if($recCount > 1)
                            <th>ID</th>
                        @endif
                        <th>Location</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
            @endif
            <tbody>
            @if($recCount > 0)
                @foreach($Query as $key => $value)
                    <tr class="rows" data-id="{{ $value->id }}" data-order="{{ $key }}" id="address{{ $value->id }}">
                        @if($recCount > 1)
                            <td style="min-width: 100px;">{{ $key+1 }}
                                <div class="btn-group-vertical">
                                    <a class="btn btn-secondary-outline up btn-sm" title="{{ $alts["moveup"] }}"><i class="fa fa-arrow-up"></i></a>
                                    <a class="btn btn-secondary-outline down btn-sm" title="{{ $alts["movedown"] }}"><i class="fa fa-arrow-down"></i></a>
                                </div>
                            </td>
                        @endif

                        <td>
                            <?php
                                (isset($value->apartment) && strlen($value->apartment) > 0) ? $aptV = "Apt " . $value->apartment . ", " : $aptV = "";
                                if (isset($value->notes) && $value->notes!='') {
                                    echo '<b>' . $value->notes . '</b><br>';
                                }
                            ?>
                            {{ $value->address . ', ' . $aptV . $value->city . ', ' . $value->province . ', ' . $value->postal_code }}
                        </td>

                        <td>
                            <div class="btn-group">
                            <button data-id="{{ $value->id }}" data-user_id="{{ $value->user_id }}" data-addOrEdit="edit" class="btn btn-secondary-outline editRow btn-sm" data-toggle="modal"
                               data-target="#editModel" title="{{ $alts["edit"] }}"><strong>Edit</strong></button>
                            <!--A href="{{ url('user/addresses/delete/' . $value->id) }}"
                               class="btn btn-secondary-outline btn-sm"
                               onclick="return confirm('Are you sure you want to delete {{ addslashes($value->address) }}?');"><i class="fa fa-times"></i></A>
                            </div-->
                                <A class="btn btn-secondary-outline btn-sm" title="{{ $alts["delete"] }}"
                                   onclick="deleteaddress('{{ $value->id }}', '{{ addslashes($value->address) }}');">
                                    <i id="delete{{ $value->id }}" class="fa fa-times"></i>
                                </A>
                            </div>
                        </td>

                    </tr>
                @endforeach
            @endif
            <tr ID="noaddresses" @if($recCount > 0) style="display: none;" @endif >
                <td><span class="text-muted">No delivery addresses</span></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<SCRIPT>
    var Addresses = '{{ $recCount }}';
    function deleteaddress(ID, Name){
        if(confirm('Are you sure you want to delete address "' + Name + '"?')) {
            $("#delete" + ID).attr('class', "fa fa-spinner fa-spin");
            $.post("{{ url('user/addresses/delete') }}/" + ID, {_token: "{{ csrf_token() }}"}, function (result) {
                Addresses=Addresses-1;
                $("#address" + ID).fadeOut();
                if(Addresses == 0) {
                    $("#noaddresses").fadeIn();
                }
            });
        }
    }
</SCRIPT>