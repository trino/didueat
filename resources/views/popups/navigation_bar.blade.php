<div class="modal" id="navigationModal" tabindex="-1" role="dialog" aria-labelledby="navigationModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content ">
            <!--div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="loginModalLabel">123</h4>
            </div-->
            <div class="modal-body p-a-0 m-a-0" style="border-radius: 0 !important;background: #e5e5e5;">

                <div class="p-r-1">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                    </div>

                <?php printfile("views/popups/navigation_bar.blade.php"); ?>
                <div class="col-xs-12 p-a-0 m-a-0">
                    @include('common.navbar_content')
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
