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
    var $form = $('#payment-form');
    var tokenObject;
    $form.on('submit', function(e, token){
      e.preventDefault()
      tokenObject = token;
      // console.log(tokenObject);
      // console.log(token.id);
      // $(this).replaceWith('<p>Your Stripe token is: <strong>' + token.id + '</strong></p>');
    });
    $('payment').bind('success.payment', function (e, token) {
      $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
      console.log(token);
      $form.get(0).submit();
    });
    // console.log('here');
    // stripped.onClickAccountName()
    // console.log($('#payment-form'));
   // $('#payment-form').on('submit', function(e, token){
   //   e.preventDefault()
   //   $(this).replaceWith('<p>Your Stripe token is: <strong>' + token.id + '</strong></p>');
   // });
   //  $('payment').bind('success.payment', function () {
   //    // ...
   //  });
  }
}
})( window, jQuery );