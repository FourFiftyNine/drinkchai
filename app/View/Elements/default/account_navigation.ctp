<header class="clearfix">
    <h1 class="wood">
        <span>
            <?php if (2 == $user['User']['user_type_id']): ?>
                <?php echo __($user['Business']['name']); ?>
            <?php else: ?>
                <?php echo __('My Account'); ?>
            <?php endif; ?>
        </span>
    </h1>
    <?php if (2 == $user['User']['user_type_id']): ?>
    <a href="/account/deals/create" class="btn white large create-a-deal">Create A Deal</a>
    <?php endif ?>
    <nav class="gradient green clearfix" id="account">
        <ul>
        <?php if (2 == $user['User']['user_type_id']): ?>
            <li><?php echo $this->Html->activeLink('Dashboard', '/account'); ?></li>
            <li><?php echo $this->Html->activeLink('My Deals', '/account/deals'); ?></li>
            <li><?php echo $this->Html->activeLink('My Orders', '/account/create'); ?></li>
            <li><?php echo $this->Html->activeLink('Edit Business', '/account/edit'); ?></li>
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