<div id="checkout" class="sign-up clearfix">
  <section id="sign-up" class="canvas left">
      <?php echo $this->Form->create('Checkout', array(
          'action'          => '/sign_up',
          'class'           => 'clearfix',
          'default'         => (true != empty($this->params['isAjax'])) ? false : true,
          'inputDefaults'   => array(
            'class' => 'blurFocus'
          )
        )); ?>
        <h1 class="gradient green">Sign Up</h1>

        <section class="fieldset clearfix">
          <?php echo $this->Form->input('User.firstname', array(
            'label'     => 'First Name',
            'class'     => 'float',
            'maxlength' => 256,
          )); ?>
          <?php echo $this->Form->input('User.lastname', array(
            'label'     => 'Last Name',
            'class'     => 'float',
            'maxlength' => 256,
          )); ?>
        </section>
        <?php echo $this->Form->input('User.email', array(
          'label'       => 'E-mail Address',
          'maxlength'   => 256,
          'id'          => 'AjaxUserEmail'
        ));
        ?>
        <?php echo $this->Form->input('User.password', array(
          'label'       => 'Password',
          'maxlength'   => 256,
          'value'       => '',
          'type'        => 'password'
        )); ?>
        <?php echo $this->Form->input('User.password_confirm', array(
          'label'       => 'Confirm Password',
          'maxlength'   => 256,
          'value'       => '',
          'type'        => 'password'
        )); ?>
        <div class="login-links">
          <?php echo $this->Html->link("I Have an Account. <br /> Login", '/checkout/login', array('id' => 'have_password', 'escape' => false )); ?>
        </div>
        <?php echo $this->Form->end(array('label' => 'Sign Up', 'div' => array('class' => (true != empty($this->params['isAjax'])) ? 'sign-up ajax-submit' : 'sign-up submit'), 'class' => 'btn white')); ?>
    <div id="agreement">By registering you agree to the <?php echo $this->Html->link('Terms and Conditions', '/terms', array('target' => 'blank')); ?> and <?php echo $this->Html->link('Privacy Policy', '/privacy_policy', array('target' => 'blank')) ?></div>
    </section>
    <section id="facebook-login" class="canvas right">
        <button class="sign-in-with-facebook">Sign In with Facebook</button>
    </section> 
</div>