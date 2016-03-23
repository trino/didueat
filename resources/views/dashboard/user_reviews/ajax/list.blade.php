<?php
    printfile("views/dashboard/user_reviews/ajax/list.blade.php");
    $alts = array(
            "edit" => "Edit this rating",
            "delete" => "Delete this rating"
    );
?>

@if(\Session::has('message'))
{!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">

    <div class="card-header ">
        <div class="row">
            <div class="col-lg-9">
            <h4 class="card-title">Reviews</h4>
                </div>
            @include('common.table_controls')
        </div>
    </div>

    <div class="card-block p-a-0">


        <table class="table table-responsive m-b-0">
            @if($recCount > 0)
                <thead>
                    <tr>
                        <th width="10%">
                            <a class="sortOrder" data-meta="id" data-order="ASC" data-title="ID" title="Sort [ID] ASC"><i class="fa fa-caret-down"></i></a>
                            ID
                            <a class="sortOrder" data-meta="id" data-order="DESC" data-title="ID" title="Sort [ID] DESC"><i class="fa fa-caret-up"></i></a>
                        </th>
                        <th width="15%">
                            <a class="sortOrder" data-meta="user_id" data-order="ASC" data-title="User" title="Sort [User] ASC"><i class="fa fa-caret-down"></i></a>
                            User
                            <a class="sortOrder" data-meta="user_id" data-order="DESC" data-title="User" title="Sort [User] DESC"><i class="fa fa-caret-up"></i></a>
                        </th>
                        <th width="15%">
                            <a class="sortOrder" data-meta="target_id" data-order="ASC" data-title="Target" title="Sort [Target] ASC"><i class="fa fa-caret-down"></i></a>
                            Target
                            <a class="sortOrder" data-meta="target_id" data-order="DESC" data-title="Target" title="Sort [Target] DESC"><i class="fa fa-caret-up"></i></a>
                        </th>
                        <th width="10%">
                            <a class="sortOrder" data-meta="type" data-order="ASC" data-title="Type" title="Sort [Type] ASC"><i class="fa fa-caret-down"></i></a>
                            Type
                            <a class="sortOrder" data-meta="type" data-order="DESC" data-title="Type" title="Sort [Type] DESC"><i class="fa fa-caret-up"></i></a>
                        </th>
                        <th width="10%">
                            <a class="sortOrder" data-meta="rating" data-order="ASC" data-title="Rating" title="Sort [Rating] ASC"><i class="fa fa-caret-down"></i></a>
                            Rating
                            <a class="sortOrder" data-meta="rating" data-order="DESC" data-title="Rating" title="Sort [Rating] DESC"><i class="fa fa-caret-up"></i></a>
                        </th>
                        <th width="20%">
                            <a class="sortOrder" data-meta="comments" data-order="ASC" data-title="Comments" title="Sort [Comments] ASC"><i class="fa fa-caret-down"></i></a>
                            Comment
                            <a class="sortOrder" data-meta="comments" data-order="DESC" data-title="Comments" title="Sort [Comments] DESC"><i class="fa fa-caret-up"></i></a>
                        </th>
                        <th width="10%">
                            <a class="sortOrder" data-meta="created_at" data-order="ASC" data-title="Date" title="Sort [Date] ASC"><i class="fa fa-caret-down"></i></a>
                            Date
                            <a class="sortOrder" data-meta="created_at" data-order="DESC" data-title="Date" title="Sort [Date] DESC"><i class="fa fa-caret-up"></i></a>
                        </th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($Query as $key => $rating)
                        <tr ID="rating{{ $rating->id  }}">
                            <td>{{ $rating->id  }}</td>
                            <td>{{ select_field("profiles", "id", $rating->user_id, "name")  }}</td>
                            <td>{{ ($rating->type == "menu")?select_field("menus", "id", $rating->target_id, "menu_item"):select_field("restaurants", "id", $rating->target_id, "name")  }}</td>
                            <td>{{ $rating->type  }}</td>
                            <td>{{ $rating->rating  }}</td>
                            <td>{{ substr($rating->comments, 0, 100) }}</td>
                            <td>{{ $rating->created_at  }}</td>
                            <td>
                                <a class="btn btn-secondary-outline btn-sm editRow" data-toggle="modal" data-target="#editModel"  data-id="{{ $rating->id }}" title="{{ $alts["edit"] }}">Edit</a>
                                <!--a href="{{ url('user/reviews/action/'.$rating->id) }}" class="btn btn-secondary-outline btn-sm" onclick="return confirm('Are you sure to delete review  {{ addslashes("'" . $rating->rating . "'") }} ?');"><i class="fa fa-times"></i></a-->
                                <a class="btn btn-secondary-outline btn-sm" onclick="deleterating('{{ $rating->id }}', '{{ addslashes("'" . $rating->comments . "'") }}');" title="{{ $alts["delete"] }}">
                                    <i ID="delete{{ $rating->id }}" class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tbody>
                    <tr>
                        <td><span class="text-muted">No Reviews</span></td>
                    </tr>
                </tbody>
            @endif
        </table>
    </div>

    @if(Session::get('session_type_user') == "super"  && $recCount > 10)
        <div class="card-footer clearfix">{!! $Pagination !!}</div>
    @endif
</div>
<SCRIPT>
    var Ratings = '{{ $recCount }}';
    function deleterating(ID, Name){
        if(confirm('Are you sure you want to delete rating "' + Name + '"?')) {
            $("#delete" + ID).attr('class', "fa fa-spinner fa-spin");
            $.post("{{ url('user/reviews/action') }}/" + ID, {_token: "{{ csrf_token() }}"}, function (result) {
                Ratings=Ratings-1;
                if(Ratings) {
                    $("#rating" + ID).fadeOut();
                } else {
                    location.reload();//ajax isn't working here for some reason :/
                }
            });
        }
    }
</SCRIPT>