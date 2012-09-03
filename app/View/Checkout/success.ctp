<div id="checkout" class="success-confirmation canvas">
  <h3>Your Order ID is: <?php echo $orderID ?></h3>
  <p>You will receive an email shortly with your order details shortly. Please keep it for your records</p>
  <p>When your order ships, we will email you with tracking information.</p>
  <p>Thank you for shopping at DrinkChai!</p>
  <?php echo $this->Html->link("View Your Account", '/account', array('class' => 'btn white')); ?>
</div>