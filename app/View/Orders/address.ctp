<div id="checkout" class="address canvas clearfix">
  <?php echo $this->element('stripped/checkout_review', array('showDetails' => true)); ?>
  <?php echo $this->Form->create('User', array('url' => '/checkout/address')); ?>
  <div class="left">

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

        // echo $this->Form->input('Address.1.state',array('type'=>'select','options'=>$states));

        // echo $this->Form->hidden('Address.1.type', array('value' => 'billing'));
      ?>
  </div>
  <div class="left">
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
  </div>
  <?php echo $this->Form->end(array('label' => 'Continue', 'class' => 'btn green gradient')); ?>
</div>
