<header class="clearfix">
    <h1 class="wood">
        <span>
            <?php if (2 == $user['User']['user_type_id']): ?>
                <?php echo __($business['name']); ?>
            <?php else: ?>
                <?php echo __('My Account'); ?>
            <?php endif; ?>
        </span>
    </h1>
    <nav class="gradient green clearfix" id="account">
        <ul>
            <?php if (2 == $user['User']['user_type_id']): ?>
                <li <?php echo ($this->params['action'] == 'account_index') ? 'class="active"' : ''; ?>><?php echo $this->Html->link('Dashboard', '/account'); ?></li>
                <li><?php echo $this->Html->link('My Deals', '/account/deals'); ?></li>
                <li><?php echo $this->Html->link('My Orders', '/account/create'); ?></li>
                <li><?php echo $this->Html->link('Edit Business', '/account/edit'); ?></li>
            <?php else: ?>
                <li><?php echo $this->Html->link('Rewards', '/account/rewards'); ?></li>
                <li><?php echo $this->Html->link('Invite', '/account/invite'); ?></li>
                <li><?php echo $this->Html->link('My Orders', '/account/orders'); ?></li>
                <li <?php echo ($this->params['action'] == 'account_index') ? 'class="active"' : ''; ?>><?php echo $this->Html->link('Account', '/account'); ?></li>
            <?php endif; ?>

        </ul>
    </nav>
</header>