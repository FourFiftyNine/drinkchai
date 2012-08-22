<div id="checkout" class="payment-container canvas">
  <?php echo $this->element('stripped/checkout_review', array('showDetails' => true)); ?>
  <h2 class="gradient brown">Add Payment Info</h2>
  <form id="payment-form" action="/checkout/payment" class="clearfix" method="post">
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
    <!-- <input type="submit" class="btn green gradient" value="Submit"> -->
    Your data is secure and encrypted
    <?php echo $this->Form->submit('Continue', array('label' => 'Continue', 'class' => 'btn continue gradient green')); ?>

  </form>
</div>