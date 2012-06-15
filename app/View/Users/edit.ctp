<article id="my-account" class="canvas edit-address clearfix">
    <?php echo $this->element('default/account_navigation'); ?>
    <?php if(2 == $user['User']['user_type_id']): ?>
        <?php echo $this->Form->create('User');?>
        <section id="business-contact-information" class="left">
            <h2 class="gradient brown">Edit Contact Information</h2>
 
                <?php
                    echo $this->Form->input('firstname');
                    echo $this->Form->input('lastname');
                    echo $this->Form->input('email');
                    // echo $this->Form->input('password');
                ?>
        </section>
        <section id="business-information" class="left">
            <h2 class="gradient brown">Edit Business Information</h2>
                <?php
                    echo $this->Form->input('Business.id', array('label' => 'Business Name'));
                    echo $this->Form->input('Business.name', array('label' => 'Business Name'));
                    echo $this->Form->input('Business.description', array('label' => 'Business Description (Used on Deal Page)'));
                    echo $this->Form->input('Business.url_website');
                    echo $this->Form->input('Business.url_facebook');
                    echo $this->Form->input('Business.url_yelp');
                    // echo $this->Form->input('password');
                ?>
   
        </section>
        <section id="business-address" class="left">
            <h2 class="gradient brown">Edit Address</h2>
            <?php 
                echo $this->Form->input('Address.0.id');
                echo $this->Form->input('Address.0.address_one');
                echo $this->Form->input('Address.0.address_two');
                echo $this->Form->input('Address.0.state');
                echo $this->Form->input('Address.0.zip');
                echo $this->Form->input('Address.0.city');
            ?>
        </section>
        <div class="clearfix"></div>
        <?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn white'));?>
    <?php else: ?>
        <section id="personal-information">
            
        </section>
    <?php endif; ?>
</article>


<?php /* ?>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>

        <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
        <li><?php echo $this->Html->link(__('List Users'), array('action' => 'index'));?></li>
        <li><?php echo $this->Html->link(__('List Addresses'), array('controller' => 'addresses', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Address'), array('controller' => 'addresses', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Businesses'), array('controller' => 'businesses', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Business'), array('controller' => 'businesses', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
    </ul>
</div>
*/?>