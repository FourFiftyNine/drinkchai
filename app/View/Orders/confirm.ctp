<div id="checkout" class="confirm canvas">
    <?php echo $this->element('stripped/checkout_review', array('showDetails' => true)); ?>
    <?php echo $this->Form->create(array('url' => '/checkout/confirm')) ?>
    <h2 class="gradient brown">Purchase</h2>
    <div class="order-items">
      <table>
        <tr>
          <th class="deal-details">Deal</th>
          <th class="price">Price</th>
          <th class="quantity">Quantity</th>
          <th class="total">Total</th>
        </tr>
        <tr>
          <td class="deal-details">
            <?php echo $this->element('global/deal_details'); ?>
          </td>
          <td>
            <?php echo $this->Number->currency($data['Deal']['price']) ?>
          </td>
          <td>
            <?php echo $quantity; ?>
          </td>
          <td class="total">
            <?php echo $this->Number->currency($data['Deal']['price'] * $quantity); ?>
          </td>
        </tr>
        <tr class="grand-total-row">
          <td class="billing-info" colspan="2">
            Will be charged to <strong><?php echo $billingFirstname . ' ' . $billingLastname ?></strong> on <strong><?php echo $cardType ?></strong> ending in <strong><?php echo $lastFour ?></strong>
          </td>
          <td class="grand-total" colspan="2">Total: <span class="grand-total-amount"><?php echo $this->Number->currency($data['Deal']['price'] * $quantity); ?></span></td>
        </tr>
      </table>
    </div>

    <div class="review-bottom clearfix">
      <h3 class="gradient brown">Shipping</h3 class="gradient brown"> <br /> 
      <div class="left shipping-address">
            <?php $shAdd = $shippingAddress['ShippingAddress']; ?>
            <?php echo $shAdd['firstname'] . ' ' . $shAdd['lastname']?> <br />
            <?php echo $shAdd['address_one'] ?> <br />
            <?php echo ($shAdd['address_two']) ? $shAdd['address_two'] . '<br />' : '' ?>
            <?php echo $shAdd['city'] . ', ' . $shAdd['state'] . ' ' . $shAdd['zip'];   ?> <br />
      </div>
      <div class="right purchase">
        <?php echo $this->Form->end(array('label' => 'Purchase My Deal', 'class' => 'btn continue gradient green purchase-my-deal')); ?>
        <div><strong>Your data is secure and encrypted</strong></div>
      </div>
    </div>
</div>