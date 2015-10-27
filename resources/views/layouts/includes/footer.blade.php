<!-- BEGIN STEPS -->
<div class="steps-block steps-block-red" style="color:#FFF;background:#df4500;padding:25px 0; clear: both;">
    <div class="container-fluid">
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
        </div>
    </div>
</div>
<!-- END STEPS -->

<!-- BEGIN PRE-FOOTER -->
<div class="pre-footer" style="color: #a0a0a0;">
    <div class="container-fluid">
        <div class="row">
            <!-- END BOTTOM ABOUT BLOCK -->
            <!-- BEGIN BOTTOM INFO BLOCK -->
            <div class="col-md-3 col-sm-6 pre-footer-col">
                <h2 class="margin-bottom-15">Information</h2>
                <ul class="list-unstyled">
                    <li><i class="fa fa-angle-right"></i> <a href="#">Delivery Information</a></li>
                    <li><i class="fa fa-angle-right"></i> <a href="#">Customer Service</a></li>
                    <li><i class="fa fa-angle-right"></i> <a href="/Foodie/pages/disclaimers">Disclaimers</a></li>
                </ul>
            </div>
            <!-- END INFO BLOCK -->

            <!-- BEGIN TWITTER BLOCK -->
            <div class="col-md-3 col-sm-6 pre-footer-col">
                <h2 class="margin-bottom-15">Latest Tweets</h2>
                <a class="twitter-timeline" href="https://twitter.com/twitterapi" data-tweet-limit="2" data-theme="dark" data-link-color="#57C8EB" data-widget-id="455411516829736961" data-chrome="noheader nofooter noscrollbar noborders transparent">Loading tweets by @keenthemes ...</a>
            </div>
            <!-- END TWITTER BLOCK -->

            <div class="col-md-4 col-sm-12 pre-footer-col">
                <h2 class="margin-bottom-15">Share your Experience</h2>
                <p>Leave comments or describe your experience using the DidUEat.ca website, how well your meal was and interaction with restarurants.</p>
                <form class="form">
                    <fieldset>
                        <div class="form-group margin-bottom-10">
                            <label class="col-lg-12 col-sm-12 control-label col-xs-12 no-padding margin-bottom-10" for="Message">Message <span class="require">*</span></label>
                            <div class="col-lg-12 col-sm-12 col-xs-12 no-padding">
                                <textarea style="height:150px" name="Message" class="form-control margin-bottom-10"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="pull-right">
                                <input class="btn red" type="submit" value="Submit"/>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="col-md-2 col-sm-6 pre-footer-col">
                <h2 class="margin-bottom-15">Cities</h2>
                <ul class="list-unstyled">
                    <li>Hamilton Delivery</li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="row">
            <!-- BEGIN SOCIAL ICONS -->
            <div class="col-md-6 col-sm-6">
                <ul class="social-icons">
                    <li><a class="rss" data-original-title="rss" href="#"></a></li>
                </ul>
            </div>
            <!-- END SOCIAL ICONS -->
            <!-- BEGIN NEWLETTER -->
            <div class="col-md-6 col-sm-6">
                <div class="pre-footer-subscribe-box pull-right">
                    <h2>Newsletter</h2>
                    <form action="#" method="post">
                        <input type="hidden" name="action" value="subscribe">

                        <div class="input-group">
                            <input type="text" name="email" placeholder="youremail@mail.com" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn red" type="submit">Subscribe</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END NEWLETTER -->
        </div>
    </div>


    <!-- BEGIN FOOTER -->
    <div class="footer">
        <div class="container-fluid">
            <div class="row">
                <!-- BEGIN COPYRIGHT -->
                <div class="col-md-4 col-sm-4 padding-top-10">
                    2015 &copy; didueat.ca / ALL Rights Reserved.
                </div>
                <div class="col-md-4 col-sm-4 padding-top-10" align="center">
                    <?php
                    $start = microtime(true);
                    $end = microtime(true);

                    printf("Page was generated in %f seconds", $end - $start);
                    ?>
                </div>
                <!-- END COPYRIGHT -->
                <!-- BEGIN PAYMENTS -->
                <div class="col-md-4 col-sm-4">

                </div>
                <!-- END PAYMENTS -->
            </div>
        </div>
    </div>
    <!-- END FOOTER -->

</div>
<!-- END PRE-FOOTER -->