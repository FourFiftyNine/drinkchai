<header>
    <h1>
        <?php echo $this->Html->link(
            $this->Html->image('logo_small_white.png', array('alt'=> __('We help you find and buy tea. DrinkChai.com', true), 'border' => '0', 'class' => 'logo')),
                '/',
                array('escape' => false)
                );
        ?>
    </h1>
    <nav class="clearfix">
        <ul>
            <li <?php echo ($this->params['controller'] == 'deals')? 'class="active"': ""; ?>><?php echo $this->Html->link('Deals', '/deals', array('escape' => false)); ?></li>
            <li <?php echo (isset($this->params['pass'][0]) && $this->params['pass'][0]=='how_it_works')? 'class="active"': ""; ?>><?php echo $this->Html->link('How It Works', '/how-it-works', array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link('Create', '/dashboard/deals/create', array('escape' => false)); ?></li>
            <?php if($user): ?>
                <span class="name"><?php echo $user['User']['firstname'] . ' ' . $user['User']['lastname']; ?><span class="account-button"></span></span>
                <div class="account-box">

                    <?php echo $this->Html->link('View Profile', '/me', array('escape' => false, 'class' => 'btn white')); ?>
                    <?php echo $this->Html->link('Edit Profile', '/me/edit', array('escape' => false, 'class' => 'btn white')); ?>
                    <?php echo $this->Html->link('View Past Orders', '/me/orders', array('escape' => false, 'class' => 'btn white')); ?>

                </div>
                <?php echo $this->Html->link('Logout', '/users/logout', array('escape' => false)); ?>
            <?php else: ?>
                <li><?php echo $this->Html->link('Sign Up', '/users/sign-up', array('escape' => false, 'class' => '')); ?></li>
                <li><?php echo $this->Html->link('Login', '/users/login', array('escape' => false, 'class' => '')); ?></li>
               
                <?php //echo $this->element('login_box'); ?>
            <?php endif; ?>
        </ul>
    </nav>
    <?php /* ?>
    <aside class="tag">
        <?php echo $this->Html->link(
        $this->Html->image('tag_facebook.png', array('alt'=> __('We help you find and buy tea. DrinkChai.com', true), 'border' => '0', 'class' => 'logo')),
        '/', 
        array('escape' => false, 'class' => 'facebook')
        ); 
        ?>
    </aside>
    */ ?>
</header>
