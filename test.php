<SCRIPT>
    baseurl = "http://localhost/didueat/public";
    testrules = makerules({email: "email required", "phone": "phone required", "password": "minlength 3"});

    function makerules(validation){
        var rules = new Object();
        var messages = new Object();
        var startmessage = "Please enter ";
        var currentrule, currentmessage, temprules, ruletype;

        var temp = 0;
        for (var property in validation) {
            if (validation.hasOwnProperty(property)) {
                rules[property] = new Object();
                messages[property] = new Object();
                temprules = validation[property].split(" ");
                ruletype = temprules[0];
                for(var i=0; i<temprules.length; i++) {
                    switch (temprules[i]) {
                        case "phone":
                            rules[property]["checkPhone"] = true;
                            messages[property]["checkPhone"] = "That is not a valid phone number";
                            break;
                        case "email":
                            rules[property]["email"] = true;
                            rules[property]["remote"] = {
                                url: baseurl + "/auth/validate/email/ajax",
                                type: "post"
                            };
                            messages[property]["remote"] = "This email address is already in use";
                            break
                        case "minlength":
                            rules[property]["minlength"] = Number(temprules[i+1]);
                            i=i+1;
                        case "required":
                            rules[property]["required"] = true;
                            switch(ruletype){
                                case "email": messages[property]["required"] = startmessage + "an email address"; break;
                                case "phone": messages[property]["required"] = startmessage + "a phone number"; break;
                                default: messages[property]["required"] = "Please fill out this field";
                            }
                            break;
                        default:
                            alert(temprules[i] + " is not handled");
                    }
                }
            }
        }
        return {rules: rules, messages};
    }

    function printOBJ(obj){
        document.write("<PRE>" + JSON.stringify(obj, null, 2) + "</PRE>");
    }
    printOBJ(testrules);
</SCRIPT>