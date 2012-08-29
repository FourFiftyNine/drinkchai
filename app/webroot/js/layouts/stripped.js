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

    stripped.bindOrderQuantityChange();
  },
  bindOrderQuantityChange: function() {
    $("#OrderQuantity").change(function(e) {
      e.preventDefault(); 
      var price = $(this).attr('data-price');
      var quantity = $(this).val();
      var $dollars = $('.total .dollars');

      $dollars.html('$' + (price * quantity).toFixed(2));
    });
  }
}
})( window, jQuery );