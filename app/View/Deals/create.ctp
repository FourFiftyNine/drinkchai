<article id="my-account" class="canvas create-deal">
    <?php echo $this->element('default/account_navigation'); ?>
        <section id="business-information">
            <h2 class="gradient brown">Create a Deal</h2>
            <div class="content" >
                <?php echo $this->Form->create('Deal', array('class' => 'clearfix'));?>
                    <?php 
                        // echo $this->Form->input('Business.name', array('label' => 'Your Company\'s Name', 'value' => $Business['name']));
                    ?>
                        <?php //echo $this->Form->input('name', array('label' => 'Name of your deal')); ?>
                        <?php echo $this->Form->input('product_name', array('label' => 'Name of the tea / product you are selling.', 'div' => array('class' => 'full input text'))); ?> 
                        <div class="example">Example: <strong>Osmanthus</strong></div>
                        <?php //echo $this->Form->input('tagline', array('label' => 'Deal Tagline')); ?>
                        <?php echo $this->Form->input('product_description', array('label' => 'Tea / Product Description', 'type' => 'textarea','div' => array('class' => 'full input text'))); ?>

                        <?php echo $this->Form->input('original_price', array('type' => 'text', 'div' => array('class' => 'small input text'))); ?>

                        <?php echo $this->Form->input('price', array('label' => 'Discounted Price', 'type' => 'text', 'div' => array('class' => 'small input text'))); ?>


                        <?php echo $this->Form->input('minimum', array('label' => 'How many deals need to sell until deal unlocks?', 'type' => 'text', 'div' => array('class' => 'small input text'))); ?>

                        <?php echo $this->Form->input('limit', array('label' => 'What is the maximum amount of products do you want to sell?', 'type' => 'text', 'div' => array('class' => 'small input text'))); ?>
                        <?php if(3 == $user['User']['user_type_id']): ?>
                            <?php echo $this->Form->input('slug'); ?>
                            <?php echo $this->Form->input('discount', array('label' => 'Calculated Discount (% percentage)', 'disabled' => true)); ?>
                            <?php echo $this->Form->input('start_date', array('label' => '')); ?>
                            <?php echo $this->Form->input('start_time'); ?>
                            <?php echo $this->Form->input('end_date'); ?>
                            <?php echo $this->Form->input('end_time'); ?>
                        <?php endif; ?>
                <?php echo $this->Form->end(array('label' => __('Create'), 'class' => 'btn white'));?>
            </div>
        </section>
</article>