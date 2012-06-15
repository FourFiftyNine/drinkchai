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
  },
  onClickAccountName: function() {
    $('.account-name').click(function (e) {
      e.preventDefault();
      $(this).siblings('.sub-menu').slideToggle('400');
    });
  }
}
})( window, jQuery );