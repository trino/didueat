<?php
    printfile("views/ajax/reviewed_users.blade.php");
    $alts = array(
            "logo" => "Your profile logo"
    );
?>

@if(isset($detail) && !is_null($detail) && count($detail) > 0)
    <table class="table table-striped" id="modal_table_max_height">
        <tbody>
        @foreach($detail as $value)
            <tr>
                <?php
                    //get their profile picture
                    $profile = select_field("profiles", "id", $value->user_id);
                    $logo_name = "small-didueatdefault.png";
                    $logo = trim($value->user_id . "/icon-" . trim($profile->photo));
                    if($profile->photo){
                        $logo_name = 'users/' . $logo;
                    }
                ?>
                <td width="10%"><img src="{{ asset('assets/images/' . $logo_name) }}" width="55" class="img-circle" alt="{{ $alts["logo"] }}"/></td>
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