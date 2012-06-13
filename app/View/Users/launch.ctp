<nav class="shadow-inset" id="main">
    <ul>
        <li><?php echo $this->Html->link('Home', '/', array('id' => 'home', 'class' => 'ajax-link active')); ?></li>
        <!-- <li><?php echo $this->Html->link('About Us', '/about-us', array('id' => 'about-us', 'class' => 'ajax-link')); ?></li> -->
        <li><?php echo $this->Html->link('How It Works', '/how-it-works'); ?></li>
        <!-- <li><?php echo $this->Html->link('Businesses', '/businesses', array('id' => 'businesses', 'class' => 'ajax-link')); ?></li> -->
        <li><?php echo $this->Html->link('Current Deal', '/deals/view');?></li>
        <?php if($user['User']): ?>
        <li><a href="/account">My Account</a></li>
        <!-- <li><a href="<?php echo (!$user['facebook_id']) ? '/users/logout' : '#'; ?>"class="logout">Logout</a></li> -->
        <?php else: ?>
        <li><a href="/login">Login</a></li>
        <li><a href="/sign-up">Sign Up</a></li>
        <?php endif; ?>
    </ul>
</nav>
<section id="bubble-shares" class="addthis">
    <nav class="shadow-inset">
        <div class="fb-like" data-send="false" data-layout="box_count" data-width="" data-show-faces="false"></div>
        <a href="https://twitter.com/share" class="twitter-share-button" data-text="Get great Tea deals at " data-url="http://drinkchai.com" data-via="drink_chai" data-lang="en" data-related="anywhereTheJavascriptAPI" data-count="vertical">Tweet</a>
        <span id="plusone">
            <g:plusone size="tall"></g:plusone>
        </span>
    </nav>
</section>
<aside class="green-tag launch">
    <?php echo $this->Html->link(
    $this->Html->image('tag_facebook.png', array('alt'=> __('We help you find and buy tea. DrinkChai.com', true), 'border' => '0', 'class' => 'logo')),
    '/', 
    array('escape' => false, 'class' => 'facebook')
    ); 
    ?>
</aside>
<section class="ajax-content" id="home-content">
    <section class="submit">
        <hgroup>
            <h1>
            <?php 
            echo $this->Html->link(
                    $this->Html->image('logo_large_white.png', array('alt'=> __('We help you find and buy tea. DrinkChai.com', true), 'border' => '0')), '/', array('escape' => false, 'class' => 'logo')
                );
            ?>
            </h1>
            <h2>We help you <strong>find</strong><?php echo $this->Html->image('ampersand.png', array('alt'=> __('and', true), 'border' => '0')) ?><strong>buy</strong> tea.</h2>
            <h3>You will only receive the best deals around. We promise.</h3>
        </hgroup>
        
        <?php echo $this->Form->create('User', array('action'  => 'launch_submit')); ?>
            <?php echo $this->Form->input('email', array(
                'label'     => false,
                'default'   => 'Enter your e-mail address...',
                'maxlength' => 256,
                'class'     => 'required',
                'tabIndex'  => 0
            )); 
            ?>
            <button class="submit-email"></button>
            <?php echo $this->Form->end(); ?>
    </section>
    <section class="thankyou">
        <hgroup>
            <h2>Thank You!</h2>
            <h3>We will let you know when we launch!</h3>
        </hgroup>
        <?php echo $this->Html->link(
            $this->Html->image('emblem_large.png', array('alt'=> __('We help you find and buy tea. DrinkChai.com', true), 'border' => '0')),
                '/',
                array('escape' => false, 'class' => 'logo')
                );
        ?>
        <div id="twitter-share-container">
            <textarea class="share shadow-inset">Awesome tea deals at DrinkChai.com</textarea>
            <a id="twitter-share" href="http://twitter.com/share">Tweet</a>
        </div>
    </section>
</section>
<section class="ajax-content col clearfix" id="businesses-content">
    <h2 class="tag"><span>Do you sell tea?</span></h2>
    <p class="intro">
    DrinkChai does something supermarket shelves could never do - put your tea front and center with tea drinkers everywhere. Let us show you how.
    </p>

    <p id="message"></p>
    <?php echo $this->Form->create('Business', array('action'  => 'launch_submit', 'default' => false)); ?>
    <?php echo $this->Form->input('email', array(
        'label'     => false,
        'default'   => 'Enter your e-mail address...',
        'maxlength' => 256,
        'class'     => 'required default-value',
        'tabIndex'  => 0
    )); 
    ?>
    <?php echo $this->Form->submit('Submit', array('id' => 'business-submit')); ?>
    <?php // echo $this->Js->submit('Submit', array('url'=> array('controller'=>'businesses', 'action'=>'launch_submit'), 'update' => '#message', 'success' => debug($this->data))); ?>
    
<!--     <h3 class="gradient green">Create Your Deal</h3>
    <p>
    As any trip down a tea aisle will show, picking the “right” tea can be a daunting task. That’s why we handpick our deals and deliver them right to your inbox. 
    </p>
    <h3 class="gradient green">Launch Your Deal</h3>
    <p>
    At DrinkChai, our goal is to introduce people to teas they’ve never tried while making the process as easy as possible. We look forward to growing as a site and as a community and sharing new and different kinds of tea with our users.
    </p> 
    <h3 class="gradient green">Sell Tea, Get Paid</h3>
    <p>
    At DrinkChai, our goal is to introduce people to teas they’ve never tried while making the process as easy as possible. We look forward to growing as a site and as a community and sharing new and different kinds of tea with our users.
    </p> -->
</section>
<section class="ajax-content col" id="about-us-content">
    <h2 class="tag"><span>About Us</span></h2>
    <p>
    DrinkChai allows you to bypass costly middlemen and harness the power of group buying - meaning we're able to bring you fantastic deals and discounts that aren't available anywhere else.
    </p>
    <p>
    As any trip down a tea aisle will show, picking the “right” tea can be a daunting task. That’s why we handpick our deals and deliver them right to your inbox. 
    </p>
    <p>
    At DrinkChai, our goal is to introduce people to teas they’ve never tried while making the process as easy as possible. We look forward to growing as a site and as a community and sharing new and different kinds of tea with our users.
    </p> 
</section>
