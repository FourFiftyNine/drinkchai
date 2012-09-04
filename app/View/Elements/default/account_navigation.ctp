<header class="clearfix">
    <h1 class="wood">
        <span>
            <?php if ('business' == $user['User']['user_type']): ?>
                <?php echo __($user['Business']['name']); ?>
            <?php else: ?>
                <?php echo __('My Account'); ?>
            <?php endif; ?>
        </span>
    </h1>
    <?php if ('business' == $user['User']['user_type']): ?>

        <?php if('edit' == $this->params['action'] && 'deals' == $this->params['controller']): ?>
            <a href="/account/deals/preview/<?php echo $data['Deal']['id']; ?>" target="_blank" class="btn white large create-a-deal">Preview This Deal</a>
        <?php else: ?>
            <a href="/account/deals/create" class="btn white large create-a-deal">Create A Deal</a>
        <?php endif; ?>
    <?php endif ?>
    <nav class="gradient green clearfix" id="account">
        <ul>
        <?php if ('business' == $user['User']['user_type']): ?>
            <li><?php echo $this->Html->activeLink('Dashboard', '/account'); ?></li>
            <li><?php echo $this->Html->activeLink('My Deals', '/account/deals'); ?></li>
            <!-- <li><?php echo $this->Html->activeLink('My Orders', '/account/create'); ?></li> -->
            <li><?php echo $this->Html->activeLink('Edit Business', '/account/edit'); ?></li>
        <?php elseif ('admin' == $user['User']['user_type']): ?>
            
        <?php else: ?>
            <li><?php echo $this->Html->activeLink('Account', '/account', array('class' =>  (($this->params['action'] == 'index') ? 'active' : ''))); ?></li>
            <?php /*
            <li><?php echo $this->Html->link('Rewards', '/account/rewards'); ?></li>
            <li><?php echo $this->Html->link('Invite', '/account/invite'); ?></li>
            */ ?>
            <li><?php echo $this->Html->activeLink('My Orders', '/account/orders'); ?></li>
            <li><?php echo $this->Html->activeLink('Edit Account', '/account/edit'); ?></li>
        <?php endif; ?>

        </ul>
    </nav>
</header>