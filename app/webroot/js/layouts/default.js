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

var dLayout = DrinkChai.defaultLayout = {

  init: function() {
    // console.log('here');
    dLayout.ajaxGetTimeLeft()
    dLayout.onClickAccountName()
    dLayout.onClickDeleteImage();
  },
  onClickAccountName: function() {
    $('.account-name').click(function (e) {
      e.preventDefault();
      $(this).siblings('.sub-menu').slideToggle('400');
    });
  },
  onClickDeleteImage: function() {
    var $deleteImageButton = $('.delete-image');
    $deleteImageButton.click(function(e) {
      var url = $(this).attr('href');
      var $clickedBtn = $(this);
      e.preventDefault();
      if(confirm('Are you sure you want to delete this image?')) {
        $.ajax({
          url: url,
          type: 'POST',
          dataType: 'json',
          data: {},
          complete: function(xhr, textStatus) {
            //called when complete
          },
          success: function(data, textStatus, xhr) {
            // console.log(data);
            if(data.Image.deleted) {
              $clickedBtn.parents('.column').fadeOut(500);
            }
          },
          error: function(xhr, textStatus, errorThrown) {
            //called when there is an error
          }
        });
      }
      // console.log('delete!!');
    });
  },
  ajaxGetTimeLeft: function() {
    var timeLeft = {};
    $.ajax({
      url: '/deals/get_time_left',
      type: 'POST',
      dataType: 'json',
      data: {deal_id: '6'},
      complete: function(xhr, textStatus) {
        //called when complete
      },
      success: function(data, textStatus, xhr) {
        //called when successful
        // console.log(data);
        // timeLeft = data
        dLayout.startCountdown(data);
      },
      error: function(xhr, textStatus, errorThrown) {
        //called when there is an error
        // console.log(xhr);
      }
    });
  },
  startCountdown: function(timeLeft) {
    // var timeLeft = data;
    
    var $days    = $('.days');
    var $hours   = $('.hours');
    var $minutes = $('.minutes');
    var $seconds = $('.seconds');
    // console.log($seconds);
    // var days    = parseInt($days.text(), 10);
    // var hours   = parseInt($hours.text(), 10);
    // var minutes = parseInt($minutes.text(), 10);
    // var seconds = parseInt($seconds.text(), 10);
    // console.log(seconds);

    var days = timeLeft.days;
    var hours = timeLeft.hours;
    var minutes = timeLeft.minutes;
    var seconds = timeLeft.seconds;


    // var counter = setTimeout(doCountDown, 1000);

    (function doCountDown() {
      // console.log('1 sec');
      if( seconds <= 0 ) {
        minutes -= 1;
        seconds = 59;
      } else {
        seconds -= 1;
        $seconds.text(prependZero(seconds));
      }
      setTimeout(doCountDown, 1000);
    })();

    function prependZero(num) {
      if(num < 10) {
        num = '0' + num;
        return num;
      } else {
        return num;
      }
    }
  }
}
})( window, jQuery );