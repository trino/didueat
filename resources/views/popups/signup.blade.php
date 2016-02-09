<script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>

<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="signupModalLabel">Sign up</h4>
            </div>
            <div id="registration-error" style="display: none;"></div>


            <div id="registration-success" class="note note-success" style="display: none;">
                <?php printfile("views/popups/signup.blade.php (success popup)"); ?>
                <div style="padding: 20px;">
                    <h1 class="block">success</h1>
                </div>
            </div>


            {!! Form::open(array('url' => '/auth/register', 'id'=>'register-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
            <div class="modal-body" id="signupModalBody">
                <?php printfile("views/popups/signup.blade.php"); ?>
                <div class="editaddress">
                    @include('common.contactinfo', array("new" => true))



<div class="row form-group">
<div class="col-md-3">

</div>
<div class="col-md-9 m-a-0">
                    <p class="text-muted" style="font-size:90%">By signing up, you agree to the <a href="">Terms and Conditions</a>.</p>
</div>

                </div>



                    <div class="row">
                        <div class="col-md-12">

                            <button id="regButton" class="btn btn-primary btn-block" type="submit">Sign Up</button>
                        </div>

                    </div>





                </div>


            </div>


            <img id="regLoader" src="{{ asset('assets/images/loader.gif') }}" style="display: none;margin-left:auto;margin-right:auto;"/>




            {!! Form::close() !!}
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        add_all(true, true);
        $('#register-form').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "{{ url('auth/validate/email/ajax') }}",
                        type: "post"
                    }
                },
                password: {
                    required: true,
                    minlength: 5
                },
                phone: {
                    required: true,
                    checkPhone: true
                }
            },
            messages: {
                email: {
                    required: "Please enter an email address!",
                    remote: "This email address is in use already!"
                },
                phone: {
                    required: "Please enter a phone number",
                    checkPhone: "Invalid Phone number"
                }
            }
        });
    });
</script>
