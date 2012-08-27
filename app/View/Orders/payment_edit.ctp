<div id="checkout" class="payment-edit canvas clearfix">
  <?php echo $this->element('stripped/checkout_top', array('showDetails' => true)); ?>
  <?php echo $this->Form->create('User', array('url' => '/checkout/payment/edit')); ?>
  <div class="clearfix">
    <div class="address-form-half">
      <h2 class="gradient brown">Billing Information</h2>
        <?php 
          if ($this->Form->isFieldError('BillingAddress.user_id')):
              echo $this->Form->error('BillingAddress.user_id', null, array('class' => 'no-input-error error-message'));
          endif;
         ?>
        <?php 
          echo $this->Form->input('BillingAddress.id', array('type' => 'hidden'));
          echo $this->Form->input('BillingAddress.firstname', array('class' => 'short'));
          echo $this->Form->input('BillingAddress.lastname', array('class' => 'short'));
        ?>
        <?php
          echo $this->Form->input('BillingAddress.address_one', array('class' => 'address_line1'));
          echo $this->Form->input('BillingAddress.address_two');
          echo $this->Form->input('BillingAddress.city');
          echo $this->Form->input('BillingAddress.state');
          echo $this->Form->input('BillingAddress.zip', array('class' => 'zip address_zip', 'div' => array('class' => 'input text zip')));
        ?>
    </div>

    <div class="payment-container">
      <?php if(isset($card_error)): ?>
      <div class="no-input-error error-message"><?php echo $card_error; ?></div>
      <?php endif; ?>
      <payment key="pk_08sMw2soHqvmWIvVavRRuIfE18zn5"></payment>
      <?php echo $this->Form->submit('Continue', array('label' => 'Continue', 'class' => 'btn continue gradient green')); ?>
      <?php echo $this->Html->link('go back', '/checkout/confirm', array('class' => 'btn white edit')) ?>
      <div class="data-encrypted"><span class="lock"><img src="/img/locked.png" /></span><strong>Your data is secure and encrypted</strong></div>
    </div>
  </div>
  </form>
</div>