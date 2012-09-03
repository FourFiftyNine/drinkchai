// Thanks to
// http://paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/
// paulirish
// var log = window.log = function () {
//     log.history = log.history || [];
//     log.history.push(arguments);
//     if (this.console) {
//       console.log(Array.prototype.slice.call(arguments));
//     }
//   };

var DrinkChai = window.DrinkChai || {};

var UTIL = DrinkChai.UTIL = {

  fire: function (func, funcname, args) {

    var namespace = DrinkChai; // indicate your obj literal namespace here

    // console.log('func ', func);
    // console.log('funcname ', funcname);
    // console.log('args ', args);
    if(func == 'default') { func = 'defaultLayout' }
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] == 'function') {
      // console.log('--------------');
      // console.log(funcname);
      // console.log('--------------');
      namespace[func][funcname](args);
    }

  },

  loadEvents: function () {

    var bodyId = document.body.id;

    // hit up common first.
    UTIL.fire('common');
    UTIL.fire(bodyId);
    
    // do all the classes too.
    // $.each(document.body.className.split(/\s+/), function (i, classnm) {
    //   UTIL.fire(classnm);
    //   UTIL.fire(classnm, bodyId);
    // });

    UTIL.fire('common', 'finalize');
  },

  M: Modernizr,

  defaultInputs: function () {
    var $inputsToToggleDefault = $('input.default-value, textarea.default-value');
    if ($inputsToToggleDefault.length) {

      var defaultValues = [];

      $inputsToToggleDefault.each(function (index, el) {
        var $this = $(this);

        $this.data('defaultValue', $this.val());

        defaultValues[index] = null;
        $this.focus(function () {
          if (defaultValues[index] === null) {
            defaultValues[index] = $this.val();
          }

          if ($this.val() === defaultValues[index]) {
            $this.val('');
          }

          $this.blur(function () {
            if (jQuery.trim(this.value) === '') {
              $this.val(defaultValues[index]);
            }
          });
        });

        // clear default values on from submission
        $this.closest('form').bind('submit', function (e) {
          var $this = $(this);
          $this.find('input.default_value, textarea.default_value').each(function (index, el) {
            var $this = $(this);
            if ($this.val() === $this.data('defaultValue')) {
              $this.val('');
            }
          });
        });
      });
    }
  }
};

// main
$(document).ready(UTIL.loadEvents);

// global
// var DrinkChai = {};

// initial setup
// DrinkChai.getFB_APP_ID = function () {
//     if(location.href.indexOf('.dev') != -1) {
//         return '259510874070364';
//     } else if(location.href.indexOf('.com') != -1) {
//         return '331823930171141';
//     }
// };
var common = DrinkChai.common = {
  init: function () {
    var $preventDefaultLinks = $('.ajax-link, .prevent-default');

    $('input, textarea').live('focus', function () {
      $(this).siblings('.error-message').fadeOut(500);
      $(this).removeClass('form-error');
    });

    $('.input').live('click', function () {
      // console.log('here');
      $(this).siblings('.error-message').fadeOut(500);
      $(this).removeClass('form-error');
      $(this).find('input').focus();
    })

    // TODO makebetter
    if ( !$('#flashMessage').hasClass('preview') ) {
      setTimeout(function() {
        $('#flashMessage').fadeOut(500);
      }, 4400);
    }

    
    $('#flashMessage').hover(function () {
      $('#flashMessage').toggleClass('hover');
    }, function () {
      $('#flashMessage').toggleClass('hover');
    });

    $('#flashMessage').click(function (e) {
      // e.preventDefault();
      $(this).fadeOut(400);
    });

    $preventDefaultLinks.click(function (e) {
      e.preventDefault();
    });


    UTIL.defaultInputs();

    var isDealView = false;
    if($('body').hasClass('view') && $('body').hasClass('deals'))
      isDealView = true;

    var isCheckout
      if($('body').hasClass('checkout'))
        isCheckout = true;

    // TODO daysleft? Should this be ignored?
    if ((isDealView || isCheckout)
      && !$('.time-left').hasClass('no-time') 
      && !$('.time-left').hasClass('days-left')) {
      common.ajaxGetTimeLeft();
    }
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
          $('.time-left').countdown({
            until: timeleft, 
            compact: true,
            onExpiry: function() {
              $('.buy-now').replaceWith('<div class="ended">Deal Has Ended</div>');
              // $('.time-left .no-time'{}
              $('.time-left').addClass('no-time');
              $('.time .label').remove();
              setTimeout(function() {
                window.location.reload();
              }, 1000);
              
            },
            expiryText: 'Deal Has Ended'
          });

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

var FourFiftyNine = window.FourFiftyNine || {};

var custPayment = FourFiftyNine.CustomStripePayment = {
  init: function() {
    Stripe.setPublishableKey('pk_08sMw2soHqvmWIvVavRRuIfE18zn5');
    custPayment.bindPaymentForm();
    custPayment.$paymentForm = $('#payment-form');
    custPayment.$number = custPayment.$paymentForm.find('.number input');

    custPayment.$paymentForm.delegate('.number input', 'keydown', custPayment.bindFormatNumber);
    custPayment.$paymentForm.delegate('.number input', 'keyup', custPayment.bindChangeCardType);
    custPayment.$paymentForm.delegate('input[type=tel]', 'keypress', custPayment.bindRestrictNumeric);
  },
  bindPaymentForm: function() {
    var _stripeResponseHandler = custPayment.stripeResponseHandler;
    $("#payment-form").submit(function(event) {
      // console.log('here');
      // console.log($('.card-number').val());
        // disable the submit button to prevent repeated clicks
        $('.submit-button').attr("disabled", "disabled");
        // createToken returns immediately - the supplied callback submits the form if there are no errors
        Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
        }, _stripeResponseHandler);
        return false; // submit from callback
    });
  },
  stripeResponseHandler: function(status, response) {
    if (response.error) {
        // re-enable the submit button
        $('.submit-button').removeAttr("disabled");
        // show the errors on the form
        // custPayment.handleError(response.error);
        $(".payment-errors").html(response.error.message);
    } else {
        var form$ = $("#payment-form");
        // token contains id, last4, and card type
        var token = response['id'];
        // insert the token into the form so it gets submitted to the server
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // and submit
        form$.get(0).submit();
    }
  },
  bindChangeCardType: function(e) {
    var map, name, type, _ref, cardTypes;
    cardTypes = {
      'Visa': 'visa',
      'American Express': 'amex',
      'MasterCard': 'mastercard',
      'Discover': 'discover',
      'Unknown': 'unknown'
    };
    type = Stripe.cardType(custPayment.$number.val());
    if (!custPayment.$number.hasClass(type)) {
      _ref = cardTypes;
      for (name in _ref) {
        map = _ref[name];
        custPayment.$number.removeClass(map);
      }
      return custPayment.$number.addClass(cardTypes[type]);
    }
  },
  bindFormatNumber: function(e) {
    var digit, lastDigits, value;
    digit = String.fromCharCode(e.which);
    if (!/^\d+$/.test(digit)) {
      return;
    }
    value = custPayment.$number.val();
    if (Stripe.cardType(value) === 'American Express') {
      lastDigits = value.match(/^(\d{4}|\d{4}\s\d{6})$/);
    } else {
      lastDigits = value.match(/(?:^|\s)(\d{4})$/);
    }
    if (lastDigits) {
      return custPayment.$number.val(value + ' ');
    }
  },
  bindRestrictNumeric: function(e) {
    var char;
    if (e.shiftKey || e.metaKey) {
      return true;
    }
    if (e.which === 0) {
      return true;
    }
    char = String.fromCharCode(e.which);
    return !/[A-Za-z]/.test(char);
  },
  handleError: function(err) {
    if (err.message) {
       $(".payment-errors").html(err.message);
    }
    console.log(err);
    switch (err.code) {
      case 'card_declined':
        custPayment.invalidInput(custPayment.$number);
        break;
      case 'invalid_number':
      case 'incorrect_number':
        custPayment.invalidInput(custPayment.$number);
        break;
      case 'invalid_expiry_month':
        custPayment.invalidInput(custPayment.$expiryMonth);
        break;
      case 'invalid_expiry_year':
      case 'expired_card':
        custPayment.invalidInput(custPayment.$expiryYear);
        break;
      case 'invalid_cvc':
        custPayment.invalidInput(custPayment.$cvc);
    }
    $('label.invalid:first input').select();
    // custPayment.trigger('error', err);
    return typeof console !== "undefined" && console !== null ? console.error('Stripe error:', err) : void 0;
  },
  invalidInput: function(input) {
    console.log(input);
    input.parent().addClass('invalid');
    return this.trigger('invalid', [input.attr('name'), input]);
  },
  validate: function() {
    var expiry, valid;
    valid = true;
    this.$('div').removeClass('invalid');
    this.$message.empty();
    if (!Stripe.validateCardNumber(this.$number.val())) {
      valid = false;
      this.handleError({
        code: 'invalid_number'
      });
    }
    expiry = this.expiryVal();
    if (!Stripe.validateExpiry(expiry.month, expiry.year)) {
      valid = false;
      this.handleError({
        code: 'expired_card'
      });
    }
    if (this.options.cvc && !Stripe.validateCVC(this.$cvc.val())) {
      valid = false;
      this.handleError({
        code: 'invalid_cvc'
      });
    }
    if (!valid) {
      this.$('label.invalid:first input').select();
    }
    return valid;
  }
}