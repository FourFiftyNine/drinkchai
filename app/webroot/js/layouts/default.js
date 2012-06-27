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

    // dLayout.ajaxGetTimeLeft();
    dLayout.onClickAccountName();
    dLayout.onClickDeleteImage();

    // var uploader = new qq.FileUploader({
    //     // pass the dom node (ex. $(selector)[0] for jQuery users)
    //     element: document.getElementById('file-uploader'),
    //     // path to server-side upload script
    //     action: '/images/uploader',
    //     debug: true
    // });
    
    $('#fileupload').fileupload({
        dataType: 'json',
        progressall: function (e, data) {
          var progress = parseInt(data.loaded / data.total * 100, 10);
          console.log(progress);
        },
        done: function (e, data) {
          console.log(data.result);
          $('#pictures-container').append(tmpl("pictures-container-content", data.result));
            // $.each(data.result, function (index, file) {
            //     $('<p/>').text(file.name).appendTo(document.body);
            // });

        }
    });

    // $('#ImageFileUpload').uploadify({
    //     // Some options
    //     'method'   : 'post',
    //     'preventCaching' : false,
    //     'debug'    : true,
    //     'swf'      : '/lib/uploadify/uploadify.swf',
    //     'formData' : { 'someKey' : 'someValue' },
    //     'uploader' : '/images/uploader',
    //     'onUploadSuccess' : function(file, data, response) {
    //       console.log(data);
    //       console.log(response);
    //     }
    // });
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
        // var date = new Date();
        // dLayout.start = date.getTime();
        // dLayout.timerStart = (new Date).getTime();
        /* Run a test. */
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
    console.log(timeLeft);
    var days = timeLeft.days;
    var hours = timeLeft.hours;
    var minutes = timeLeft.minutes;
    var seconds = timeLeft.seconds;
    var $timeLeft = $('.time-left');
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



    // var internalCounter = 0;
    // var oneSecond = 1000;
    // var interval = oneSecond;
    // var offset = 0;
    // var staticTimer = 0;



    // var counter = setTimeout(doCountDown, 1000);
    // var timeoutId;

    // $seconds.text(prependZero(--seconds));
    // doCountDown();

    if(checkNotNegative(days, minutes, seconds, hours)) {
      $hours.text(prependZero(hours));
      $minutes.text(prependZero(minutes));
      $seconds.text(prependZero(seconds));

      var timer = dLayout.interval(1000, doCountDown)
      timer.run();
      // doCountDown();
    }
    // $timeLeft.fadeIn(750);

    function doCountDown (skipOffset) {
      // console.log('1 sec');
      // console.log(seconds);
      $seconds.text(prependZero(seconds))
      console.log('here');

      if( seconds == 0 ) {
        minutes--;
        if(minutes == 0) {
          if(hours == 0) {

            if(days == 0) {

            } else {
              hours = 23
              day--;
            }
          } else {
            hours--;
            minutes = 59;
          }
        }
        $minutes.text(prependZero(minutes));
        seconds = 60;
      }
      // if (typeof timeoutId != 'undefined') {
      //   // console.log('here2');
      //   seconds--;          
      // }

      seconds--;
    }

    function checkNotNegative() {
      for (var i = 0; i < arguments.length; ++i) {
        if ( arguments[i] < 0) {
          return false
        }
      }
      return true;
    }
    function prependZero(num) {
      if(num < 10) {
        num = '0' + num;
        return num;
      } else {
        return num;
      }
    }
  },
  // doCountDown: function(skipOffset) {
  //   // console.log('1 sec');
  //   if( seconds == 0 ) {
  //     minutes--;
  //     seconds = 60;
  //     $seconds.text(dLayout.prependZero(seconds))
  //   }
  //   if (typeof timeoutId != 'undefined') {
  //     // console.log('here2');
  //     seconds--;          
  //   }
  // },
  interval: function (duration, callback){
    var baseline = undefined;
    return {
       run: function() {
         if( baseline === undefined ) {
           baseline = new Date().getTime();
         }
         callback();
         var end = new Date().getTime();
         baseline += duration;
      
         var nextTick = duration - (end - baseline);
         if( nextTick < 0 ) {
           nextTick = 0;
         }
         (function(i) {
             i.timer = setTimeout(function(){
             i.run( end );
           }, nextTick)
         }(this));
       },
       stop: function() {
        clearTimeout( this.timer );
      }
    }
  }
}
})( window, jQuery );