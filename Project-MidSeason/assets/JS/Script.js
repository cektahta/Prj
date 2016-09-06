/**
 * Created by Ebemloshomajki on 9/6/2016.
 */
$('document').ready(function()
{
    /* validation */
    $("#loginf").validate({
        rules:
        {
            password: {
                required: true,
            },
            user_email: {
                required: true,
                email: true
            },
        },
        messages:
        {
            password:{
                required: "please enter your password"
            },
            user_email: "please enter your email address",
        },
        submitHandler: submitForm
    });
    /* validation */

    /* login submit */
    function submitForm()
    {
        var data = $("#loginf").serialize();
        $("#error").fadeOut();

        $.ajax({

            type : 'POST',
            url  : 'Login.php',
            data : data,
            beforeSend: function()
            {

                $("#bttnlogin").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
            },
            success :  function(response)
            {
                if(response=="ok"){

                    $("#bttnlogin").html('<img src="btn-ajax-loader.gif" /> &nbsp; Signing In ...');
                    setTimeout(' window.location.href = "http://localhost/Project-MidSeason/Front.html"; ',4000);
                }
                else{

                    $("#error").fadeIn(1000, function(){
                        $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
                        $("#bttnlogin").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
                    });
                }
            }
        });
        return false;
    }
    /* login submit */
});