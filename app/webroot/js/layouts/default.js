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
  }
}
})( window, jQuery );