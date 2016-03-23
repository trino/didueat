@extends('layouts.default')
@section('content')


<script>
    //togle the visibility of an element
    function toggleDisplay(id,b){
         if(document.getElementById("faq"+id).style.display=="none"){
             document.getElementById("faq"+id).style.display="block";
         } else{
             document.getElementById("faq"+id).style.display="none";
         }
         if(b){
             chngIcon(id,b);
         }
    }

    //change the icon class of an element
    function chngIcon(idn,b){
         if($('#ic'+idn).attr('class') == "glyphicon glyphicon-chevron-down pull-right glyphUp padL"){
            $('#ic'+idn).attr('class','glyphicon glyphicon-chevron-up pull-right glyphUp padL')
         } else{
            $('#ic'+idn).attr('class','glyphicon glyphicon-chevron-down pull-right glyphUp padL')
         }
    }

    function collapseall(value){
        var temp;
        $(".btn-responsive2").each(function() {
            temp = $(this).next().attr('aria-expanded');
            if(temp == null || temp === undefined){temp = "false";}
            if (temp == value){
                $(this).trigger("click");
            }
        });
    }
</script>

<br/>


<div class="row">
    
    <div class="container">
    
        <h3 class="col-lg-9">FAQs: Frequently Asked Questions, and Answers</h3>
            
        <div class="col-lg-9">
            {{ DIDUEAT }} wants to make every step of your dining experience as easy and pleasurable as possible. To assist you in the process, we encourage you to read through our FAQs and learn from the most frequently asked questions. If you have a question that cannot be answered by our FAQs page, then please send an email with your question to <a href="mailto:info@didueat.ca">info@didueat.ca</a>. We will answer your question as soon as possible, so that you can enjoy your dining experience without any uncertainties.
        
            <div class="row">
                <div class="container">
        
                    <div class="col-lg-5">
                        &bull; <a HREF="#general">General Questions About Using {{ DIDUEAT }}</a><br/>
                        &bull; <a HREF="#managing">Managing Your {{ DIDUEAT }} Account</a><br/>
                        &bull; <a HREF="#other">Other Questions</a>
                    </div>
        
                    <div class="col-lg-7">
                        &bull; <a HREF="#repeat">Repeat Visits And Examining Previous Orders</a><br/>
                        &bull; <a HREF="#payment">Payment Questions</a>
                    </div>
                </div>
            </div>
        
            <br/>
        </div>

        <div class="col-md-3">
            <A onclick="collapseall('true');">Collapse All</A><BR>
            <A onclick="collapseall('false');">Expand All</A>
        </div>
        
        <div class="clearfix"></div>
        
        <div class="col-lg-9">
            <button class="btn btn-danger col-lg-9 questions btn-responsive2" style="cursor:not-allowed;font-weight:bold">TOP FAQ's: Answering the most common questions</button>
        </div>
        
        <div class="col-lg-9">
            <button type="button" class="btn btn-info col-lg-9 btn-responsive2 questions" data-toggle="collapse" data-target="#faq1" onclick="chngIcon(1)">
                How soon will my order arrive?
                <div id="ic1" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></div>
            </button>
        
            <div id="faq1" class="collapse col-lg-9 faqTxt">
                Your dining enjoyment is the top priority for {{ DIDUEAT }}'s restaurants, and they work hard to ensure your meals arrive in a timely fashion. At peak times, your delivery may be slightly delayed, so please check your order confirmation email for the estimated delivery time. If the delivery is substantially delayed, please call the restaurant with the number in the order confirmation email, and ask for an updated delivery time estimate.
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="col-lg-9">
            <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq2" onclick="chngIcon(2)">
                If I have questions, can I call the restaurant?
                <div id="ic2" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></div>
            </button>
            <div id="faq2" class="collapse col-lg-9 faqTxt">
                In most cases you will find all your answers on the {{ DIDUEAT }} website, and on the restaurant's menu page. If you have questions, you can chat with a real person on the {{ DIDUEAT }} Online Chat  Service. Moreover, once you have placed your order, you will be provided with the restaurant's contact number in your order confirmation email, which can be used to call the restaurant if your order does not arrive in a timely manner.
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="col-lg-9">
            <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq3" onclick="chngIcon(3)">
                What do I do if I have a problem with my order after it has arrived?
                <div id="ic3" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></div>
            </button>
            <div id="faq3" class="collapse col-lg-9 faqTxt">
                The best way to deal with a problem with your order, whether it contains the wrong items, or if there is some other problem, is to contact the restaurant itself. The restaurant is best prepared to deal with your concerns, as they are the ones who have prepared it, packaged it, and delivered it. The contact number for the restaurant can be found in your order confirmation email.
                <div class="smBR"><br/><br/></div>{{ DIDUEAT }} is very concerned with your satisfaction, so if you have contacted the restaurant with your concerns, and you still are not satisfied, then please chat live with one of our representatives on our online chat service.
            </div>
            <div class="clearfix"></div>
        </div>
            
        <div class="col-lg-9">
            <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq4" onclick="chngIcon(4)">
                Can I change my order after I have completed my payment?
                <div id="ic4" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></div>
            </button>
            <div id="faq4" class="collapse col-lg-9 faqTxt">
                If your food has not been prepared, most restaurants will be happy to comply with order changes. To make a change, please contact our help line (1-888-888-8888) as soon as possible after placing your  order, and we will see if the restaurant is able to adjust your order (a small, $1 charge will apply for any changes made after you have placed an order). Please do remember that there may be a refund or         additional charge, depending on the changes you make. If a refund is to be made to you, this will apply to the same account for which you paid, and will require a few to be processed by the credit card           company or bank. If your changes require an additional cost, an email will be sent to your registered email address confirming the changes to your order, and will include a link to a payment page. Please         follow this link as soon as possible, because your order will be placed on hold until your new payment is made. Once payment is received, the restaurant will receive your updated details, and an additional       order confirmation email will be sent to you. 
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="col-lg-9">
            <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq5" onclick="chngIcon(5)">
                Can I change my order to pickup or delivery after completing my order?
                <span id="ic5" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
            </button>
            <div id="faq5" class="collapse col-lg-9 faqTxt">
                Most restaurants will be happy to comply if you call as soon as possible after placing your order. To make a change, please contact our help line (1-888-888-8888) as soon as possible after placing your order, and we will see if the restaurant is able to adjust your order (a small, $1 charge will apply for any changes made after you have placed an order). Please do remember that there will likely be an extra charge for delivery, so please make arrangements with the restaurant about paying for this additional expense (and conversely, a refund will be likely if you switch from delivery to pickup).
            </div>
            <div class="clearfix"></div>
        </div>
            
        <div class="col-lg-9">
            <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq6" onclick="chngIcon(6)">
                Do I have to register so that I can order food?
                <span id="ic6" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
            </button>
            <div id="faq6" class="collapse col-lg-9 faqTxt">
                Yes, because a transaction will be performed if you place an order. This can be done at any time before you place an order. In fact, you can do this at your checkout if that is more convenient for you. Registration is necessary because {{ DIDUEAT }} is simply the ordering service, with your orders being fulfilled by independent restaurants from which you have chosen to order your food. Thankfully, there is a very simple registration process, asking for just your name, phone number, email address and a password. Of course, if you want to place an order for delivery, you will need to provide a delivery address -- which can be added at checkout time, or can be stored with your account for easy access in the future. Rest assured, that {{ DIDUEAT }} will keep your information secure, and that it will be kept strictly confidential.
                <div style="font-size:5px;line-height:5px"><br/><br/></div>
                Please note, that you do not need to register if you are simply browsing the site. However, we're sure that when you see the many delicious meals that can be ordered from your cellphone or computer, you'll want to start placing orders as soon as possible.
            </div>
            <div class="clearfix"></div>
        </div>
            
        <div class="col-lg-9">
            <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq7" onclick="chngIcon(7)">
                Can I have more than one address stored?
                <span id="ic7" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
            </button>
            <div id="faq7" class="collapse col-lg-9 faqTxt">
                Certainly. Many of us spend time at different locations, whether you are visiting your girlfriend or boyfriend, your parents or children, or while you are at work. You can also add delivery addresses at checkout time, in case you are at a friend's place and find yourself really wanting something to eat. Just pick up your cellphone, or borrow a computer, and login to your {{ DIDUEAT }} account. With {{ DIDUEAT }}, you can enjoy your meals delivered almost anywhere our restaurants are found.
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="col-lg-9">
            <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq8" onclick="chngIcon(8)">
                What if I forget my password?
                <span id="ic8" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
            </button>
            <div id="faq8" class="collapse col-lg-9 faqTxt">
                No problem. Since you need to have an email address in order to register, you simply have to click the Forgot Password? link on the login pop-up, and enter your email address you used to register at {{ DIDUEAT }}. We will then reset your password and send you a new one in your email. Since emails are unique identifiers requiring a login, you can be confident that your password is secure.
                <div style="font-size:5px;line-height:5px"><br/><br/></div>
                Please also note, that you can always change your password at any time by clicking your name at the top right of the page to display the My Profile pop-up. Here you can change your password to whatever you want -- to one that is more difficult, or one that is easier -- but don't make it too simple, otherwise you will be compromising your login.
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="col-lg-9">
            <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq9" onclick="chngIcon(9)">
                What steps do I take to order my food?
                <span id="ic9" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
            </button>
            <div id="faq9" class="collapse col-lg-9 faqTxt">
                {{ DIDUEAT }} is very simple to use, and has the simplest, most efficient ordering system available. Once you have placed one or two orders, it will become automatic to you, but to start, we recommend the following steps.
                <div class="col-lg-10" style="cursor:pointer;background:#5ecc95;color:#fff;border-radius:3px;padding:4px;text-align:left;padding-left:7px;margin:2px;font-weight:bold" onclick="toggleDisplay('9a',true),true">
                    A. Pick a Restaurant
                    <span id="ic9a" class="glyphicon glyphicon-chevron-down pull-right"></span>
                </div>
                <div id="faq9a" class="col-lg-10" style="display:none;">
                    <ol style="margin:0px;margin-top:5px">
                        <li style="margin-bottom:7px"><b>SEARCH:</b> Start typing your address in the search bar at the top of the page, and the system will hint at locations for you to select. Once you click Search, all local restaurants on {{ DIDUEAT }} will be displayed. (Please note, that the system will display currently open restaurants at the top of your search, with currently closed restaurants at the bottom -- this enables you to browse the menus of nearby restaurants even when they are closed).</li>
                        <li style="margin-bottom:7px"><b>REFINE:</b> You can refine your search by picking a Cuisine Type (eg, Pizza, Chinese, Italian, Vietnamese etc), specifying Delivery or Pickup, or by searching for a particular restaurant by name (note, while all restaurants will have a delivery distance limit, you are free to pick up an order at any distance you choose).</li>
                        <li style="margin-bottom:7px"><b>SELECT A RESTAURANT:</b> Make your choice from the list displayed by clicking the Order Online button, and then start selecting your meal(s).</li>
                    </ol>
                </div>
        
                <div type="button" class="col-lg-10" style="cursor:pointer;background:#5ecc95;color:#fff;border-radius:3px;padding:4px;text-align:left;padding-left:7px;margin:2px;font-weight:bold" onclick="toggleDisplay('9b',true)">
                    B. Select Your Meal
                    <span id="ic9b" class="glyphicon glyphicon-chevron-down pull-right"></span>
                </div>
                <div id="faq9b" class="col-lg-10" style="display:none;">
                    <ol style="margin:0px;margin-top:5px">
                        <li style="margin-bottom:7px"><b>FEED YOUR FANCY!</b> Use the Meal of the Day Special option, or create a custom order to your liking. You can choose your options, your sides and your beverages, or take advantage of the daily specials.</li>
                        <li style="margin-bottom:7px"><b>REAL-TIME REVIEW</b> Your choices will appear in the My Order side box on the right hand side, where you will be able to edit and delete your quantities.</li>
                        <li style="margin-bottom:7px"><b>PICKUP OR DELIVERY</b> Be sure to specify whether you want your meal for Delivery or Pickup.</li>
                    </ol>
                </div>
        
                <div type="button" class="col-lg-10" style="cursor:pointer;background:#5ecc95;color:#fff;border-radius:3px;padding:4px;text-align:left;padding-left:7px;margin:2px;font-weight:bold" onclick="toggleDisplay('9c',true)">
                    C. Place Your Order
                    <span id="ic9c" class="glyphicon glyphicon-chevron-down pull-right"></span>
                </div>
                <div id="faq9c" class="col-lg-10" style="display:none;">
                    <ol style="margin:0px;margin-top:5px">
                        <li style="margin-bottom:7px"><b>FINAL REVIEW</b> Once you are satisfied with your choices, click the Checkout button beneath the My Order box. Please be sure to review your order details and menu selections before you commit to your order.</li>
                        <li style="margin-bottom:7px"><b>PAYMENT</b> specify how you will be paying for your meal order. You can pay cash at pickup or delivery time, or you can use our state-of-the-art secure payment system and pay by credit card or debit card.</li>
                        <li style="margin-bottom:7px"><b>CONFIRMATION</b> Once you have paid for your order, or agreed to pay at pickup or delivery time, you will receive an order confirmation email, which will contain all your order details, as well as the restaurant phone number. At the restaurant's discretion, they will either include the estimated delivery/pickup time in your email, or they will call you with specific details. <b>So rest easy and get ready to enjoy your meal soon!</b></li>
                    </ol>
                </div>
          </div>
         <div class="clearfix"></div>
    </div>
</div>
    
  
<a name="general"></a>
<br/>

    <div class="row">

        <div class="container">

            <div class="col-lg-9">
                <button class="btn btn-danger col-lg-9 questions btn-responsive2" style="cursor:not-allowed;font-weight:bold">General Questions About Using {{ DIDUEAT }}</button>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq20" onclick="chngIcon(20)">
                    How much should I tip the driver when my food is delivered?
                    <span id="ic20" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq20" class="collapse col-lg-9 faqTxt">
                    This is a personal choice, which follows a number of guidelines. You can choose a percentage, usually between 15% and 20%, or you can choose a flat-rate tip, which is typically $4 to $5. For especially nice drivers, or for large and/or complicated orders, you may wish to increase these amounts accordingly. Remember, these are just guidelines, and you may feel free to increase these amounts if you feel more generous.
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq21" onclick="chngIcon(21)">
                    What is the minimum order for {{ DIDUEAT }}?
                    <span id="ic21" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq21" class="collapse col-lg-9 faqTxt">
                    Every restaurant has set its minimum order amount. You can see this amount included together with the restaurant's information, which is shown beneath the address on search results, and also on the restaurant's menu page.
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq23" onclick="chngIcon(23)">
                    How are distances to a restaurant calculated?
                    <span id="ic23" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq23" class="collapse col-lg-9 faqTxt">
                    {{ DIDUEAT }} uses the Haversine method, which is the same as saying, "As the crow flies." This does not indicate actual road distance, but does provide a good measure for how close you are to a restaurant. If you are unfamiliar with the directions to the restaurant, {{ DIDUEAT }} provides a handy Google Maps pop-up, which will proved greater information, including the option to discover distance by road.
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq24" onclick="chngIcon(24)">
                    Do you provide food allergy information?
                    <span id="ic24" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq24" class="collapse col-lg-9 faqTxt">
                    Food allergies are a serious concern for people allergic to common food products. These include eggs, fish, milk, tree nuts, peanuts and ground nuts, MSG, shellfish, soya and wheat. Restaurants on {{ DIDUEAT }} are encouraged to release food allergy information with their descriptions, but unless a restaurant expressly states that they are safe with regards to particular food allergens, it is best to always assume that your food may have come in contact with something to which you are allergic. When in doubt, it is always best to seek firm assurances from the restaurants themselves.
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq25" onclick="chngIcon(25)">
                    Is the process for ordering for delivery the same as for ordering for pickup?
                    <span id="ic25" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq25" class="collapse col-lg-9 faqTxt">
                    Yes, the process is essentially the same, with a few considerations. Please bear in mind that not all restaurants will offer both delivery and pickup options -- if you see both options when placing your order, then you can specify your preference. Please also bear in mind that most restaurants will place an additional charge on your order to pay for delivery, and it is also customary to tip the driver accordingly. Lastly, the estimated time for delivery or pickup will be different, simply because it will take a little extra time to have your order delivered.
                </div>
                <div class="clearfix"></div>
            </div>            
            
            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq27" onclick="chngIcon(27)">
                    How do I find out about {{ DIDUEAT }} promotions or contests?
                    <span id="ic27" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq27" class="collapse col-lg-9 faqTxt">
                    {{ DIDUEAT }} has promotions and contests from time to time, and you can learn about any of our current offerings on our <a href="#" onclick="alert('Coming Soon');return false;">Promotions and Contests</a> page. Furthermore, if you subscribe to our newsletter, you can learn of all our promotions and contests through your email. In addition to {{ DIDUEAT }}'s promotions and contests, each restaurant has to opportunity to offer specials and deals at any time, so please pay attention to these when you are choosing from which restaurant to order.
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq29" onclick="chngIcon(29)">
                    What if there are no restaurants near enough to me to deliver to my address?
                    <span id="ic29" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq29" class="collapse col-lg-9 faqTxt">
                    You have the option to pickup your order yourself if it is outside the restaurant's delivery area, but this is a decision you will have to make for yourself. If you are prepared to drive to a restaurant, you can pickup your order from anywhere you wish to go. At the same time, we would encourage you to speak with your favourite restaurants and ask them to register on {{ DIDUEAT }}. If you are able to convince a restaurant to enroll on {{ DIDUEAT }}, then {{ DIDUEAT }} will give you a $50 gift card as a thank you. Even more, you will then be able to order from this restaurant on {{ DIDUEAT }}, and enjoy the convenience of our online service with one of your favorite restaurants! (Note, in order to receive the {{ DIDUEAT }} gift card, you will need to have the restaurant acknowledge your involvement in convincing them to join. The restaurant can do this when it registers with {{ DIDUEAT }}. For complete details, please see our <a HREF="https://didueat.ca/home/terms">Terms of Use</a> page).
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq30" onclick="chngIcon(30)">
                    What if a restaurant I like is not on {{ DIDUEAT }}?
                    <span id="ic30" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq30" class="collapse col-lg-9 faqTxt">
                    This is where you can help both yourself and {{ DIDUEAT }}. If you are able to convince a restaurant to enroll on {{ DIDUEAT }}, then {{ DIDUEAT }} will give you a $50 gift card as a thank you. Even more, you will then be able to order from this restaurant on {{ DIDUEAT }}, and enjoy the convenience of our online service with one of your favorite restaurants! (Note, in order to receive the {{ DIDUEAT }} gift card, you will need to have the restaurant acknowledge your involvement in convincing them to join. The restaurant can do this when it registers with {{ DIDUEAT }}. For complete details, please see our <a HREF="https://didueat.ca/home/terms">Terms of Use</a> page).
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq31" onclick="chngIcon(31)">
                    Can I use {{ DIDUEAT }} to order for a large event?
                    <span id="ic31" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq31" class="collapse col-lg-9 faqTxt">
                    Absolutely. When placing your order, you can specify a date and time for delivery. In this way, you can enjoy the convenience of our online ordering system, and save time and effort in the process. You can also order from multiple restaurants if you want a more varied cuisine for your guests -- simply checkout multiple times, from as many restaurants as you like. Once you have received your order confirmation email(s), you can contact the restaurant(s) with the number(s) provided in the email(s) if you have any follow-up questions. Please note, advanced orders can be placed only up to 15 days ahead.
                </div>
                <div class="clearfix"></div>
            </div>            
            
            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq32" onclick="chngIcon(32)">
                    What food genres or cuisine types are available on {{ DIDUEAT }}?
                    <span id="ic32" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq32" class="collapse col-lg-9 faqTxt">
                    Our list of restaurants is continuing to expand, which means a great variety of cuisines to suit your fancy. If you don't find a particular genre of restaurant, we encourage you to contact your favorite restaurant(s) offering this cuisine, and encourage them to enroll on {{ DIDUEAT }}. {{ DIDUEAT }} will then give you a $50 gift card as a thank you. (Note, in order to receive the {{ DIDUEAT }} gift card, you will need to have the restaurant acknowledge your involvement in convincing them to join. The restaurant can do this when it registers with {{ DIDUEAT }}. For complete details, please see our <a HREF="https://didueat.ca/home/terms">Terms of Use</a> page. Currently, our restaurants offer the following cuisines: <div style="font-size:5px;line-height:5px"><br/><br/></div>

                    American, Burgers, Canadian, Chicken, Chinese, Desserts, European, Fish and Chips, French, German, Greek, Halal, Health Food, Indian, Italian, Japanese, Korean, Mediterranean, Mexican, Persian, Pizza, Pub Fare, Seafood, Steakhouse, Thai, Vegan, Vietnamese, Wings.
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq34" onclick="chngIcon(34)">
                    Is {{ DIDUEAT }} located across Canada?
                    <span id="ic34" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq34" class="collapse col-lg-9 faqTxt">
                    {{ DIDUEAT }} is a rapidly growing meal ordering system, and will soon be found in communities across the nation. If you are in an area that does not yet have a {{ DIDUEAT }} restaurant close to you, we would encourage you to speak with your favourite restaurants and ask them to register on {{ DIDUEAT }}. If you are able to convince a restaurant to enroll on {{ DIDUEAT }}, then {{ DIDUEAT }} will give you a $50 {{ DIDUEAT }} gift card as a thank you. Even more, you will then be able to order from this restaurant on {{ DIDUEAT }}, and enjoy the convenience of our online service with one of your favorite restaurants! (Note, in order to receive the {{ DIDUEAT }} gift card, you will need to have the restaurant acknowledge your involvement in convincing them to join. The restaurant can do this when it registers with {{ DIDUEAT }}. For complete details, please see our <a HREF="https://didueat.ca/home/terms">Terms of Use</a> page).
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- Tags to End FAQ Section -->
            <div class="clearfix"></div>
        </div>

        <a name="repeat"></a>
    </div>


    <br/>

    <div class="row">

        <div class="container">

            <div class="col-lg-9">
                <button class="btn btn-danger col-lg-9 questions btn-responsive2" style="cursor:not-allowed;font-weight:bold">Repeat Visits And Examining Previous Orders</button>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq40" onclick="chngIcon(40)">
                    Can I examine my past orders?
                    <span id="ic40" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq40" class="collapse col-lg-9 faqTxt">
                    Certainly. Once you are logged in, click on your name on the top right, and go to the My Orders tab under the My Profiles list pop-up. This will show you any pending orders, as well as past orders, the date, and the name of the restaurant. When you click on your past order, you will see further details about your order.
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq41" onclick="chngIcon(41)">
                    Is there a way to reorder the exact same meal as I did on a previous order?
                    <span id="ic41" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq41" class="collapse col-lg-9 faqTxt">
                    Certainly. You can review previous orders with the My Orders tab under the My Profiles list. This will show you any pending orders, as well as past orders. Here you will be given the opportunity to save a past order as a "Favorite" (coming soon), as well as the ability to reorder a meal. When reordering a meal from your past orders list, or from your Favorites list, you will be taken to the same restaurant, wherein an attempt will be made to place the same order for you. Please note however, that if the restaurant has changed it's menu in any way, your order may not be exactly replicated. So please review the new order, and adjust it accordingly. Please also note that the prices of menu items will change from time to time, which is entirely at the discretion of our restaurants.
                </div>
                <div class="clearfix"></div>
            </div>            
            
            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq42" onclick="chngIcon(42)">
                    I did not receive my order confirmation email. What do I do?
                    <span id="ic42" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq42" class="collapse col-lg-9 faqTxt">
                    In this case, it is most likely that the order confirmation email went into your email's Spam or Junk folder. Please check those folders for an email from orders@didueat.ca entitled, {{ DIDUEAT }} Order Confirmation. The subject line will also contain the date and time of your order. If you do not find your order confirmation email, then please immediately call our help line for further assistance, at 1-888-888-8888. Our helpful attendants will be able to assist you.
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq43" onclick="chngIcon(43)">
                    How to prevent order confirmation emails from going in my email Spam folder.
                    <span id="ic43" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq43" class="collapse col-lg-9 faqTxt">
                    The best way to ensure you receive your order confirmation emails in your regular Inbox, is to add orders@didueat.ca to your address book and/or your 'Whitelist'. This will ensure you receive your emails from {{ DIDUEAT }}, and help make your food ordering process move smoothly.
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- Tags to End FAQ Section -->
            <div class="clearfix"></div>
        </div>

        <a name="managing"></a>
    </div>

    <br/>

    <div class="row">

        <div class="container">

            <div class="col-lg-9">
                <button class="btn btn-danger col-lg-9 questions btn-responsive2" style="cursor:not-allowed;font-weight:bold">Managing Your {{ DIDUEAT }} Account</button>

                <div class="row">

                    <div class="container">
                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 questions faqTxt" style="font-weight:normal">
                            {{ DIDUEAT }} has been designed as the easiest meal ordering system for both restaurants, and people looking for an easy way to select their meals. We want your experience on {{ DIDUEAT }} to be both pleasant, and easy to follow. Our goal is to make ordering meals as simple as possible, and to provide restaurants with the opportunity to reach new customers throughout their area of opportunity.
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq50" onclick="chngIcon(50)">
                    Should I logout of my account, or leave it open for the next time I visit?
                    <span id="ic50" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq50" class="collapse col-lg-9 faqTxt">
                    This is a personal choice. If you have a secure computer and/or cellphone from which you can place your orders, then you may wish to keep connected all of the time. In other situations, you may think it is a better idea to logout each time you leave {{ DIDUEAT }}. Certainly, it is prudent to logout when you are not at a secure location, but staying logged in can be more convenient for many people.
                </div>
                <div class="clearfix"></div>
            </div>      
      
            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq51" onclick="chngIcon(51)">
                    How do I edit my profile and information?
                    <span id="ic51" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq51" class="collapse col-lg-9 faqTxt">
                    Simply click your name at the top right of the page, and a pop-up will appear with options for administering your {{ DIDUEAT }} account. Within the pop-up, you can review previous orders, add or modify your delivery addresses and payment card information, and make changes to your profile photo and password. This is also where you can log out of your {{ DIDUEAT }} account.
                </div>
                <div class="clearfix"></div>
            </div>      
      
            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq51" onclick="chngIcon(51)">
                    What is the purpose of the Profile Photo?
                    <span id="ic51" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq51" class="collapse col-lg-9 faqTxt">
                    The decision to upload your own photo to {{ DIDUEAT }} is purely option, but can add a certain personalization to your reviews of restaurants on {{ DIDUEAT }}. When you make a review of a restaurant, a thumbnail of your profile photo or image will be shown beside your comment. If you decide not to upload an image, then a default one will be used in its place.<div style="font-size:5px;line-height:5px"><br/><br/></div>
                    The second usage of a profile photo is to place as an icon beside your name at the top right, which is simply a way to personalize your account for your own use.
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq52" onclick="chngIcon(52)">
                    How do I start ordering meals?
                    <span id="ic52" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq52" class="collapse col-lg-9 faqTxt">
                    If you want to order meals on {{ DIDUEAT }}, you must first sign up for a free {{ DIDUEAT }} account. Click the Signup link at the top left of the Website to get started (the Signup link shows only when you are not logged in). The process is simple and safe, and will have to be completed only once. Once signed up, you can enter your delivery address(es) and edit your personal information as you wish. You are then all set to go and order meals on {{ DIDUEAT }} as often as you like.<div style="font-size:5px;line-height:5px"><br/><br/></div>
                    Once logged in, you can use the homepage to search for restaurants in your area. Simply type your address in the search field and either click the search icon or hit Enter on your keyboard.<div style="font-size:5px;line-height:5px"><br/><br/></div>
                    When you select a restaurant and pick your meal choices, you will be able to check out and order your meals for delivery or pickup. You will also be able to choose between paying with a credit or debit card on the {{ DIDUEAT }} secure payment system, or by paying the driver or restaurant directly.<div class="smBR"><br/><br/></div>
                    When you see a meal you like, you can customize your order in the manner specified by the restaurant. You can add as many items as you like to your meal cart, and customize each item to your specification. Once you are ready to check out, click the Checkout button, and follow the instructions to place your order. <div class="smBR"><br/><br/></div>
                    After placing your order, you will receive an order confirmation email, with the estimated time your meal(s) will arrive or be ready for pickup. At this time, you will also be provided with one last opportunity to cancel your order by following the Cancel link in your order confirmation email.<div class="smBR"><br/><br/></div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq53" onclick="chngIcon(53)">
                    How Do I Change My Delivery Information
                    <span id="ic53" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq53" class="collapse col-lg-9 faqTxt">
                    It is very simple to change your delivery address at {{ DIDUEAT }}. Once logged in, simply click your name at the top right of the page, and then click the My Addresses tab in the My Profile pop-up that appears. If you do not have addresses currently, simply click the Add button at the top and start typing your address in the Address field at the top of the form. As you type, address hints will drop down for you to click on to select your address, which will auto-populate your details. Please remember to add your apartment number, if applicable, as well as and notes that might be helpful to the delivery person (such Buzz Code, or Use Side Door etc.). <span style="color:#FF0000">Click Save, and your addresses will be added.</span> You can add as many addresses as you consider appropriate, so that you can save delivery address for when you are at your home, work, family or friends.<div style="font-size:5px;line-height:5px"><br/><br/></div>
                    If you want to edit an existing address, click the Edit button beside the corresponding address. Here you can edit your address at the top of the form, as well as your Unit/Apt number, if applicable, and your Notes at the bottom of the form. <span style="color:#FF0000">Click Save, and your address information will be updated. </span>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Tags to End FAQ Section -->
            <div class="clearfix"></div>
        </div>

        <a name="payment"></a>

    </div>

    <br/>


    <div class="row">

        <div class="container">

            <div class="col-lg-9">
                <button class="btn btn-danger col-lg-9 questions btn-responsive2" style="cursor:not-allowed;font-weight:bold">Payment Questions</button>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq70z" onclick="chngIcon(70z)">
                    How safe is my payment with {{ DIDUEAT }} on the Internet?
                    <span id="ic70z" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq70z" class="collapse col-lg-9 faqTxt">
                    We are pleased to assure you that your payments are Extremely Safe! With the latest technology, you can be confident that ordering online with {{ DIDUEAT }} is actually more safe than paying in person at a restaurant! {{ DIDUEAT }} uses one of the most trusted companies to process your payments, with encrypted transmission that is widely-accepted as unbreakable! Nevertheless, {{ DIDUEAT }} offers you the option to pay the driver upon delivery of your order, or at the restaurant if you pick up your order. For further information on the safety of our ordering system, <a HREF="https://support.stripe.com/search?q=security" class="lnk" target="_new">we suggest you review the information provided by our order payment processing provider, Stripe</a>.
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq70" onclick="chngIcon(70)">
                    What options are there for payment of my order?
                    <span id="ic70" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq70" class="collapse col-lg-9 faqTxt">
                    There are several ways you can pay with {{ DIDUEAT }}.<div style="font-size:5px;line-height:5px"><br/><br/></div>
                    <ul style="margin:0px;margin-top:1px">
                        <li style="margin-bottom:7px">The most secure way to pay is with our online payment system using a credit card (MasterCard, VISA or American Express), or with a debit card issued by the major banks in Canada.</li>
                        <li style="margin-bottom:7px">You can also pay with a {{ DIDUEAT }} gift certificate or online paycode (Coming Soon).</li>
                        <li style="margin-bottom:7px">Lastly, you can pay the restaurant directly, either at pick-up or delivery time, whichever the case may be.</li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq71" onclick="chngIcon(71)">
                    Can add or delete existing credit and debit card information from {{ DIDUEAT }}
                    <span id="ic71" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq71" class="collapse col-lg-9 faqTxt">
                    Yes you can. Once logged in, simply click your name at the top right of the page, and then click the My Credit/Debit Cards tab in the My Profile pop-up that appears. If you do not currently have any cards added, click the Add button at the top of the My Credit/Debit Cards page, and enter your credit card and/or debit card details. To edit an existing card, click the Edit button beside your card details, and make adjustments accordingly.
                </div>
                <div class="clearfix"></div>
            </div>      
      
            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq72" onclick="chngIcon(72)">
                    I'm receiving an order refund. How long does it take to receive my refund?
                    <span id="ic72" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq72" class="collapse col-lg-9 faqTxt">
                    Most refunds will be issued within 48 hours. However, depending on the bank involved, debit refunds can take a little longer. Please monitor your situation, and feel free to contact us if any problems arise.
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq73" onclick="chngIcon(73)">
                    How do I order a {{ DIDUEAT }} gift card? (Coming Soon!)
                    <span id="ic73" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq73" class="collapse col-lg-9 faqTxt">
                    A virtual gift card from {{ DIDUEAT }} makes the perfect gift! Simply go to our Gift Cards page and pick the dollar amount you wish to assign to the gift card. You can then choose how to "give" your gift card. You can<div style="font-size:5px;line-height:5px"><br/><br/></div>

                    1. Have the gift card emailed to the recipient, with your own words in the message,<br/>
                    2. You can print out the gift card yourself and give it to the recipient in person,<br/>
                    3. You can write down the paycode of the gift card and simply give the paycode to the recipient.
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq74" onclick="chngIcon(74)">
                    How do I redeem my {{ DIDUEAT }} gift card or voucher? (Coming Soon!)
                    <span id="ic74" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq74" class="collapse col-lg-9 faqTxt">
                    When are your ready to 'checkout', after you have selected your order, you will see a place to enter your gift card or credit voucher. The amount of your payment will then be reduced accordingly. If the value of your gift card or voucher is greater than the charge for your order, you will be shown the remaining balance on your gift card or voucher, which you can redeem in a future order.
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Tags to End FAQ Section -->
            <div class="clearfix"></div>
        </div>
        <a name="other"></a>
    </div>

    <br/>


    <div class="row">

        <div class="container">

            <div class="col-lg-9">
                <button class="btn btn-danger col-lg-9 questions btn-responsive2" style="cursor:not-allowed;font-weight:bold">Other Questions</button>
            </div>      
      
            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq80" onclick="chngIcon(80)">
                    Can I leave a review after I have ordered from a restaurants on {{ DIDUEAT }}?
                    <span id="ic80" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq80" class="collapse col-lg-9 faqTxt">
                    Most definitely! We encourage our customers to both rate our restaurants (between 1 and 5), and write a written review our restaurants. This is a valuable resource, and helps everyone, including helping to keep our restaurants informed of public opinion. You will be given the opportunity to review a restaurant for up to 7 days after you have placed an order. Please be honest, and maintain a certain decorum in your choice of words.
                </div>
                <div class="clearfix"></div>
            </div>      
      
            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq81" onclick="chngIcon(81)">
                    Can I change my review of a restaurant?
                    <span id="ic81" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq81" class="collapse col-lg-9 faqTxt">
                    {{ DIDUEAT }} encourages customers to review and rate their meals. In the spirit of fairness, you can write or edit a review of a restaurant for only one week following an order. In cases of disputes with a restaurant which last longer than one week, you can change an existing review only by contacting {{ DIDUEAT }} and requesting a change in your rating and/or review. In such circumstance, please send a request to contact@didueat.ca, and we will happily consider making a change in your review/rating, based upon the circumstances involved.
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-9">
                <button type="button" class="btn btn-info col-lg-9 btn-responsive2" style="text-align:left;padding-left:7px;margin:2px" data-toggle="collapse" data-target="#faq82" onclick="chngIcon(82)">
                    Does {{ DIDUEAT }} have an ombudsman, or dispute resolution mechanism?
                    <span id="ic82" class="glyphicon glyphicon-chevron-down pull-right glyphUp padL"></span>
                </button>
                <div id="faq82" class="collapse col-lg-9 faqTxt">
                    Yes we do. We understand that problems can arise between our restaurants and their customers. If you can't reach an amicable, and reasonable, resolution to a situation, {{ DIDUEAT }} will help mediate a solution. This will involve a dispassionate, objective evaluation the circumstances, and all decisions in our mediation will be final. We are confident that we can satisfy all of our customers and member restaurants, and will take any disputes seriously.
                </div>
                <div class="clearfix"></div>
            </div>


            <!-- Tags to End FAQ Section -->
            <div class="clearfix"></div>
        </div>
    </div>


    <br/><br/><br/>

@stop