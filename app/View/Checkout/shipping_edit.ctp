<div id="checkout" class="shipping-edit canvas clearfix">
  <?php echo $this->element('stripped/checkout_top', array('showDetails' => true)); ?>
  <div class="address-form-half">
    <?php echo $this->Form->create('User', array('url' => '/checkout/shipping/edit')); ?>

      <h2 class="gradient brown">Shipping Address</h2>
      <?php 
        if ($this->Form->isFieldError('ShippingAddress.user_id')):
            echo $this->Form->error('ShippingAddress.user_id', null, array('class' => 'no-input-error error-message'));
        endif;
       ?>
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
      <div class="checkout-bottom clearfix">
        <?php echo $this->Form->submit('Continue', array('label' => 'Continue', 'class' => 'btn continue gradient green')); ?>
      </div>
  </div>

</div>