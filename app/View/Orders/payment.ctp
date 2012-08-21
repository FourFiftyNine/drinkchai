<div id="checkout" class="payment-container canvas">

  <form id="payment-form" action="/checkout/confirm" class="clearfix" method="post">
    <div class="clearfix">
      <?php 
      echo $this->Form->input('BillingAddress.firstname');
      echo $this->Form->input('BillingAddress.lastname');
      echo $this->Form->input('BillingAddress.address_one', array('type' => 'hidden'));
      echo $this->Form->input('BillingAddress.zip', array('type' => 'hidden'));
       ?>
    </div>
    <payment key="pk_08sMw2soHqvmWIvVavRRuIfE18zn5">
    </payment>
    <!-- <input type="submit" class="btn green gradient" value="Submit"> -->
    <?php echo $this->Form->submit('Complete My Order', array('label' => 'Continue', 'class' => 'btn continue gradient green')); ?>

  </form>
</div>