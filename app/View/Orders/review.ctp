<div id="checkout" class="review canvas">
  <?php echo $this->element('stripped/checkout_review', array('showDetails' => false)); ?>
  <?php echo $this->Form->create(array('url' => '/orders/submit_review')) ?>
  <div class="order-items">
    <table>
      <tr>
        <td>
          <div class="deal-details clearfix">
            <?php echo $this->element('global/deal_details'); ?>
          </div>
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
    <div class="total">Total: <?php echo $this->Number->currency($data['Deal']['price']) ?></div>
  </div>
</div>