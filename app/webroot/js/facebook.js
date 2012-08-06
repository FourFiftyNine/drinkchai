(function (global, $) {
  var DrinkChai = window.DrinkChai || {};

  var theAppId, hostname = global.location.hostname;
  if (hostname == 'dc.vinyljudge.com') {
    theAppId = '305067682888921';
  } else if (hostname == 'drinkchai.dev' || hostname == 'www.drinkchai.dev') {
    theAppId = '259510874070364';
  }
  window.fbAsyncInit = function() {
    FB.init({
      appId: theAppId,
      cookie: true,
      xfbml: true,
      oauth: true
    });
    FB.Event.subscribe('auth.login', function(response) {
      window.location.reload();
    });
    FB.Event.subscribe('auth.logout', function(response) {
      window.location.reload();
    });


    DrinkChai.Facebook = {
      login: function () {
        FB.login(function (response) {
          if (response.authResponse) {
            // console.log('Welcome!  Fetching your information.... ');
            FB.api('/me', function (response) {
              console.log('Good to see you, ' + response.name + '.');
              // window.location.reload();
            });
          } else {
            // console.log('User cancelled login or did not fully authorize.');
          }
        }, {
          scope: 'email'
        });
      },
      logout: function () {
        FB.logout(function (response) {
          window.location = '/users/logout';
        });
      },
      disconnect: function () {
        FB.api({
          method: 'auth.revokeAuthorization'
        }, function (response) {
          // console.log(response);
        });
      }
    };
    $ (document).ready(function ($) {
      $('.logout').bind('click', DrinkChai.Facebook.logout);
      $('.sign-in-with-facebook').on('click', DrinkChai.Facebook.login);
      $('.disconnect').bind('click', DrinkChai.Facebook.disconnect);
    });
  };

  
})(this, jQuery);



