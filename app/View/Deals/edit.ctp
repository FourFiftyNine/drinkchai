<article id="my-account" class="canvas edit-deal">
  <?php echo $this->element('default/account_navigation', array('data' => $this->data)); ?>
  <section id="edit-deal">
    <h2 class="gradient brown"><?php echo $this->params['action'] == 'create' ? 'Create' : 'Edit'; ?> Your Deal</h2>
    <div class="clearfix">
    <?php echo $this->Form->create('Deal', array('type' => 'file'));?>
      <?php if( $this->params['action'] == 'edit' ): ?>
        <div id="pictures-container" class="pictures fieldset clearfix">

          <?php echo $this->Form->input('Image.file', array(
              'type'     => 'file',
              'label'    => 'Upload one or many photos.  Photos will be uploaded and saved immediately. File format: jpg, jpeg, and pngs only',
              'id'       => 'fileupload',
              'data-url' => '/images/uploader',
              'multiple' => 'multiple'
              ));
           ?>
          <label class="title" for="">Currently Uploaded Pictures</label>
          <?php if( !empty($this->data['Image']) ): ?>
            <label>Featured image (first image) is highlighted in green.</label>
            <?php foreach($this->data['Image'] as $image): ?>
              <?php if ($image['deleted'] || $image['is_logo']): continue; endif; ?>
                <div class="column<?php echo $image['featured'] ? ' featured' : '' ?>">
                  <div class="picture-container">
                    <img src="<?php echo $image['path_thumb']?>" alt="">
                  </div>
                  <?php echo $this->Html->link('X', array('controller' => 'images', 'action' => 'delete', $image['id']), array('class' => 'delete-image btn white delete')); ?>
                  <?php echo $this->Html->link('Feature Image', array('controller' => 'images', 'action' => 'feature', $image['id']), array('class' => 'btn white feature')); ?>
                  <div class="featured-text">Featured</div>
                </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="no-pictures">No photos uploaded.</p>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <div class="left">
        <?php 
          echo $this->Form->input('id');
          echo $this->Form->input('Business.id');
          echo $this->Form->input('Business.name', array('label' => 'Your Company\'s Name'));
          echo $this->Form->input('Image.logo', array(
              'type'     => 'file',
              'label'    => 'Company Logo',
              'id'       => 'logoupload',
              'data-url' => '/images/uploader'
              ));
        ?>
        <div id="logo-container" class="pictures fieldset clearfix">

        <?php if(isset($logo)): ?>
          <div class="picture-container company-logo-container">
            <img src="<?php echo $logo['path_resized']?>"  alt="">
          </div>
        <?php endif; ?>
      </div>
        <?php  
          echo $this->Form->input('Business.description', array('label' => 'Your Company\'s Description'));

          echo $this->Form->input('product_name');
          echo $this->Form->input('product_description');

          // Multiple default - no good right now
          // echo $this->Form->input('Image.file', array('type' => 'file', 'label' => 'Upload tea / product Images', 'multiple' => 'multiple', 'name' => 'data[Image][file][]'));

          // NORMAL
          // echo $this->Form->input('Image.file', array('type' => 'file', 'label' => 'Upload tea / product Images'));
          ?>
      </div>
      <div class="right">
        <?php
          echo $this->Form->input('original_price', array('type' => 'text'));
          echo $this->Form->input('price', array('type' => 'text', 'label' => 'Discounted Price'));
          // echo $this->Form->input('discount', array('label' => 'Calculated Discount', 'disabled' => true, 'type' => 'text'));
        ?>

        <div class="date-section">
          <label class="title">When would you like your deal to begin?</label>
          <div class="fieldset">
            <?php
              echo $this->Form->input('start_date');
              echo $this->Form->input('start_time');
            ?>
          </div>
        </div>
        <div class="date-section">
          <label class="title">When would you like deal to end?</label>
          <div class="fieldset">
            <?php
              echo $this->Form->input('end_date');
              echo $this->Form->input('end_time');
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
    <?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn white'));?>
    <?php echo $this->Form->postLink(__('Delete Deal'), array('action' => 'delete', $this->Form->value('Deal.id')), array('class'=>'btn white delete deal'), __('Are you sure you want to delete "%s?"', $this->Form->value('Deal.product_name'))); ?>
  </div>
  </section>
</article>
<script id="pictures-container-content" type="text/x-tmpl">
  <div class="column">
    <div class="picture-container">
      <img src="{%=o.path_thumb%}" alt="">
    </div>
    <a href="/images/delete/{%=o.id%}" class="delete-image btn white delete">X</a>
    {% if (!o.is_logo) { %}<a href="/images/feature/{%=o.id%}" class="btn white feature">Feature Photo</a>{% } else { %}LOGO{% } %}
    <div class="featured-text">Featured</div>
  </div>
</script>
<script id="logo-container-content" type="text/x-tmpl">
    <div class="picture-container">
      <img src="{%=o.path_resized%}" alt="">
    </div>
</script>