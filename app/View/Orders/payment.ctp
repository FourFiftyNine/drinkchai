<div id="checkout" class="payment-step canvas">
  <?php echo $this->element('stripped/checkout_top', array('showDetails' => true)); ?>
  <form id="payment-form" action="/checkout/payment" class="clearfix" method="post">
    <h2 class="gradient brown">Add Payment Info</h2>
    <div class="clearfix">
      <?php 
      echo $this->Form->input('BillingAddress.firstname', array('class' => 'firstname'));
      echo $this->Form->input('BillingAddress.lastname', array('class' => 'lastname'));
      echo $this->Form->input('BillingAddress.address_one', array('type' => 'hidden', 'class' => 'address_line1'));
      echo $this->Form->input('BillingAddress.zip', array('type' => 'hidden', 'class' => 'address_zip'));
       ?>
    </div>
    <payment key="pk_08sMw2soHqvmWIvVavRRuIfE18zn5">
    </payment>    
    <div class="checkout-bottom">
      <?php echo $this->Form->submit('Continue', array('label' => 'Continue', 'class' => 'btn continue gradient green')); ?>
      <div class="data-encrypted"><span class="lock"></span><strong>Your data is secure and encrypted</strong></div>
    </div>
  </form>
</div>