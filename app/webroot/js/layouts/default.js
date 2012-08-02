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

    if (($('body').hasClass('view') || $('body').hasClass('preview')) 
      && !$('.time-left').hasClass('no-time') 
      && !$('.time-left').hasClass('days-left')) {
      dLayout.ajaxGetTimeLeft();
    }
    
    dLayout.onClickAccountName();
    dLayout.onClickDeleteImage();
    dLayout.onClickSetFeaturedImage();

    // var uploader = new qq.FileUploader({
    //     // pass the dom node (ex. $(selector)[0] for jQuery users)
    //     element: document.getElementById('file-uploader'),
    //     // path to server-side upload script
    //     action: '/images/uploader',
    //     debug: true
    // });
    
    $('#fileupload, #logoupload').fileupload({
        dataType: 'json',
        progressall: function (e, data) {
          var progress = parseInt(data.loaded / data.total * 100, 10);
          if ( $(this).attr('id') == 'logoupload' ) {
            $('.percent.loaded-logo').removeClass('hidden').find('.number').html(progress);
          } else {
            $('.percent.loaded-product').removeClass('hidden').find('.number').html(progress);
          }
        },
        done: function (e, data) {
          $('.percent').addClass('hidden');
          // console.log(data.result);
          // console.log(data.result);
          console.log(data);
          if(data.result.error) {
            $('.file-upload-error').html('<div class="error-message file">' + data.result.error + '</div>')
          } else {
            $('.no-photos').hide();
            if( data.result.Image.type == 'logo' ) {
              $('#logo-image .image').html('<img src="' + data.result.Image.path_resized + '"/>');

            } else {
              $('#product-image .image').html('<img src="' + data.result.Image.path_resized + '"/>');
            }
          }

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
    // var $deleteImageButton = $('.delete-image');

    $('#pictures-container').on('click', '.delete-image', function(e) {
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
    })

      // console.log('delete!!');
  },
  onClickSetFeaturedImage: function() {
    $('#pictures-container').on('click', '.feature', function(e) {
      var url = $(this).attr('href');
      var $clickedBtn = $(this);
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
          if(data.Image.featured) {
            $('#pictures-container .column').removeClass('featured');

            $clickedBtn.parent('.column').addClass('featured');
          }
        },
        error: function(xhr, textStatus, errorThrown) {
          //called when there is an error
        }
      });
      e.preventDefault();
    });
  },
  ajaxGetTimeLeft: function() {
    var timeLeft = {};
    var deal_id = $('.time-left').attr('data-dealid');
    $.ajax({
      url: '/deals/get_time_left',
      type: 'POST',
      dataType: 'json',
      data: {deal_id: deal_id},
      complete: function(xhr, textStatus) {
        //called when complete
      },
      success: function(data, textStatus, xhr) {

        var timeleft = '+' + data.days + 'd +' + data.hours + 'h +' + data.minutes + 'm +' + data.seconds + 's';
        if (data) {
          $('.time-left').countdown({until: timeleft, compact: true});

          return data;
        } else {

        }
      },
      error: function(xhr, textStatus, errorThrown) {
        //called when there is an error
        // console.log(xhr);
      }
    });
  }
}
})( window, jQuery );