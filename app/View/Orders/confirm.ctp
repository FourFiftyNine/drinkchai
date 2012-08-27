<div id="checkout" class="confirm canvas">
  <?php echo $this->element('stripped/checkout_top', array('showDetails' => true)); ?>
  <?php echo $this->Form->create(array('url' => '/checkout/confirm')) ?>
  <h2 class="gradient brown">Purchase</h2>
  <div class="order-items">
    <table>
      <tr>
        <th class="deal-details left-align">Deal</th>
        <th class="price">Price</th>
        <th class="quantity">Quantity</th>
        <th class="total right-align">Total</th>
      </tr>
      <tr>
        <td class="deal-details left-align">
          <?php echo $this->element('global/deal_details'); ?>
        </td>
        <td>
          <?php echo $this->Number->currency($data['Deal']['price']) ?>
        </td>
        <td>
          <?php echo $quantity; ?>
        </td>
        <td class="total right-align">
          <?php echo $this->Number->currency($data['Deal']['price'] * $quantity); ?>
        </td>
      </tr>
      <tr class="grand-total-row">
        <td class="billing-info" colspan="3">
          <span class="charged-to">
            Will be charged to <strong><?php echo $billingFirstname . ' ' . $billingLastname ?></strong> on <strong><?php echo $cardType ?></strong> ending in <strong><?php echo $lastFour ?></strong>
          </span>
          <a class="btn white edit change-payment" href="/checkout/payment/edit">change payment</a>
        </td>
        <td class="grand-total" colspan="1">Total: <span class="grand-total-amount"><?php echo $this->Number->currency($data['Deal']['price'] * $quantity); ?></span></td>
      </tr>
    </table>
  </div>

  <div class="checkout-bottom clearfix">
    <h3 class="gradient brown">Shipping <a class="btn white edit" href="/checkout/shipping/edit">Edit</a></h3 class="gradient brown"> <br /> 
    <div class="left shipping-address">
          <?php $shAdd = $shippingAddress['ShippingAddress']; ?>
          <?php echo $shAdd['firstname'] . ' ' . $shAdd['lastname']?> <br />
          <?php echo $shAdd['address_one'] ?> <br />
          <?php echo ($shAdd['address_two']) ? $shAdd['address_two'] . '<br />' : '' ?>
          <?php echo $shAdd['city'] . ', ' . $shAdd['state'] . ' ' . $shAdd['zip'];   ?> <br />
    </div>
    <div class="right purchase">
      <?php echo $this->Form->end(array('label' => 'Purchase My Deal', 'class' => 'btn continue gradient green purchase-my-deal')); ?>
      <div class="data-encrypted"><span class="lock"><img src="/img/locked.png" /></span><strong>Your data is secure and encrypted</strong></div>
    </div>
  </div>
</div>