var FormValidation = function () {
    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_sample_1');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: {
                    select_multi: {
                        maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                        minlength: jQuery.validator.format("At least {0} items must be selected")
                    }
                },
                rules: {
                    name: {
                        minlength: 2,
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    url: {
                        required: true,
                        url: true
                    },
                    number: {
                        required: true,
                        number: true
                    },
                    digits: {
                        required: true,
                        digits: true
                    },
                    creditcard: {
                        required: true,
                        creditcard: true
                    },
                    occupation: {
                        minlength: 5,
                    },
                    select: {
                        required: true
                    },
                    select_multi: {
                        required: true,
                        minlength: 1,
                        maxlength: 3
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success1.hide();
                    error1.show();
                    Metronic.scrollTo(error1, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label.closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function (form) {
                    success1.show();
                    error1.hide();
                    form.submit();
                }
            });


    }

    // validation using icons
    var handleValidation2 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form2 = $('#form_sample_2');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    name: {
                        minlength: 2,
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    url: {
                        required: true,
                        url: true
                    },
                    number: {
                        required: true,
                        number: true
                    },
                    digits: {
                        required: true,
                        digits: true
                    },
                    creditcard: {
                        required: true,
                        creditcard: true
                    },
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success2.hide();
                    error2.show();
                    Metronic.scrollTo(error2, -200);
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                },

                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    success2.show();
                    error2.hide();
                    form[0].submit(); // submit the form
                }
            });


    }

    // advance validation
    var handleValidation3 = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

            var form3 = $('#form_sample_3');
            var error3 = $('.alert-danger', form3);
            var success3 = $('.alert-success', form3);

            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })

            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
                    name: {
                        minlength: 2,
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },  
                    options1: {
                        required: true
                    },
                    options2: {
                        required: true
                    },
                    select2tags: {
                        required: true
                    },
                    datepicker: {
                        required: true
                    },
                    occupation: {
                        minlength: 5,
                    },
                    membership: {
                        required: true
                    },
                    service: {
                        required: true,
                        minlength: 2
                    },
                    markdown: {
                        required: true
                    },
                    editor1: {
                        required: true
                    },
                    editor2: {
                        required: true
                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
                    membership: {
                        required: "Please select a Membership type"
                    },
                    service: {
                        required: "Please select  at least 2 types of Service",
                        minlength: jQuery.validator.format("Please select  at least {0} types of Service")
                    }
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.parent(".input-group").size() > 0) {
                        error.insertAfter(element.parent(".input-group"));
                    } else if (element.attr("data-error-container")) { 
                        error.appendTo(element.attr("data-error-container"));
                    } else if (element.parents('.radio-list').size() > 0) { 
                        error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                    } else if (element.parents('.radio-inline').size() > 0) { 
                        error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                    } else if (element.parents('.checkbox-list').size() > 0) {
                        error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                    } else if (element.parents('.checkbox-inline').size() > 0) { 
                        error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success3.hide();
                    error3.show();
                    Metronic.scrollTo(error3, -200);
                },

                highlight: function (element) { // hightlight error inputs
                   $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function (form) {
                    success3.show();
                    error3.hide();
                    form[0].submit(); // submit the form
                }

            });

             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });

            // initialize select2 tags
            $("#select2_tags").change(function() {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
            }).select2({
                tags: ["red", "green", "blue", "yellow", "pink"]
            });

            //initialize datepicker
            $('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                autoclose: true
            });
            $('.date-picker .form-control').change(function() {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
            })
    }

    var handleWysihtml5 = function() {
        if (!jQuery().wysihtml5) {
            return;
        }

        if ($('.wysihtml5').size() > 0) {
            $('.wysihtml5').wysihtml5({
                "stylesheets": ["../../assets/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
            });
        }
    }

    return {
        //main function to initiate the module
        init: function () {
            handleWysihtml5();
            handleValidation1();
            handleValidation2();
            handleValidation3();
        }
    };

}();

//the above functions were here before I got here. I wouldn't touch them if I were you.

//adds Custom validators
function add_all(pattern, phone){
    if(pattern){add_matchpattern();}
    if(phone){add_checkphone();}

    jQuery.validator.addMethod("requiresperiod", function (value, element) {
        var atsymbol = value.indexOf("@");
        return atsymbol >-1 && value.indexOf(".", atsymbol) > -1;
    });
}

//adds pattern validation. What pattern? I don't know
function add_matchpattern() {
    jQuery.validator.addMethod("matchPattern", function (value, element) {
        var patt = "/((^[0-9]+[a-z]+)|(^[a-z]+[0-9]+))+[0-9a-z]+$/i";
        return value.replace(' ', '').length == 6;
    });
}

//adds phone validation
function add_checkphone() {
    jQuery.validator.addMethod("checkPhone", function (value, element) {
        value = value.replace(/\D/g,'');
        if (value.length != 10) {return false;}//must be 10 digits
        var firstdigit = value.substring(0, 1);
        if(firstdigit == 0 || firstdigit == 1){return false;}//do not allow 0 or 1 to be the first number
        firstdigit = value.substring(0, 3);
        return AreaCodes.indexOf(Number(firstdigit)) > -1;//only allow canadian area codes from the helper
    });
}

//removes existing validation rules from a form, adds all custom validators, then calls makerules()
function validateform(formID, rules){
    //$("#" + formID + ' > input, select, textarea').rules('remove');
    $("#" + formID).removeData('validator');
    $("#" + formID).removeData('validate');
    add_all(true, true);
    $("#" + formID).validate(makerules(rules));
}

//simplifies rule creation
//ie: makerules({fieldname: "phonenumber required"});
function makerules(validation){
    var rules = new Object();
    var messages = new Object();
    var startmessage = "Please enter ";
    var temprules, ruletype;
    var defaulttext = "Please fill out this field";
    var usecurrentuser = false;
    for (var property in validation) {
        if (validation.hasOwnProperty(property)) {
            rules[property] = new Object();
            messages[property] = new Object();
            var index = validation[property].indexOf("=");
            if (index > -1) {
                defaulttext = validation[property].substr(index+1);
                validation[property] = validation[property].substr(0, index);
            }
            temprules = validation[property].split(" ");
            ruletype = temprules[0];
            for(var i=0; i<temprules.length; i++) {
                switch (temprules[i]) {
                    case "creditcard":
                        rules[property]["creditcard"] = true;
                        messages[property]["creditcard"] = "The card number is not valid";
                        break;
                    case "phone":
                        rules[property]["checkPhone"] = true;
                        messages[property]["checkPhone"] = startmessage + "a valid phone number";
                        break;
                    case "currentuser":
                        usecurrentuser = true;
                        break;
                    case "email":
                        rules[property]["email"] = true;
                        if(usecurrentuser){
                            rules[property]["remote"] = {
                                url: baseurl + "/auth/validate/email/ajax/" + currentuser,
                                type: "post"
                            };
                        } else {
                            rules[property]["remote"] = {
                                url: baseurl + "/auth/validate/email/ajax",
                                type: "post"
                            };
                        }
                        messages[property]["remote"] = "This email address is already in use";
                        rules[property]["requiresperiod"] = true;0
                        messages[property]["requiresperiod"] = startmessage + "a valid email address.";
                        break
                    case "minlength":
                        rules[property]["minlength"] = Number(temprules[i+1]);
                        i=i+1;
                    case "required":
                        rules[property]["required"] = true;
                        switch(ruletype){
                            case "email": messages[property]["required"] = startmessage + "an email address"; break;
                            case "phone": messages[property]["required"] = startmessage + "a phone number"; break;
                            case "creditcard": messages[property]["required"] = startmessage + "a credit card"; break;
                            default: messages[property]["required"] = defaulttext;
                        }
                        break;
                    default:
                        alert2(temprules[i] + " is not handled");
                }
            }
        }
    }
    return {rules: rules, messages: messages, focusInvalid: false,
        invalidHandler: function(form, validator) {
            var first = -1, element;
            for (i = 0; i < validator.errorList.length; i++){
                element = validator.errorList[i].element;
                if ($(element).is(":visible") && !$(element).is(":hidden") && !$(element).is(":disabled")) {
                    first = i;
                    break;
                }
            }

            if (!validator.numberOfInvalids()) {
                return;
            }

            if(first>-1) {
                $('html, body').animate({
                    scrollTop: $(validator.errorList[first].element).offset().top - 80
                }, 2000);
            }
        }
    };
}