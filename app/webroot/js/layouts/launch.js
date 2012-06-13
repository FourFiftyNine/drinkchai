// Layout = launch
(function( window, $, undefined ) {
'use strict';

// global doesnt exist anywhere else yet
var DrinkChai     = window.DrinkChai || {};
var history   = window.history;
var location  = window.location;
var Modernizr = window.Modernizr;
var $window   = $(window);
var $document = $(document);


// jQuery variables
var $userEmail, $submitEmail;

var launch = DrinkChai.launch = {

  init: function() {
    $userEmail = $('#UserEmail');
    $submitEmail = $('.submit-email');
    launch.showAddThis();

    // binds
    launch.onEnterEmailSubmit();
    launch.onEmailTyping();

    $('nav .ajax-link').click(function(e) {
      e.preventDefault();
      var id = e.target.id;
      $('.ajax-content').fadeOut(500).delay(600);
      $('#' + id + '-content').fadeIn(500);
      $('.ajax-link').removeClass('active');
      $(this).addClass('active');
    });

    $('#facebook-share').click(function(e) {
      e.preventDefault();
      FB.ui(
        {
          method: 'feed',
          name: 'Facebook Dialogs',
          link: 'http://drinkchai.dev',
          caption: 'Reference Documentation',
          description: 'Dialogs provide a simple, consistent interface for applications to interface with users.'
        },
        function(response) {
          if (response && response.post_id) {
            alert('Post was published.');
          } else {
            alert('Post was not published.');
          }
        }
      );
    });

    $('#twitter-share').click(function(event) {
      event.preventDefault();
        var width  = 575,
            height = 400,
            left   = ($(window).width()  - width)  / 2,
            top    = ($(window).height() - height) / 2,
            url    = this.href + '?text=' + $('textarea.share').val().replace('DrinkChai.com', ''),
            opts   = 'status=1' +
                     ',width='  + width  +
                     ',height=' + height +
                     ',top='    + top    +
                     ',left='   + left;

        window.open(url, 'Twitter', opts);
        return false;
    });
    $('#business-submit').click(function(){
      var data = {}; // ?
          data[$('#BusinessEmail').attr('name')] = $('#BusinessEmail').val();
      $.ajax({
        url: '/businesses/launch_submit',
        type: "POST",
        data: data,
        dataType: 'json',
        beforeSend: function(){
          
        },
        success: function(data){
          if(!data.error){
            $('#message').addClass('success').html(data.success);
            $('#BusinessLaunchSubmitForm').hide();
          } else {
            $('#message').addClass('error').html(data.error);
          }
        },
        error: function(data){
        }
        });
      });

    // $userEmail.blur(function() {
    //  if(UTIL.M.csstransitions && ($(this).val() == '')){
    //    $submitEmail.text('');
    //    $(this).removeClass('focus');
    //    $submitEmail.removeClass('entered');
    //  }
    // });

    $submitEmail.click(function(e) {
      e.preventDefault();
      submitEmail();
    });
    $submitEmail.hover(function() {
      $(this).toggleClass('hover');
    });

    $submitEmail.mousedown(function () {
      $(this).addClass('active');
    });

    $submitEmail.mouseup(function () {
      $(this).removeClass('active');
    });

    var $emailValue = $userEmail.val();
    


    if($userEmail.hasClass('form-error')) {
      $userEmail.keydown(function () {
        $(this).removeClass('form-error');
        $(this).addClass('active');
      });   
    }

    var submitEmailBackgroundImage = $submitEmail.css('background-image');
    $userEmail.blur(function(event) {
      // $submitEmail = $(this)
      //   .parent()
      //   .siblings('.submit-email')
      //   .removeClass('entered')
      //   .animate({right: '10px', 'width': '55px'}, 300)
      //   .css({'backgroundImage' : 'url(/img/button_cup.gif)'});
      if( !$userEmail.hasClass('typed') ) {
        $submitEmail.removeClass('entered').text('').css({backgroundImage: submitEmailBackgroundImage});
      }
      // console.log(submitEmailBackgroundImage);
      // setTimeout(function() {
      //   $submitEmail.text('').css({backgroundImage: submitEmailBackgroundImage});
      // }, 750)
      // $($submitEmail).text('');
    });

    $userEmail.focus(function(event) {
      // $submitEmail = $(this)
      //   .parent()
      //   .siblings('.submit-email')
      //   .addClass('entered')
      //   .animate({right: '-30px', 'width': '95px'}, 400)
      //   .css({'backgroundImage' : 'none'})
      //   .text('Submit');
      $submitEmail.addClass('entered');
      setTimeout(function() {
        $submitEmail.text('Submit').css({backgroundImage: 'none'});
      }, 750)
      
    });


    if( !Modernizr.csstransitions ) {
      $userEmail.blur(function(event) {
        // console.log('animat');
        if($(this).val() == '') {
          $(this).animate({width: '345px', 'right': '0'}, 310);
          $(this).val($emailValue);
        }
      });

      $userEmail.focus(function(event) {
        // console.log($(this).val());

        if($(this).val() == $emailValue) {
          $(this).animate({width: '405px', 'right': '20px'}, 410)


          $(this).val('');
        }

        $(this).removeClass('form-error'); // removes red border
      });

    }


    // TODO Could transition to $.form plugin as some point.
    function submitEmail(){
      var hasError    = false,
        emailAddressVal = $userEmail.val(),
        emailRegex    = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i
          ;
      $('.error-message').remove();
          if(emailAddressVal == '' || !emailRegex.test(emailAddressVal)) {
            $userEmail.addClass('form-error');
            $userEmail.after('<span style="display: block;" class="error-message">Please enter an email address.</span>');
            hasError = true;
          }
          if(hasError == true) { return false; }
          $('.error-message').remove();
      
          var data = {}; // ?
          data[$userEmail.attr('name')] = $userEmail.val();

      $.ajax({
        url: '/users/launch_submit',
        type: "POST",
        data: data,
        dataType: 'json',
        beforeSend: function(){
          $submitEmail.hide();
          $userEmail.hide();
          $('.input.text').append('<img style="display:none;" class="ajax-loader" src="/img/cup_large_loader.gif" />');
          $('.input.text').css({'textAlign': 'center', 'marginLeft' : '15px'}); // above styling
          $('.ajax-loader').delay(200).fadeIn(400);
        },
        success: function(data){
          if(!data.error){
            $('section.submit').fadeOut(500);
            $('.ajax-loader').remove();
            $('.thankyou, .addthis_toolbox').delay(600).fadeIn(1000);
          } else {
            $('.ajax-loader').remove();
            $('.input.text').css({'textAlign': 'left', 'marginLeft' : '0'}); 
            $('.submit-email, #UserEmail').show();
            $userEmail.delay(500).after('<span class="error-message">' + data.error + '</span>');
          }
        },
        error: function(data){
        }
          });
    }
  },
  showAddThis: function() {
    $window.load(function(){
      $('#bubble-shares').css('visibility', 'visible').animate({opacity: 1}, 1500);
    });
  },
  onEnterEmailSubmit: function() {
    $userEmail.keypress(function(e) {
       if (e.keyCode == 13 && !e.shiftKey) {
         e.preventDefault();
         submitEmail();          
      }
    });
  },
  onEmailTyping: function() {
    $userEmail.keyup(function(e) {
      if($(this).val() == ''){
        $(this).removeClass('typed');
      } else {
        $(this).addClass('typed');
      }
    });
  }
}
})( window, jQuery );