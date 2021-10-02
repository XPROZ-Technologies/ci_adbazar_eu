$(document).ready(function () {
    $( "#formLogin" ).submit(function( e ) {
        e.preventDefault();
        alert('a');
    });
    $(".toast").hide();

    $("body").on('click', '.btn-outline-red', function() {
        var typeLoginId = parseInt($(this).attr('login-type-id'));
        if(typeLoginId == 1) {
            //fb
            fbLogout()
        } else if(typeLoginId == 2) {
            //gg
        } else {

        }
    });
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
            console.log("============================")
            getFbUserData();
        } else {
            console.log("===2222222222222222====================")
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
    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
    function (response) {
        if(isLogin < 1) {
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
                        $(".toast").show();
                        $(".text-secondary").html(json.message);
                        redirect(false, $("#baseHomeUrl").attr("data-href"));
                    }
                    // else $('.submit').prop('disabled', false);
                },
                error: function (response) {
                    // showNotification($('input#errorCommonMessage').val(), 0);
                    // $('.submit').prop('disabled', false);
                }
            });
        }
        
        return false;
    });
}

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