<div class="modal fade" id="allergyModal" tabindex="-1" role="dialog" aria-labelledby="allergyModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="allergyModalLabel">Allergy & Dietary Information</h4>
            </div>

            <div class="modal-body">

                <?php printfile("views/common/popups/allergy.blade.php"); ?>


                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">

<p>
                        diduEAT tries to accurately copy the item descriptions, allergy information, ingredient information and other information relating to the contents of dishes ("Dietary Information") from the menus that are provided to us by our partner restaurants.
</p><p>
                        However, it is the restaurants themselves that prepare the dishes, and are responsible for providing this Dietary Information and ensuring that it is factually accurate. Please use the comments box to specify particular allergies or dietary requirements.
                        </p><p>
                        If you are in any doubt about the presence of allergens, the contents of a particular dish or any other Dietary Information, you should confirm with the restaurant directly before ordering from diduEAT.
                        </p>
                    </div>



                </div>
            </div>

            <!--div class="row">
         
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" id="modal_contents"><img src="{{ asset('assets/images/loader.gif') }}"/>
                    </div>
                </div>
            </div-->
        </div>
    </div>
</div>