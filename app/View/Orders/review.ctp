<div id="checkout" class="review canvas">
  <div class="review-top clearfix">
    <div class="product-image left">
      <img width="100" height="100" src="<?php echo $productImage['path_thumb'] ?>" alt="">
    </div>
    <div class="product-information left">
      <h2 class="company-name"><?php echo $data['Business']['name'] ?></h2>
      <h3 class="product-name"><?php echo $data['Deal']['product_name'] ?></h3>
    </div>
  </div>
  <?php echo $this->Form->create(array('url' => '/checkout/payment')) ?>
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