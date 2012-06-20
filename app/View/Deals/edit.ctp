<article id="my-account" class="canvas edit-deal">
  <?php echo $this->element('default/account_navigation', array('data' => $this->data)); ?>
  <section id="edit-deal">
    <h2 class="gradient brown">Edit Your Deal</h2>
    <div class="clearfix">
    <?php echo $this->Form->create('Deal', array('type' => 'file'));?>
      <div class="left">
        <?php 
          echo $this->Form->input('id');
          echo $this->Form->input('Business.name', array('label' => 'Your Company\'s Name'));
          echo $this->Form->input('Business.description', array('label' => 'Your Company\'s Description'));

          echo $this->Form->input('product_name');
          echo $this->Form->input('product_description');
          echo $this->Form->input('Image.file', array('type' => 'file', 'label' => 'Upload tea / product Images'));
         ?>
        <label class="title" for="">Currently Uploaded Pictures</label>
        <div class="pictures fieldset clearfix">
          <?php if( !empty($this->data['Image']) ): ?>
            <?php foreach($this->data['Image'] as $image): ?>
              <?php if ($image['deleted']) { continue; } ?>
                <div class="column">
                  <div class="picture-container">
                    <img src="<?php echo $image['path_thumb']?>" alt="">
                  </div>
                  <?php echo $this->Html->link('Delete', array('controller' => 'images', 'action' => 'delete', $image['id']), array('class' => 'delete-image btn white delete')); ?>
                </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No pictures uploaded.</p>
          <?php endif; ?>
        </div>
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

          //echo $this->Form->input('slug');
        ?>
      </div>
    <?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn white'));?>
    <?php echo $this->Form->postLink(__('Delete Deal'), array('action' => 'delete', $this->Form->value('Deal.id')), array('class'=>'btn white delete deal'), __('Are you sure you want to delete "%s?"', $this->Form->value('Deal.product_name'))); ?>
  </div>
  </section>
</article>