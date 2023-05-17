//Setting default parameters for Jquery validation plugin
jQuery.validator.setDefaults({
    debug: true,
    success: "valid",
    debug: false,
    errorClass: "text-danger form-custom-error",
    errorElement: "span",
});



$(function(){
    //Registration Form
    $('#registration_form').validate({
        rules: {
            first_name: {
                required : true,

            },
            last_name: {
                required : true,

            },
            email: {
                required: true,
                email: true
            },
            contact_number: {
                required: true,
                number: true,

            },
            password: {
                required: true,
                minlength: 6,
            },
            password_confirm: {
                required: true,
                equalTo: "#password"
            },
            type_of_user: {
                required: true,

            }

        },
        messages: {
            first_name:{
                required :"Please enter your first name",
            },
            last_name:{
                required :"Please enter your last name",
            },
            email:{
                required :"Please enter your Email address",
                email:"Please enter valid email address"
            },
            password:{
                required :"Please enter your Password",
            },
            password_confirm:{
                required :"Please enter your Password",
                equalTo:"It should match with the password you typed!"
            },
            contact_number:{
                required :"Please enter your Contact Number",
                number:"Please enter valid contact number"
            },
            type_of_user:{
                required :"Please choose type of user",

            },
            password_confirm:{
                required :"Please enter your Contact Password",
                equalTo: "New password and confirm password does not match"
            }
        },
        submitHandler: function(form) {


        }
    });
});



// Jquery validation for login form

$(function(){
    //Registration Form
    $('#user_login').validate({
        rules: {
            email: {
                required : true,
                email:true

            },
            password: {
                required : true,
                minlength: 6
            },


        },
        messages: {
            first_name:{
                required :"Please enter your first name",
            },
            last_name:{
                required :"Please enter your last name",
            },
            email:{
                required :"Please enter your Email address",
                email:"Please enter valid email address"
            },
            password:{
                required :"Please enter your Password",
                password:"Please enter valid email address"
            },

        },
        submitHandler: function(form) {


        }
    });
});


// Jquery validation for Forget password form

$(function(){

    $('#user_reset_password').validate({
        rules: {
            email: {
                required : true,
                email:true

            },


        },
        messages: {

            email:{
                required :"Please enter your Email address",
                email:"Please enter valid email address"
            },

        },
        submitHandler: function(form) {


        }
    });
});