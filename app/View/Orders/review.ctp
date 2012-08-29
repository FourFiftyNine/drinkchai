<div id="checkout" class="review canvas">
  <?php echo $this->element('stripped/checkout_top', array('showDetails' => false)); ?>
  <?php echo $this->Form->create(array('url' => '/checkout/review')) ?>
  <h2 class="gradient brown">Select Options</h2>
  <div class="order-items">
    <table>
      <tr>
        <th class="deal-details left-align">Deal</th>
        <th class="price center-align">Price</th>
        <th class="quantity center-align">Quantity</th>
      </tr>
      <tr>
        <td class="deal-details left-align">
            <?php echo $this->element('global/deal_details'); ?>
        </td>
        <td>
          <?php echo $this->Number->currency($data['Deal']['price']) ?>
        </td>
        <td>
          <?php echo $this->Form->select('quantity', array('1' => '1', '2' => '2'), array('empty' => false, 'data-price' => '12.00')); ?>
        </td>
      </tr>
    </table>
  </div>
  <div class="checkout-bottom clearfix">
    <?php echo $this->Form->end(array('label' => 'Continue', 'class' => 'btn continue gradient green')); ?>
    <div class="total">Total: <span class="dollars"><?php echo $this->Number->currency($data['Deal']['price'] * $this->data['Order']['quantity']) ?></span></div>
  </div>
</div>