<?php
    printfile("views/dashboard/user/ajax/list.blade.php");
    $restaurants = enum_all("restaurants");
    $alts = array(
            "possess" => "Log in as this user",
            "delete" => "Delete this user",
            "plus" => "If checked, this user can upload menus"
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
                    Users
                    <!--a class="btn btn-primary btn-sm" id="addNew" data-toggle="modal" data-id="0" data-target="#editModel">Add</a-->
                </h4>
            </div>
            @include('common.table_controls')
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0 ">
            @if($recCount > 0)
                <thead>
                    <tr>  <th></th>
                        <th>
                            <a class="sortOrder" data-meta="id" data-order="ASC" data-title="ID" title="Sort [ID] ASC"><i class="fa fa-caret-down"></i></a>
                            ID
                            <a class="sortOrder" data-meta="id" data-order="DESC" data-title="ID" title="Sort [ID] DESC"><i class="fa fa-caret-up"></i></a>
                        </th>
                        <th >
                            <a class="sortOrder" data-meta="name" data-order="ASC" data-title="Name" title="Sort [Name] ASC"><i class="fa fa-caret-down"></i></a>
                            Name
                            <a class="sortOrder" data-meta="name" data-order="DESC" data-title="Name" title="Sort [Name] DESC"><i class="fa fa-caret-up"></i></a>
                        </th>                        <TH>Type</TH>

                        <th >
                            <a class="sortOrder" data-meta="name" data-order="ASC" data-title="Name" title="Sort [Name] ASC"><i class="fa fa-caret-down"></i></a>
                            Restaurant
                            <a class="sortOrder" data-meta="name" data-order="DESC" data-title="Name" title="Sort [Name] DESC"><i class="fa fa-caret-up"></i></a>
                        </th>
                        <th>
                            Phone Number
                        </th>
                        <th>
                            Email
                        </th>

                    </tr>
                </thead>
            @endif
            <tbody>
            @if($recCount > 0)


                @foreach($Query as $key => $value)

                    <?php
                        $Addresses = select_field_where("profiles_addresses", array("user_id" => $value->id, 'CHAR_LENGTH(phone) > 0'), false);
                        foreach($Addresses as $Address){
                            $value->phone = phonenumber($Address->phone);
                            if($value->phone){
                                break;
                            }
                        }
                        $restaurant="";
                        $restaurant_slug="";
                        $usertype = "User";
                        if($value->restaurant_id>0){
                            $usertype = "Restaurant";
                            $restaurant = $value->restname;
                            $restaurant_slug = $value->restslug;
                        }
                        if($value->profile_type == 1){$usertype = "Admin";}
                    ?>

                    <tr id="user{{ $value->id }}">
                        <td>
                            <!--a class="btn btn-info btn-sm editRow" data-toggle="modal" data-id="{{ $value->id }}" data-target="#editModel">Edit</a-->
                            @if($value->id != \Session::get('session_id'))
                             <div class="">

                                <a href="{{ url('users/action/user_possess/'.$value->id) }}" class="" title="{{ $alts["possess"] }}"
                                   onclick="return confirm('Are you sure you want to possess {{ addslashes("'" . $value->name . "'") }} ?');">Possess</a>

                                <!--a href="{{ url('users/action/user_fire/'.$value->id) }}" class=""
                                   onclick="return confirm('Are you sure you want to fire  {{ addslashes("'" . $value->name . "'") }} ?');">X</a-->

                                <a href="{{ url('user/uploads/'.$value->id) }}" class="">Uploads</a>

                                <a class="" id="delete{{$value->id}}" title="{{ $alts["delete"] }}"
                                   onclick="deleteuser('{{$value->id}}', '{{ addslashes("'" . $value->name . "'") }}');">X</a>
                            </div>
                            @endif
                        </td>

                        <td>{{ $value->id }}</TD>                        <td>{{ $value->name }}</td>

                        <TD nowrap>
                            @if(!$value->restaurant_id && $value->profile_type != 1)
                                <span class="fa fa-spinner fa-spin" id="spinner{{ $value->id }}" style="color:blue; display: none;"></span>
                                <LABEL class="c-input c-checkbox" title="{{ $alts["plus"] }}" id="userplus{{ $value->id }}">
                                    <input type="checkbox" userid="{{ $value->id }}" onclick="promoteuser(event);" {{ iif($value->profile_type == 3, 'checked') }} />
                                    <span class="c-indicator"></span>
                                </LABEL>
                            @endif
                            {{ $usertype }}
                        </td>
                        <!--td>{{ $value->email }}</td-->
                        <td><A HREF="{{ url("restaurants/" . $restaurant_slug . "/menu") }}">{{ $restaurant }}</A></td>
                        <!--td> select_field('profiletypes', 'id', $value->profile_type, 'name') </td-->
                        <td nowrap>{{ phonenumber($value->phone, true) }}</td>
                        <td>{{ $value->email }}</td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td><span class="text-muted">No Records</span></td>
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
<SCRIPT>
    var Users = "{{ $recCount }}";
    function deleteuser(ID, Name){
        if(confirm('Are you sure you want to fire "' + Name + '"?')) {
            $("#delete" + ID).html('<i class="fa fa-spinner fa-spin"></i>');
            $.post("{{ url('users/action/user_fire')}}/" + ID, {_token: "{{ csrf_token() }}"}, function (result) {
                Users=Users-1;
                if(Users) {
                    $("#user" + ID).fadeOut();
                } else {
                    $("#loadPageData").html(result);
                }
            });
        }
    }

    function promoteuser(event){
        var me = $(event.target);
        var id = me.attr("userid");
        var checked = me.is(":checked");
        $("#userplus" + id).hide();
        $("#spinner" + id).show();

        $.post("{{ url('ajax') }}", {
            type: "promoteuser",
            id: id,
            checked: checked,
            _token: "{{ csrf_token() }}"
        }, function (result) {
            if(result){
                alert(result);
            }
            $("#userplus" + id).show();
            $("#spinner" + id).hide();
        });
    }
</SCRIPT>