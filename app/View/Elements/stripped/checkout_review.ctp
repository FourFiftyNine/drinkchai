  <div class="review-top clearfix">
    <div class="product-image left">
      <img width="100" height="100" src="<?php echo $productImage['path_thumb'] ?>" alt="">
    </div>
    <div class="product-information left">
      <h2 class="company-name"><?php echo $data['Business']['name'] ?></h2>
      <h3 class="product-name"><?php echo $data['Deal']['product_name'] ?></h3>
    </div>
    <?php if ($showDetails): ?>
      <div class="deal-details clearfix left">
        <?php echo $this->element('global/deal_details'); ?>
      </div>
    <?php endif; ?>
  </div>