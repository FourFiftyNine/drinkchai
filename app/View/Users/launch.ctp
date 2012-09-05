<nav class="shadow-inset" id="main">
    <ul>
        <li><?php echo $this->Html->link('Home', '/', array('id' => 'home', 'class' => 'ajax-link active')); ?></li>
        <!-- <li><?php echo $this->Html->link('About Us', '/about-us', array('id' => 'about-us', 'class' => 'ajax-link')); ?></li> -->
        <li><?php echo $this->Html->link('How It Works', '/how-it-works'); ?></li>
        <!-- <li><?php echo $this->Html->link('Businesses', '/businesses', array('id' => 'businesses', 'class' => 'ajax-link')); ?></li> -->
        <li><?php echo $this->Html->link('Do you sell tea?', '/businesses/how-it-works'); ?></li>
        <?php if($deal_is_live):  ?>
        <!-- <li><?php echo $this->Html->link('Current Deal', '/deals/view');?></li> -->
        <?php endif; ?>
        <?php if(isset($user['User'])): ?>
        <li><a href="/account">My Account</a></li>
        <!-- <li><a href="<?php echo (!$user['facebook_id']) ? '/users/logout' : '#'; ?>"class="logout">Logout</a></li> -->
        <?php else: ?>
        <!-- <li><a href="/login">Login</a></li> -->
        <!-- <li><a href="/signup">Sign Up</a></li> -->
        <?php endif; ?>
    </ul>
</nav>
<?php /* 
<section class="shadow-inset" id="a-business">
    <label for="">Do you sell tea?</label>
    <?php echo $this->Html->link('Click Here', '/businesses/how-it-works', array('class' => 'btn white')); ?>
</section>
*/ ?>
<section id="bubble-shares" class="addthis">
    <nav class="shadow-inset">
        <div class="fb-like" data-send="false" data-layout="box_count" data-width="" data-show-faces="false" data-href="https://www.facebook.com/pages/DrinkChai/239368896145935"></div>
        <a href="https://twitter.com/share" class="twitter-share-button" data-text="Get great Tea deals at " data-url="https://drinkchai.com" data-via="drink_chai" data-lang="en" data-related="anywhereTheJavascriptAPI" data-count="vertical"></a>
        <span id="plusone">
            <g:plusone size="tall"></g:plusone>
        </span>
    </nav>
</section>
<aside class="green-tag launch">
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
<section class="ajax-content" id="home-content">
    <?php if ($alreadySubmitted == false): ?>
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
                'class'     => 'required default-value',
                'tabIndex'  => 0
            )); 
            ?>
            <button class="submit-email"></button>
            <?php echo $this->Form->end(); ?>
    </section>
    <?php else: ?>
        <section>
            <hgroup>
                <h3>Looks like you have already submitted your e-mail address.</h3>
                <h3>We will let you know when one of our awesome deals launches.</h3>
            </hgroup>
            <?php echo $this->Html->link(
                $this->Html->image('emblem_large.png', array('alt'=> __('We help you find and buy tea. DrinkChai.com', true), 'border' => '0')),
                    '/',
                    array('escape' => false, 'class' => 'logo')
                    );
            ?>
            <div id="twitter-share-container">
    <!--             <textarea class="share shadow-inset">Awesome tea deals at DrinkChai.com</textarea>
                <a id="twitter-share" href="http://twitter.com/share">Tweet</a> -->
                <a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-count="none" data-hashtags="drinkchai">Tweet</a>
            </div>
        </section>-
    <?php endif; ?>
    <section  class="thankyou">
        <hgroup>
            <h2>Thank You.</h2>
            <h3>We will let you know when one of our awesome deals launches.</h3>
        </hgroup>
        <?php echo $this->Html->link(
            $this->Html->image('emblem_large.png', array('alt'=> __('We help you find and buy tea. DrinkChai.com', true), 'border' => '0')),
                '/',
                array('escape' => false, 'class' => 'logo')
                );
        ?>
        <div id="twitter-share-container">
<!--             <textarea class="share shadow-inset">Awesome tea deals at DrinkChai.com</textarea>
            <a id="twitter-share" href="http://twitter.com/share">Tweet</a> -->
            <a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-count="none" data-hashtags="drinkchai">Tweet</a>
        </div>
    </section>
</section>