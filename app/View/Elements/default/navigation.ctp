<header id="header">
    <div class="container">
        <h1>
            <?php echo $this->Html->link(
                $this->Html->image('logo-small.png', array('alt'=> __('We help you find and buy tea. DrinkChai.com', true), 'border' => '0', 'class' => 'logo')),
                    '/',
                    array('escape' => false)
                    );
            ?>
        </h1>
        <nav id="main-nav" class="clearfix">
            <ul>
                <?php //<li> echo $this->Html->link('Deals', '/deals', array('escape' => false)); </li>?>
                <?php // <li>echo $this->Html->link('Create', '/dashboard/deals/create', array('escape' => false));</li> ?>

                <?php //debug($user['User']['User']); ?>
                <?php if (isset($user['User']) && 2 == $user['User']['user_type_id']): ?>
                    <li><?php echo $this->Html->link('Businesses - How It Works', '/businesses/how-it-works', array('escape' => false)); ?></li>
                <?php else: ?>
                    <li><?php echo $this->Html->link('How It Works', '/how-it-works', array('escape' => false)); ?></li>
                <?php endif; ?>
                <?php if(isset($user['User'])): ?>
                    <li class="name">
                        <?php if (2 == $user['User']['user_type_id']): ?>
                            <?php echo $this->Html->link($business['name'] . ' <span class="account-button"></span>', '/account', array('escape' => false, 'class' => 'ajax-link account-name')); ?> 

                        <?php else: ?>
                            <?php echo $this->Html->link($user['User']['firstname'] . ' <span class="account-button"></span>' . $user['User']['lastname'], '/account', array('escape' => false, 'class' => 'ajax-link account-name')); ?> 
                        <?php endif; ?>
                        <nav class="sub-menu col">
                            <ul>
                                <li><?php echo $this->Html->link('My Account', '/account', array('class' => 'btn white account')); ?></li>
                                <?php if ($user['User']['user_type_id'] == 2): ?>
                                    <li><?php echo $this->Html->link('My Deals', '/account/deals', array('class' => 'btn white')); ?></li>
                                <?php else: ?>

                                    <li><?php echo $this->Html->link('Your Rewards', '/account/rewards', array('class' => 'btn white rewards')); ?></li>
                                    <li><?php echo $this->Html->link('Invite friends', '/account/invite', array('class' => 'btn white invite')); ?></li>
                                    <li><?php echo $this->Html->link('My Account', '/account', array('class' => 'btn white account')); ?></li>
                                <?php endif; ?>
                                    <li><?php echo $this->Html->link('Logout', '/users/logout', array('escape' => false, 'class' => 'logout btn white')); ?></li>
                            </ul>
                        </nav>
                        
                    </li>
                <?php else: ?>
                    <?php /*
                    <div id="" class="account-box clearfix">
                        <div class="login form">
                        <?php echo $this->Form->create('User', array('action' => 'login'));?>
                            <?php
                                echo $this->Form->input('email');
                                echo $this->Form->input('password');
                            ?>
                        <?php echo $this->Form->end(__('Submit'), array('class' => 'btn white'));?>
                        </div>
                    </div>
                    <?php echo $this->Html->image('ropes.png',  array('border' => '0', 
                    'class' => 'ropes top')) ?>
                    <?php echo $this->Html->image('ropes.png',  array('border' => '0', 
                'class' => 'ropes middle')) ?>
                    <div class="facebook">
                        <button class="sign-in-with-facebook">Sign In with Facebook</button>
                    </div>
                    */ ?>
                    <li><?php echo $this->Html->link('Login', '/users/login', array('escape' => false, 'class' => 'login')); ?></li>
                    <li><?php echo $this->Html->link('Sign Up', '/users/sign-up', array('escape' => false, 'class' => '')); ?></li>
                    <?php //echo $this->element('login_box'); ?>
                <?php endif; ?>
            </ul>
            <div class="sub-menu">
                <div id="" class="account-box clearfix">
                    <div class="login form">
                    <?php echo $this->Form->create('User', array('action' => 'login'));?>
                        <?php
                            echo $this->Form->input('email');
                            echo $this->Form->input('password');
                        ?>
                    <?php echo $this->Form->end(__('Submit'), array('class' => 'btn white'));?>
                    </div>
                </div>
                <?php echo $this->Html->image('ropes.png',  array('border' => '0', 
                'class' => 'ropes top')) ?>
                <?php echo $this->Html->image('ropes.png',  array('border' => '0', 
            'class' => 'ropes middle')) ?>
                <div class="facebook">
                    <button class="sign-in-with-facebook">Sign In with Facebook</button>
                </div>

            </div>
        </nav>
        <aside class="green-tag">
            <?php echo $this->Html->link(
            $this->Html->image('tag_facebook.png', array('alt'=> __('We help you find and buy tea. DrinkChai.com', true), 'border' => '0', 'class' => 'logo')),
            '/', 
            array('escape' => false, 'class' => 'facebook')
            ); 
            ?>
        </aside>
    </div>
</header>
