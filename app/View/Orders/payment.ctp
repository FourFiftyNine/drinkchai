<div id="checkout" class="payment-container canvas">

  <form id="payment-form" action="/checkout/confirm" class="clearfix" method="post">
    <div class="clearfix">
      <?php 
      echo $this->Form->input('Address.0.firstname');
      echo $this->Form->input('Address.0.lastname');
       ?>
    </div>
    <payment data-key="pk_08sMw2soHqvmWIvVavRRuIfE18zn5"></payment>
    <!-- <input type="submit" class="btn green gradient" value="Submit"> -->
    <?php echo $this->Form->submit('Continue', array('label' => 'Continue', 'class' => 'btn continue gradient green')); ?>

  </form>
</div>