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

    stripped.checkShippingAddressIsSameOnLoad();
    stripped.bindShippingAddressSameCheckbox();
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
  },
  checkShippingAddressIsSameOnLoad: function() {
    stripped.checkShippingAddressCheckbox();
  },
  checkShippingAddressCheckbox: function() {
    if ($('#ShippingAddressSameAsBilling').is(':checked')) {
      $('#shipping-inputs').addClass('hidden');
      $('#same-shipping-note').removeClass('hidden').show();

    } else {
      $('#shipping-inputs').removeClass('hidden');
      $('#same-shipping-note').addClass('hidden').hide();
    }
  },
  bindShippingAddressSameCheckbox: function() {
    $('#ShippingAddressSameAsBilling').change(function(e) {
      stripped.checkShippingAddressCheckbox();
    });
  }
}
})( window, jQuery );