
window.fbAsyncInit = function() {
    // FB JavaScript SDK configuration and setup
    FB.init({
      appId      : '177851481129433', // FB App ID
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v3.2' // use graph api version 2.8
    });
    
    // Check whether the user already logged in
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            //display user data
            getFbUserData();
        }
    });
};

// Load the JavaScript SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Facebook login with JavaScript SDK
function fbLogin() {
    FB.login(function (response) {
        if (response.authResponse) {
            // Get and display the user profile data
            getFbUserData();
        } else {
            // document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
        }
    }, {scope: 'email'});
}

// Fetch the user profile data from facebook
function getFbUserData(){
    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
    function (response) {
        console.log(response)
        $.ajax({
            type: "POST",
            url: $("input#loginFacebook").val(),
            data: {
                id: response.id,
                customer_first_name: response.first_name,
                customer_last_name: response.last_name,
                customer_email: response.email,
                login_type_id: 1
            },
            success: function (response) {
                var json = $.parseJSON(response);
                console.log(json)
                // showNotification(json.message, json.code);
                if(json.code == 1){
                    document.getElementById('fbLink').setAttribute("onclick","fbLogout()");
                    document.getElementById('fbLink').innerHTML = 'Logout from Facebook';
                    // redirect(false, $("a#btnCancel").attr('href'));
                }
                // else $('.submit').prop('disabled', false);
            },
            error: function (response) {
                // showNotification($('input#errorCommonMessage').val(), 0);
                // $('.submit').prop('disabled', false);
            }
        });
       
        // document.getElementById('status').innerHTML = '<p>Thanks for logging in, ' + response.first_name + '!</p>';
        // document.getElementById('userData').innerHTML = '<h2>Facebook Profile Details</h2><p><img src="'+response.picture.data.url+'"/></p><p><b>FB ID:</b> '+response.id+'</p><p><b>Name:</b> '+response.first_name+' '+response.last_name+'</p><p><b>Email:</b> '+response.email+'</p><p><b>Gender:</b> '+response.gender+'</p><p><b>FB Profile:</b> <a target="_blank" href="'+response.link+'">click to view profile</a></p>';
    });
}

// Logout from facebook
function fbLogout() {
    FB.logout(function() {
       
        $.ajax({
            type: "POST",
            url: $("input#logoutFacebook").val(),
            success: function (response) {
                var json = $.parseJSON(response);
                console.log(json)
                // showNotification(json.message, json.code);
                if(json.code == 1){
                    document.getElementById('fbLink').setAttribute("onclick","fbLogin()");
                    document.getElementById('fbLink').innerHTML = 'Login from Facebook';
                    location.reload();
                }
                // else $('.submit').prop('disabled', false);
            },
            error: function (response) {
                // showNotification($('input#errorCommonMessage').val(), 0);
                // $('.submit').prop('disabled', false);
            }
        });
    });
}

$(document).ready(function () {

    
})