<article id="my-account" class="canvas edit-deal">
  <?php echo $this->element('default/account_navigation', array('data' => $this->data)); ?>
  <section id="edit-deal">
    <h2 class="gradient brown"><?php echo $this->params['action'] == 'create' ? 'Create' : 'Edit'; ?> Your Deal</h2>
      <?php echo $this->Form->create('Deal', array('type' => 'file'));?>
      <?php if( $this->params['action'] == 'edit'): ?>
      <div class="file-upload-error"></div>
        <div id="product-image" class="fieldset image-container left">
          <?php echo $this->Form->input('Image.file', array(
              'type'     => 'file',
              'label'    => 'Product Image',
              'id'       => 'fileupload',
              'data-url' => '/images/uploader'
              ));
          ?>
          <div class="percent loaded-product hidden"><span class="number"></span>%</div>
          <div class="product-image-container image">
          <?php if(isset($productImage)): ?>
              <img src="<?php echo $productImage['path_resized']?>"  alt="">
          <?php endif; ?>
          </div>

        </div>
      
      <div id="logo-image" class="image-container fieldset right">
      <?php
        echo $this->Form->input('Image.logo', array(
            'type'     => 'file',
            'label'    => 'Company Logo',
            'id'       => 'logoupload',
            'data-url' => '/images/uploader'
            ));
      ?>
        <div class="percent loaded-logo hidden"><span class="number"></span>%</div>
        <div class="company-logo-container image">
        <?php if(isset($logo)): ?>
            <img src="<?php echo $logo['path_resized']?>"  alt="">
        <?php endif; ?>
        </div>

      </div>
    <?php endif; ?>
      <div class="clearfix"></div>
      <div class="left">
        <?php 
          echo $this->Form->input('Business.id');
          echo $this->Form->input('Deal.id');
          echo $this->Form->input('Business.name', array('label' => 'Your Company\'s Name'));
          echo $this->Form->input('Business.description', array('label' => 'Your Company\'s Description'));
          echo $this->Form->input('Deal.product_name');
          echo $this->Form->input('Deal.product_description');
          ?>
      </div>
      <div class="right">
        <?php
          echo $this->Form->input('Deal.original_price', array('type' => 'text'));
          echo $this->Form->input('Deal.price', array('type' => 'text', 'label' => 'Discounted Price'));
          // echo $this->Form->input('discount', array('label' => 'Calculated Discount', 'disabled' => true, 'type' => 'text'));
        ?>

        <div class="date-section">
          <label class="title">When would you like your deal to begin?</label>
          <div class="fieldset">
            <?php
              echo $this->Form->input('Deal.start_date');
              echo $this->Form->input('Deal.start_time');
            ?>
          </div>
        </div>
        <div class="date-section">
          <label class="title">When would you like deal to end?</label>
          <div class="fieldset">
            <?php
              echo $this->Form->input('Deal.end_date');
              echo $this->Form->input('Deal.end_time');
            ?>
          </div>
        </div>
        <?php
          echo $this->Form->input('minimum', array('label' => 'Minimum you want to sell before deal unlocks', 'type' => 'text'));
          echo $this->Form->input('limit', array('label' => 'Maximum you want to sell', 'type' => 'text'));
          /*
          echo $this->Form->input('Business.url_website', array('label' => 'Website Url'));
          echo $this->Form->input('Business.url_facebook', array('label' => 'Facebook Url'));
          echo $this->Form->input('Business.url_twitter', array('label' => 'Twitter Url'));
          echo $this->Form->input('Business.url_yelp', array('label' => 'Yelp Url'));
          */
          //echo $this->Form->input('slug');
        ?>
      </div>
      <div id="product-details-container">
        <label class="title">Product Details</label>
        <?php 
          echo $this->Form->input('Deal.product_detail_1', array('label' => 'Product Detail 1', 'placeholder' => 'e.g. 12 Teabags / 24 oz loose leaf tea'));
          echo $this->Form->input('Deal.product_detail_2', array('label' => 'Product Detail 2', 'placeholder' => 'e.g. Rooibos, crushed green cardamom, cardamom seeds and vanilla flavor'));
          echo $this->Form->input('Deal.product_detail_3', array('label' => 'Product Detail 3', 'placeholder' => 'e.g. 12 Teabags / 24 oz loose leaf tea'));
          echo $this->Form->input('Deal.product_detail_4', array('label' => 'Product Detail 4', 'placeholder' => 'e.g. 12 Teabags / 24 oz loose leaf tea'));
          echo $this->Form->input('Deal.product_detail_5', array('label' => 'Product Detail 5', 'placeholder' => 'e.g. 12 Teabags / 24 oz loose leaf tea'));
         ?>
      </div>
    <?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn white'));?>
    <?php echo $this->Form->postLink(__('Delete Deal'), array('action' => 'delete', $this->Form->value('Deal.id')), array('class'=>'btn white delete deal'), __('Are you sure you want to delete "%s?"', $this->Form->value('Deal.product_name'))); ?>
  </div>
  </section>
</article>