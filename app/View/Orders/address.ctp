<div id="checkout" class="address canvas clearfix">
  <?php echo $this->Form->create('User', array('url' => '/orders/submit_address')); ?>
  <div class="left">
    <h2 class="gradient brown">Shipping Address</h2>
      <?php 
        echo $this->Form->input('Address.0.id');
        echo $this->Form->input('Address.0.address_one');
        echo $this->Form->input('Address.0.address_two');
        echo $this->Form->input('Address.0.state');
        echo $this->Form->input('Address.0.zip');
        echo $this->Form->input('Address.0.city');
        echo $this->Form->hidden('Address.1.type', array('value' => 'shipping'));

      ?>
  </div>
  <div class="left">
    <h2 class="gradient brown">Billing Address</h2>
      <?php 
        echo $this->Form->input('Address.1.id');
        echo $this->Form->input('Address.1.address_one');
        echo $this->Form->input('Address.1.address_two');
        echo $this->Form->input('Address.1.state');
        echo $this->Form->input('Address.1.zip');
        echo $this->Form->input('Address.1.city');
        echo $this->Form->hidden('Address.1.type', array('value' => 'billing'));
      ?>
  </div>
  <?php echo $this->Form->end(array('label' => 'Continue', 'class' => 'btn green gradient')); ?>
</div>
