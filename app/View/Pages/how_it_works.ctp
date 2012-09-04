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
      <p class="description">Share the deal with your friends.</p>
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