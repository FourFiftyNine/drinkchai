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
    launch.onMouseActionsSubmitEmail()
    launch.onClickSubmitEmail();

    // TODO facebook share
    // $('#facebook-share').click(function(e) {
    //   e.preventDefault();
    //   FB.ui(
    //     {
    //       method: 'feed',
    //       name: 'Facebook Dialogs',
    //       link: 'http://drinkchai.dev',
    //       caption: 'Reference Documentation',
    //       description: 'Dialogs provide a simple, consistent interface for applications to interface with users.'
    //     },
    //     function(response) {
    //       if (response && response.post_id) {
    //         alert('Post was published.');
    //       } else {
    //         alert('Post was not published.');
    //       }
    //     }
    //   );
    // });

    // TODO separate out into functions
    var $emailValue = $userEmail.val();
    if($userEmail.hasClass('form-error')) {
      $userEmail.keydown(function () {
        $(this).removeClass('form-error');
        $(this).addClass('active');
      });   
    }

    var submitEmailBackgroundImage = $submitEmail.css('background-image');
    $userEmail.blur(function(event) {
      if( !$userEmail.hasClass('typed') ) {
        $submitEmail.removeClass('entered').text('').css({backgroundImage: submitEmailBackgroundImage});
      }
    });

    $userEmail.focus(function(event) {
      $submitEmail.addClass('entered');
      setTimeout(function() {
        if( $submitEmail.hasClass('entered') ) {
          $submitEmail.text('Submit').css({backgroundImage: 'none'});
        }
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

        if($(this).val() == $emailValue) {
          $(this).animate({width: '405px', 'right': '20px'}, 410)
          $(this).val('');
        }
        $(this).removeClass('form-error'); // removes red border
      });
    }


    // TODO Could transition to $.form plugin as some point.
  },
  showAddThis: function() {
    setTimeout(function(){
      $('#bubble-shares').css('visibility', 'visible').animate({opacity: 1}, 1500);
    }, 1000)
  },
  onEnterEmailSubmit: function() {
    $userEmail.keypress(function(e) {
       if (e.keyCode == 13 && !e.shiftKey) {
         e.preventDefault();
         launch.ajaxSubmitEmail();         
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
  },
  onMouseActionsSubmitEmail: function() {
    $submitEmail
      // .mousedown(function () {
      //   $(this).addClass('active');
      // })
      .hover(function() {
        $(this).toggleClass('hover');
      })
      // .mouseup(function () {
      //   $(this).removeClass('active');
      // });
  },
  onClickSubmitEmail: function() {
    $submitEmail.click(function(e) {
      e.preventDefault();
      launch.ajaxSubmitEmail();
    })
  },

  // TODO check... out ... more
  onTwitterShare: function() {
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
  },

  // TODO refactor heavily
  ajaxSubmitEmail: function() {
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
          console.log(data);
          if(!data.error){
            $('section.submit').fadeOut(500);
            $('.ajax-loader').remove();
            $('.thankyou, .addthis_toolbox').delay(600).fadeIn(1000);
          } else {
            $('.ajax-loader').remove();
            $('.input.text').css({'textAlign': 'left', 'marginLeft' : '0'}); 
            $('.submit-email, #UserEmail').show();
            $userEmail.delay(500).after('<span style="display:block;" class="error-message">' + data.error + '</span>');
          }
        },
        error: function(data){
        }
      });
  },

  // TODO remove?
  ajaxSubmitBusinessEmail: function() {
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
  }
}
})( window, jQuery );