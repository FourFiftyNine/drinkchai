// Thanks to
// http://paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/
// paulirish
var log = window.log = function () {
    log.history = log.history || [];
    log.history.push(arguments);
    if (this.console) {
      console.log(Array.prototype.slice.call(arguments));
    }
  };

var DrinkChai = window.DrinkChai || {};

var UTIL = DrinkChai.UTIL = {

  fire: function (func, funcname, args) {

    var namespace = DrinkChai; // indicate your obj literal namespace here

    // console.log('func ', func);
    // console.log('funcname ', funcname);
    // console.log('args ', args);
    if(func == 'default') { func = 'defaultLayout' }
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] == 'function') {
      // console.log('--------------');
      // console.log(funcname);
      // console.log('--------------');
      namespace[func][funcname](args);
    }

  },

  loadEvents: function () {

    var bodyId = document.body.id;

    // hit up common first.
    UTIL.fire('common');
    UTIL.fire(bodyId);
    
    // do all the classes too.
    // $.each(document.body.className.split(/\s+/), function (i, classnm) {
    //   UTIL.fire(classnm);
    //   UTIL.fire(classnm, bodyId);
    // });

    UTIL.fire('common', 'finalize');
  },

  M: Modernizr,

  defaultInputs: function () {
    var $inputsToToggleDefault = $('input.default-value, textarea.default-value');
    if ($inputsToToggleDefault.length) {

      var defaultValues = [];

      $inputsToToggleDefault.each(function (index, el) {
        var $this = $(this);

        $this.data('defaultValue', $this.val());

        defaultValues[index] = null;
        $this.focus(function () {
          if (defaultValues[index] === null) {
            defaultValues[index] = $this.val();
          }

          if ($this.val() === defaultValues[index]) {
            $this.val('');
          }

          $this.blur(function () {
            if (jQuery.trim(this.value) === '') {
              $this.val(defaultValues[index]);
            }
          });
        });

        // clear default values on from submission
        $this.closest('form').bind('submit', function (e) {
          var $this = $(this);
          $this.find('input.default_value, textarea.default_value').each(function (index, el) {
            var $this = $(this);
            if ($this.val() === $this.data('defaultValue')) {
              $this.val('');
            }
          });
        });
      });
    }
  }
};

// main
$(document).ready(UTIL.loadEvents);

// global
// var DrinkChai = {};

// initial setup
// DrinkChai.getFB_APP_ID = function () {
//     if(location.href.indexOf('.dev') != -1) {
//         return '259510874070364';
//     } else if(location.href.indexOf('.com') != -1) {
//         return '331823930171141';
//     }
// };
DrinkChai.common = {
  init: function () {
    var $preventDefaultLinks = $('.ajax-link, .prevent-default');

    $('input, textarea').live('focus', function () {
      $(this).siblings('.error-message').fadeOut(500);
      $(this).removeClass('form-error');
    });

    $('.input').live('click', function () {
      // console.log('here');
      $(this).siblings('.error-message').fadeOut(500);
      $(this).removeClass('form-error');
      $(this).find('input').focus();
    })
    // var xpos = 0;
    // var animateInterval = setInterval(function () {
    //     xpos -= 100;
    //     console.log(xpos);
    //     $('#flashMessage').css('backgroundPosition', xpos + 'px');
    // }, 300);
    $('#flashMessage').fadeIn(400, function () {
      $('#flashMessage').delay(4000).fadeOut(400);
    });
    $('#flashMessage').hover(function () {
      $('#flashMessage').toggleClass('hover');
    }, function () {
      $('#flashMessage').toggleClass('hover');
    });

    function animateBackground() {
      // console.log('asda');
      // console.log($('#flashMessage').filter(':visible'));
      // if(!$this.filter(':visible')) {
      //     clearInterval(animateInterval);
      // }
    }


    $('#flashMessage').click(function (e) {
      // e.preventDefault();
      $(this).fadeOut(400);
    });

    $preventDefaultLinks.click(function (e) {
      e.preventDefault();
    });



    // $('header nav a.login').click(function(e) {
    //     e.preventDefault();
    //     $('.login-box').fadeToggle();
    // })
    UTIL.defaultInputs();
    //   window.fbAsyncInit = function() {
    // FB.init({
    //         appId      : DrinkChai.getFB_APP_ID(), // App ID
    //         // channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File
    //         status     : true, // check login status
    //         cookie     : true, // enable cookies to allow the server to access the session
    //         xfbml      : true  // parse XFBML
    //     });
    // // Additional initialization code here
    // };
  }
}