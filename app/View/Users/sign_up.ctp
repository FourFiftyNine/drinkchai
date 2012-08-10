<section id="content" class="clearfix">
    <?php //TODO TAB INDEX LOOP ?>
  <section id="sign-up" class="canvas left">
      <h1 class="gradient green">Sign Up</h1>
  <?php echo $this->Form->create('User', array(
      'action'          => 'sign_up',
      'class'           => 'clearfix',
      'default'         => (true != empty($this->params['isAjax'])) ? false : true,
      'inputDefaults'   => array(
        'class' => 'blurFocus'
      )
    )); ?>

    <section class="fieldset clearfix">
      <?php echo $this->Form->input('firstname', array(
        'label'     => 'First Name',
        'class'     => 'float',
        'maxlength' => 256,
      )); ?>
      <?php echo $this->Form->input('lastname', array(
        'label'     => 'Last Name',
        'class'     => 'float',
        'maxlength' => 256,
      )); ?>
    </section>
    <?php echo $this->Form->input('email', array(
      'label'       => 'E-mail Address',
      'maxlength'   => 256,
      'id'          => 'AjaxUserEmail'
    ));
    ?>
    <?php echo $this->Form->input('password', array(
      'label'       => 'Password',
      'maxlength'   => 256,
      'value'       => '',
      'type'        => 'password'
    )); ?>
    <?php echo $this->Form->input('password_confirm', array(
      'label'       => 'Confirm Password',
      'maxlength'   => 256,
      'value'       => '',
      'type'        => 'password'
    )); ?>
    <?php echo $this->Form->end(array('label' => 'Sign Up', 'div' => array('class' => (true != empty($this->params['isAjax'])) ? 'sign-up ajax-submit' : 'sign-up'), 'class' => 'btn white')); ?>
    
    </section>

    <section id="facebook-login" class="canvas right">
      
    <button class="sign-in-with-facebook">Sign In with Facebook</button>
    <!-- <button class="logout" >Logout</button>
    <button class="disconnect" >Disconnect</button> -->
    </section>
    <section id="business-cta" class="canvas right">
        <h3 class="gradient brown">Are you a business?</h3>
       <a class="btn white" 
       href="/businesses/sign-up">Create Your Deal</a>
    </section>
</section>