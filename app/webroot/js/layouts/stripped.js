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

var stripped = DrinkChai.stripped = {

  init: function() {
  
    $(".purchase-my-deal").click(function(e) {
      $(this).attr("disabled", "disabled").addClass('disabled').val('Purchasing...');
      $('#OrderConfirmForm').submit();
    });

  }
}
})( window, jQuery );