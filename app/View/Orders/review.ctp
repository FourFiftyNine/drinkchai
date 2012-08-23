<div id="checkout" class="review canvas">
  <?php echo $this->element('stripped/checkout_review', array('showDetails' => false)); ?>
  <?php echo $this->Form->create(array('url' => '/checkout/review')) ?>
  <h2 class="gradient brown">Select Options</h2>
  <div class="order-items">
    <table>
      <tr>
        <th class="deal-details">Deal</th>
        <th class="price">Price</th>
        <th class="quantity">Quantity</th>
      </tr>
      <tr>
        <td class="deal-details">
            <?php echo $this->element('global/deal_details'); ?>
        </td>
        <td>
          <?php echo $this->Number->currency($data['Deal']['price']) ?>
        </td>
        <td>
          <?php echo $this->Form->select('quantity', array('1' => '1', '2' => '2'), array('empty' => false)); ?>
        </td>
      </tr>
    </table>
  </div>
  <div class="review-bottom clearfix">
    <?php echo $this->Form->end(array('label' => 'Continue', 'class' => 'btn continue gradient green')); ?>
    <div class="total">Total: <?php echo $this->Number->currency($data['Deal']['price'] * $this->data['Order']['quantity']) ?></div>
  </div>
</div>