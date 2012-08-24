<div id="checkout-steps" class="canvas clearfix">
  <ul>
    <li class="login"><span>Log In</span>&nbsp;&nbsp;&raquo;</li>
    <li class="review<?php echo ($this->params['action'] == 'review') ? ' active' : '' ?>"><span>Select Options</span>&nbsp;&nbsp;&raquo; </li>
    <li class="address<?php echo ($this->params['action'] == 'address' || $this->params['action'] == 'shipping_edit') ? ' active' : '' ?>"><span>Address</span>&nbsp;&nbsp;&raquo;</li>
    <li class="payment-step<?php echo ($this->params['action'] == 'payment' || $this->params['action'] == 'payment_edit') ? ' active' : '' ?>"><span>Payment</span>&nbsp;&nbsp;&raquo;</li>
    <li class="confirm<?php echo ($this->params['action'] == 'confirm') ? ' active' : '' ?>"><span>Confirm Purchase</span></li>
    <?php /* ?>
    <li class="confirm<?php echo ($this->params['action'] == 'confirm') ? ' active' : '' ?>"><span>Confirm Purchase</span></li> */ ?>
  </ul>
</div>
