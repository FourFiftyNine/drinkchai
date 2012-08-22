<div id="checkout" class="confirm canvas">
    <?php echo $this->element('stripped/checkout_review', array('showDetails' => true)); ?>
    <?php echo $this->Form->create(array('url' => '/orders/confirm')) ?>
    <div class="order-items">
      <table>
        <tr>
          <th class="deal">Deal</th>
          <th class="price">Price</th>
          <th class="quantity">Quantity</th>
          <th class="total">Total</th>
        </tr>
        <tr>
          <td class="deal">
            <div class="deal-details clearfix">
              <?php echo $this->element('global/deal_details'); ?>
            </div>
          </td>
          <td>
            <?php echo $this->Number->currency($data['Deal']['price']) ?>
          </td>
          <td>
            <?php echo $quantity; ?>
          </td>
          <td>
            <?php echo $this->Number->currency($data['Deal']['price'] * $quantity); ?>
          </td>
        </tr>
        <tr class="grand-total-row">
          <td class="billing-info" colspan="2">
            Will be charged to <?php echo $billingName ?> on <?php $cardType ?> ending in <?php $lastFour ?>
          </td>
          <td class="grand-total" colspan="2">Total: <span class="grand-total-amount"><?php echo $this->Number->currency($data['Deal']['price'] * $quantity); ?></span></td>
        </tr>
      </table>
    </div>
    <div class="review-bottom clearfix">
      <?php echo $this->Form->end(array('label' => 'Purchase My Deal', 'class' => 'btn continue gradient green')); ?>
      Your data is secure and encrypted
    </div>
</div>