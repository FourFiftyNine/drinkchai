<?php if(strpos($this->request->url, 'businesses') === false): ?>
<article id="how-it-works" class="users canvas">
  <header>
    <h2>HOW IT WORKS</h2>
    <p class="intro">DrinkChai brings you the best handpicked teas at a great price.</p>
  </header>
  <div class="divider">&nbsp;</div>
  <section class="step one container clearfix">
    <aside class="number">1</aside>
    <article class="right">
      <?php echo $this->Html->image('hiw-badge-one.png', array('alt'=> __('How it Works', true), 'class' => 'badge')) ?>
      <?php echo $this->Html->image('ribbon-get-deals.png', array('alt'=> __('How it Works', true), 'class' => 'ribbon')) ?>
      <p class="description">Get one of a kind tea deals delivered right to your inbox.</p>
    </article>
  </section>
  <div class="divider">&nbsp;</div>
  <section class="step two container clearfix">
    <aside class="number">2</aside>
    <article class="right">
      <?php echo $this->Html->image('hiw-badge-two.png', array('alt'=> __('How it Works', true), 'class' => 'badge')) ?>
      <?php echo $this->Html->image('ribbon-share-deal.png', array('alt'=> __('How it Works', true), 'class' => 'ribbon')) ?>
      <p class="description">If you can get <strong>two</strong> of your friends to buy the deal, yours is free.</p>
    </article>
  </section>
  <div class="divider">&nbsp;</div>
  <section class="step three container clearfix">
    <aside class="number">3</aside>
    <div class="right">
      <?php echo $this->Html->image('hiw-badge-three.png', array('alt'=> __('How it Works', true), 'class' => 'badge')) ?>
      <?php echo $this->Html->image('ribbon-delivered-to-your-door.png', array('alt'=> __('How it Works', true), 'class' => 'ribbon')) ?>
      <p class="description">Sit back and wait for the manufacturer to mail the tea to your doorstep. No vouchers to print or redeem. It's that simple. </p>
    </div>
  </section>
  <div class="divider">&nbsp;</div>
  <section class="step four container clearfix sign-up">
    <?php echo $this->Html->link('Sign Up Now', '/users/sign-up', array('class' => 'btn gradient green')) ?>
  </section>
</article>
<?php else: ?>
<article id="how-it-works" class="canvas">
  <header>
    <h2>HOW IT WORKS</h2>
    <p class="intro">DrinkChai does something supermarket shelves could never do - put your tea front and center with tea drinkers everywhere. Let us show you how.</p>
  </header>
  <div class="divider">&nbsp;</div>
  <section class="step one container clearfix">
    <aside class="number">1</aside>
    <article class="right">
      <?php echo $this->Html->image('hiwb-badge-one.png', array('alt'=> __('How it Works', true), 'class' => 'badge')) ?>
      <?php echo $this->Html->image('ribbon-create.png', array('alt'=> __('How it Works', true), 'class' => 'ribbon')) ?>
      <p class="description">Sign up to create a deal on DrinkChai. Our dashboard lets you control the deal - determine how big or small you want your sale to be, add marketing materials, link to reviews and much more.</p>
    </article>
  </section>
  <div class="divider">&nbsp;</div>
  <section class="step two container clearfix">
    <aside class="number">2</aside>
    <article class="right">
      <?php echo $this->Html->image('hiwb-badge-two.png', array('alt'=> __('How it Works', true), 'class' => 'badge')) ?>
      <?php echo $this->Html->image('ribbon-launch.png', array('alt'=> __('How it Works', true), 'class' => 'ribbon')) ?>
      <p class="description">On the day of the sale, buyers come to DrinkChai and purchase your product through our site. You can watch it all unfold, along with some analytics, right from the dashboard.</p>
    </article>
  </section>
  <div class="divider">&nbsp;</div>
  <section class="step three container clearfix">
    <aside class="number">3</aside>
    <div class="right">
      <?php echo $this->Html->image('hiwb-badge-three.png', array('alt'=> __('How it Works', true), 'class' => 'badge')) ?>
      <?php echo $this->Html->image('ribbon-sell.png', array('alt'=> __('How it Works', true), 'class' => 'ribbon')) ?>
      <p class="description">Once the deal is done, simply ship out the orders and wait for your check in the mail or a transfer into your PayPal account.</p>
    </div>
  </section>
  <div class="divider">&nbsp;</div>
  <section class="step four container clearfix sign-up">
    <?php echo $this->Html->link('Sign Up Now', '/businesses/sign-up', array('class' => 'btn white')) ?>
  </section>
</article>
<?php endif; ?>