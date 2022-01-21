$(document).ready(function () {
    //$( "#formLogin" ).submit(function( e ) {
        //e.preventDefault();
    //});
    //$(".toast").hide();

    $("body").on('click', '.btn-logout-all', function() {
        var typeLoginId = parseInt($(this).attr('login-type-id'));
        if(typeLoginId == 1) {
            //fb
            fbLogout()
        } else if(typeLoginId == 2) {
            //gg
            signOut()
        } else {
            webLogout();
        }
    });

    $("body").on('click', '.login-gg', function() {
        $(".abcRioButtonContents").find('span').eq(0).click();
    })
});

window.fbAsyncInit = function() {
    FB.init({
      appId      : '177851481129433', 
      cookie     : true, 
      xfbml      : true, 
      version    : 'v3.2'
    });
    
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            getFbUserData();
        }
    });
};

function fbLogin() {
    FB.login(function (response) {
        if (response.authResponse) {
            getFbUserData();
        } else {
            // document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
        }
    }, {scope: 'email'});
}

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function getFbUserData(){
    var isLogin = parseInt($(".btn-outline-red").attr('is-login'));
    if(isNaN(isLogin) == true) {
        FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
        function (response) {
            console.log("==token FB==", response.authResponse.accessToken)
            loginGG_FB(response.id, response.first_name, response.last_name, response.email, 1)
            return false;
        });
    } else {
        FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
        function (response) {
        });
    }
}

function webLogout() {
    $.ajax({
        type: "POST",
        url: $("input#logoutFacebook").val(),
        success: function (response) {
            var json = $.parseJSON(response);
            if(json.code == 1){
                location.reload();
            }
        },
        error: function (response) {
        }
    });
    return false;
}

function fbLogout() {
    FB.logout(function() {
        $.ajax({
            type: "POST",
            url: $("input#logoutFacebook").val(),
            success: function (response) {
                var json = $.parseJSON(response);
                if(json.code == 1){
                    location.reload();
                }
            },
            error: function (response) {
            }
        });
        return false;
    });
}

function renderProductType() {
    let categoryId = $('#categoryId').val();
    if (categoryId > 0) {
        $.ajax({
            type: 'POST',
            url: $('#getProductTypeByCategoryUrl').val(),
            data: {
                CategoryId: categoryId
            },
            success: function (response) {
                let json = $.parseJSON(response);
                if (json.code == 1) {
                    let html = genSelectHtml(json.data);
                    $('.productTypeId').html(html);
                    $('.select2').select2();
                } else showNotification(json.message, json.code);
            },
            error: function () {
                showNotification($('#errorCommonMessage').val(), 0);
            }
        });
    }
}

function onLoad() {
    gapi.load('auth2', function() {
      gapi.auth2.init();
    });
  }
  
function onSignIn(element) {
    auth2.attachClickHandler(element, {},
        function(googleUser) {
        //   document.getElementById('name').innerText = "Signed in: " +
        //       googleUser.getBasicProfile().getName();
            var auth2 = gapi.auth2.getAuthInstance();
            var profile = googleUser.getBasicProfile();
            var email = profile.getEmail();
            var id = profile.getId();
            var customer_first_name = profile.getFamilyName();
            var customer_last_name = profile.getGivenName();
            console.log(id, customer_first_name, customer_last_name, email, 2)
            loginGG_FB(id, customer_first_name, customer_last_name, email, 2)
        }, function(error) {
          console.log(JSON.stringify(error, undefined, 2));
        });
    console.log("==================")
    // var auth2 = gapi.auth2.getAuthInstance();
    // var profile = auth2.currentUser.get().getBasicProfile();
    // var email = profile.getEmail();
    // var id = profile.getId();
    // var customer_first_name = profile.getFamilyName();
    // var customer_last_name = profile.getGivenName();
    // console.log(gapi.auth2.getAuthInstance().currentUser.get().getAuthResponse(true).access_token)
    // loginGG_FB(id, customer_first_name, customer_last_name, email, 2)
    return false;
}

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        $.ajax({
            type: "POST",
            url: $("input#logoutFacebook").val(),
            success: function (response) {
                var json = $.parseJSON(response);
                console.log("You have been signed out successfully");
                if(json.code == 1){
                    location.reload();
                }
            },
            error: function (response) {
            }
        });
       
    });
    return false;
}

function loginGG_FB(id, customer_first_name, customer_last_name, customer_email, login_type_id) {
    $.ajax({
        type: "POST",
        url: $("input#loginFacebook").val(),
        data: {
            id: id,
            customer_first_name: customer_first_name,
            customer_last_name: customer_last_name,
            customer_email: customer_email,
            login_type_id: login_type_id
        },
        success: function (response) {
            var json = $.parseJSON(response);
            $(".notiPopup .text-secondary").html(text_success_social);
            $(".ico-noti-success").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
            if(json.code == 1){
                redirect(false, $("#baseHomeUrl").attr("data-href"));
            }
        },
        error: function (response) {
        }
    });
    return false;
}

var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '1001160309619-f30jgqido5nq8v2nt3gbdd0d7pr5hp7c.apps.googleusercontent.com',
        // cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });
      onSignIn(document.getElementById('customBtn'));
    });
  };