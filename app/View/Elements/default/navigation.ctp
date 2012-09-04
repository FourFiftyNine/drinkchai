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
              
                <li><?php echo $this->Html->link('Are you a Business?', '/businesses/how-it-works', array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link('How It Works', '/how-it-works', array('escape' => false)); ?></li>
                <?php if(isset($user['User'])): ?>
                    <li class="name">
                        <?php if ('business' == $user['User']['user_type']): ?>
                            <?php echo $this->Html->link($user['Business']['name'] . ' <span class="account-button"></span>', '/account', array('escape' => false, 'class' => 'ajax-link account-name')); ?> 

                        <?php else: ?>
                            <?php echo $this->Html->link($user['User']['firstname'] . ' <span class="account-button"></span>' . $user['User']['lastname'], '/account', array('escape' => false, 'class' => 'ajax-link account-name')); ?> 
                        <?php endif; ?>
                        <nav class="sub-menu col">
                            <ul>
                                <li><?php echo $this->Html->link('My Account', '/account', array('class' => 'btn white account')); ?></li>
                                <?php if ('business' == $user['User']['user_type']): ?>
                                    <li><?php echo $this->Html->link('My Deals', '/account/deals', array('class' => 'btn white')); ?></li>
                                <?php else: ?>

                                    <li><?php echo $this->Html->link('My Orders', '/account/orders', array('class' => 'btn white account')); ?></li>
                                <?php endif; ?>
                                    <li><?php echo $this->Html->link('Logout', '/users/logout', array('escape' => false, 'class' => 'logout btn white')); ?></li>
                            </ul>
                        </nav>
                        
                    </li>
                <?php else: ?>
                    <li><?php echo $this->Html->link('Login', '/users/login', array('escape' => false, 'class' => 'login')); ?></li>
                    <li><?php echo $this->Html->link('Sign Up', '/users/sign-up', array('escape' => false, 'class' => '')); ?></li>
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
            'https://www.facebook.com/pages/DrinkChai/239368896145935', 
            array('escape' => false, 'class' => 'facebook', 'target' => '_blank')
            ); 
            ?>
            <?php echo $this->Html->link(
            $this->Html->image('tag_twitter.png', array('alt'=> __('We help you find and buy tea. DrinkChai.com', true), 'border' => '0', 'class' => 'logo')),
            'https://twitter.com/drink_chai', 
            array('escape' => false, 'class' => 'twitter', 'target' => '_blank')
            ); 
            ?>

        </aside>
    </div>
</header>
