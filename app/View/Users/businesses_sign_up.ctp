<article id="how-it-works" class="businesses canvas">
  <header>
    <h1>DrinkChai does something supermarket shelves could never do.</h1>
    <h2>We put your tea front and center with tea drinkers everywhere.</h2>
  </header>
  <section id="step-titles">
    <ul>
      <li class="create">CREATE YOUR DEAL</li>
      <li class="launch">LAUNCH YOUR DEAL</li>
      <li class="sell">SELL TEA & GET PAID</li>
    </ul>
  </section>
  <section id="step-content" class="clearfix">
    <ul>
      <li>Sign up to create a deal on 
DrinkChai. Our dashboard lets you control the deal - determine how big or small you want your sale to be, add marketing materials, link to reviews and much more.</li>
      <li>On the day of the sale, buyers come to DrinkChai and purchase your product through our site. You can watch it all unfold, along with some analytics, right from the dashboard.</li>
      <li>Once the deal is done, simply ship out the orders and wait for your check in the mail or a transfer into your PayPal account.</li>
    </ul>
  </section>
  <?php if($loggedIn): ?>
  <section id="account">
    <h3 class="">You are currently logged in</h3>
    <br />
      <?php echo $this->Html->link("Go To Your Account", '/account', array('class' => 'btn white')); ?>
  </section>
  <?php elseif ($businessSignedUp): ?>
    <div id="account">
      <p>Thank you for signing up.  We will review your information and be in touch within 1 business day.</p>
    </div>
  <?php else: ?>
  <section id="sign-up" class="clearfix">
    <h2 class="gradient brown">Sign Up Now</h2>

    <?php 
    echo $this->Form->create('Business', array(
        'class'         => 'clearfix',
        'inputDefaults' => array('class' => 'blurFocus'),
    )); 
    ?>
    <div><?php echo $this->Html->image('asterisk.png', array('alt'=> __('Required', true), 'border' => '0', 'class' => '')) ?> Required fields.</div>
    <div class="fieldset left">
        <?php echo $this->Form->input('Business.name', array(
            'label'     => 'Business Name',
            'maxlength' => 256,
            'tabindex'  => 1
        )); 
        ?>
        <?php echo $this->Form->input('User.firstname', array(
            'label'     => 'First Name',
            'maxlength' => 256,
            'tabindex'  => 3
        )); ?>
        <?php echo $this->Form->input('User.password', array(
            'label'     => 'Password',
            'maxlength' => 256,
            'tabindex'  => 5
        )); ?>
        <?php /* echo $this->Form->input('Address.0.zip', array(
            'class'     => 'zip',
            'maxlength' => 5,
            'tabindex'  => 9
        )); */ ?>
    </div>
    <div class="fieldset right">
        <?php echo $this->Form->input('User.email', array(
            'maxlength' => 256,
            'tabindex'  => 2,
            'error'     => array('escape' => false)
        )); ?>
        <?php echo $this->Form->input('User.lastname', array(
            'label'     => 'Last Name',
            'maxlength' => 256,
            'tabindex'  => 4,
        )); ?>
        <?php echo $this->Form->input('User.password_confirm', array(
            'label'     => 'Confirm Password',
            'maxlength' => 256,
            'tabindex'  => 6,
            'type'      => 'password'
        )); ?>
    </div>
    <?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn white')); ?>
  </section>
  <?php endif; ?>

</article>