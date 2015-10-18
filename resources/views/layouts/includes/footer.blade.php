<footer class="page-footer red accent-4">
    <div class="container">
        <div class="row">


                <div class="col-md-1"></div>
                <div class=" col-md-10 col-sm-12 col-xs-12">

                    <div class="col-md-4 col-sm-12 col-xs-11 steps-block-col">
                        <i class="fa fa-search"></i>
                        <div>
                            <h3>Pick A Restaurant</h3>
                            <em>Choose your preference</em>
                        </div>
                        <span>&nbsp;</span>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-11 steps-block-col">
                        <i class="fa fa-shopping-cart"></i>
                        <div>
                            <h3>Order Online</h3>
                            <em>Get the best discount</em>
                        </div>
                        <span>&nbsp;</span>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-11 steps-block-col">
                        <i class="fa fa-spoon"></i>
                        <div>
                            <h3>Enjoy Your Meal</h3>
                            <em>No setup fees, hidden costs, or contracts</em>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>



            <div class="col l4 s12">
                <ul class="social-icons">
                    <li><a class="rss" data-original-title="rss" href="#"></a></li>
                    <li><a class="facebook" data-original-title="facebook" href="#"></a></li>
                    <li><a class="twitter" data-original-title="twitter" href="#"></a></li>
                    <li><a class="googleplus" data-original-title="googleplus" href="#"></a></li>
                    <li><a class="linkedin" data-original-title="linkedin" href="#"></a></li>
                    <li><a class="youtube" data-original-title="youtube" href="#"></a></li>
                    <li><a class="vimeo" data-original-title="vimeo" href="#"></a></li>
                    <li><a class="skype" data-original-title="skype" href="#"></a></li>
                </ul>


            </div>
            <div class="col l4 s12">


                <h2>Newsletter</h2>
                <form action="#" method="post">
                    <input type="hidden" name="action" value="subscribe">
                    <div class="input-group">
                        <input type="text" name="email" placeholder="youremail@mail.com" class="form-control" >
                            <span class="input-group-btn">
                                <button class="btn red" type="submit">Subscribe</button>
                            </span>
                    </div>
                </form>
            </div>
            <div class="col l4 s12" style="overflow: hidden;">


            </div>
        </div>
    </div>


    <div class="footer-copyright">
        <div class="container">
            © 2014-2015 234324324 234234, All rights reserved.
            <a class="grey-text text-lighten-4 right" href="243434324234">MIT License</a>
        </div>
    </div>
</footer>
















<script type="text/javascript">
    jQuery(document).ready(function() {
        Layout.init();
        Layout.initOWL();
        LayersliderInit.initLayerSlider();
        Layout.initImageZoom();
        Layout.initTouchspin();
        Layout.initTwitter();
    });

    $(function() {
        var wd = $(window).width();
        var ht = $(window).height();

        var headr_ht = $('.container-fluid').height();
        var htt = Number(ht) - Number(headr_ht);
        $('.top-cart-block').css({'height': htt});

        if (wd <= '767') {
            $('.top-cart-info').show();
            $('.header-navigation-wrap').hide();
            $('.new_headernav').show();
            $('#cartsz').hide();
        } else {
            $('.header-navigation-wrap').show();
            $('.top-cart-info').hide();
            $('.new_headernav').hide();
            $('#cartsz').show();

        }

        $(window).resize(function() {
            var wd = $(window).width();
            if (wd <= '767') {
                $('.top-cart-info').show();
                $('.header-navigation-wrap').hide();
                $('.new_headernav').show();
                $('#cartsz').hide();
            } else {
                $('.header-navigation-wrap').show();
                $('.top-cart-info').hide();
                $('.new_headernav').hide();
                $('#cartsz').show();

            }
        });
        
        $('body').on('submit', '#searchMenuForm', function(e) {
            var term = $('#searchMenuForm input[name=search_term]').val();
            if (term.trim() != "") {
                window.location.href = "{{ url('/search/menus') }}/" + term;
            }
            e.preventDefault();
        });
        
        $('body').on('submit', '#searchRestaurantForm', function(e){
            var term = $('#searchRestaurantForm input[name=search_term]').val();
            if (term.trim() != "") {
                window.location.href = "{{ url('/search/restaurants') }}/"+term;
            }
            e.preventDefault();
        });

        $('body').on('submit', '#searchMenuForm2', function(e){
            var term = $('#searchMenuForm2 input[name=search_term]').val();
            if (term.trim() != "") {
                window.location.href = "{{ url('/search/menus') }}/" + term;
            }
            e.preventDefault();
        });

        $('body').on('submit', '#searchRestaurantForm2', function(e){
            var term = $('#searchRestaurantForm2 input[name=search_term]').val();
            if (term.trim() != "") {
                window.location.href = "{{ url('/search/restaurants') }}/" + term;
            }
            e.preventDefault();
        });

    });
</script>