<div id="checkout" class="address canvas clearfix">
  <?php echo $this->element('stripped/checkout_top', array('showDetails' => true)); ?>
  <?php echo $this->Form->create('User', array('url' => '/checkout/address')); ?>
    <div class="address-form-container clearfix">
      <div class="billing-address address-form-half">
        <h2 class="gradient brown">Billing Address</h2>
        <?php 
          if ($this->Form->isFieldError('BillingAddress.user_id')):
              echo $this->Form->error('BillingAddress.user_id', null, array('class' => 'no-input-error error-message'));
          endif;
         ?>
        <?php 
          echo $this->Form->input('BillingAddress.id', array('type' => 'hidden'));
          echo $this->Form->input('BillingAddress.firstname', array('class' => 'short'));
          echo $this->Form->input('BillingAddress.lastname', array('class' => 'short'));
          echo $this->Form->input('BillingAddress.address_one');
          echo $this->Form->input('BillingAddress.address_two');
          echo $this->Form->input('BillingAddress.city');
          echo $this->Form->input('BillingAddress.state');
          echo $this->Form->input('BillingAddress.zip', array('class' => 'zip', 'div' => array('class' => 'input text zip')));
        ?>
        <div id="same-billing-container">
          <?php
         /* echo $this->Form->checkbox('ShippingAddress.same_as_billing', array(
              'value' => '1',
          )); */ ?>
        <!--   <label for="ShippingAddressSameAsBilling">Same as Billing Address?</label> -->

          <?php echo $this->Form->input('ShippingAddress.same_as_billing', array('label' => 'Same as Billing Address?', 'type' => 'checkbox')); ?>
        </div>
      </div>
      <div class="shipping-address address-form-half">
        <h2 class="gradient brown">Shipping Address</h2>
        <?php 
          if ($this->Form->isFieldError('ShippingAddress.user_id')):
              echo $this->Form->error('ShippingAddress.user_id', null, array('class' => 'no-input-error error-message'));
          endif;
        ?>
        <?php $sameClass = (isset($this->data['ShippingAddress.same_as_billing']) && $this->data['ShippingAddress.same_as_billing'] == true) ? 'class="hidden"' : ''; ?>
        <div id="same-shipping-note" <?php echo $sameClass; ?>>
          Your shipping address is the same as your billing.
        </div>
        <?php $inputsClass = (isset($this->data['ShippingAddress.same_as_billing']) && $this->data['ShippingAddress.same_as_billing'] == false) ? '' : 'class="hidden"'; ?>
        <div id="shipping-inputs" <?php echo $inputsClass; ?>>
          <?php 
            echo $this->Form->input('ShippingAddress.id', array('type' => 'hidden'));
            echo $this->Form->input('ShippingAddress.firstname', array('class' => 'short'));
            echo $this->Form->input('ShippingAddress.lastname', array('class' => 'short'));
            echo $this->Form->input('ShippingAddress.address_one');
            echo $this->Form->input('ShippingAddress.address_two');
            echo $this->Form->input('ShippingAddress.city');
            echo $this->Form->input('ShippingAddress.state');
            echo $this->Form->input('ShippingAddress.zip', array('class' => 'zip', 'div' => array('class' => 'input text zip')));
          ?>
        </div>
      </div>
    </div>
    <div class="checkout-bottom clearfix">
      <?php echo $this->Form->end(array('label' => 'Continue', 'class' => 'btn green gradient')); ?>
    </div>
</div>
