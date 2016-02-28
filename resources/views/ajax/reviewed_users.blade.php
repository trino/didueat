<?= printfile("views/ajax/reviewed_users.blade.php"); ?>

@if(isset($detail) && !is_null($detail) && count($detail) > 0)
    <table class="table table-striped" id="modal_table_max_height">
        <tbody>
        @foreach($detail as $value)
            <tr>
                <?php
                    $profile = select_field("profiles", "id", $value->user_id);
                    $logo_name = "default-avatar.jpg";
                    $logo = $value->user_id . "/icon-" . trim($profile->photo);
                    if(trim($logo)){
                        $logo_name = $logo;
                    }
                ?>
                <td width="10%"><img src="{{ asset('assets/images/users/' . $logo_name) }}" width="55" /></td>
                <td width="90%">
                    {{ $profile->name }} &nbsp;-&nbsp; (<i>{{ date("d M, Y", strtotime($value->created_at)) }}</i>)<br />
                    {!! rating_initialize("static-rating", $type, $value->target_id, false, 'update-rating', false, false, "", true, $value->rating) !!}
                    <div class="clearfix"></div>
                    {{ trim($value->comments) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
   <!-- No reviews yet -->
@endif