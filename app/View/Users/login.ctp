<div id="content" class="clearfix">
   <section id="login" class="canvas left">

      <?php echo $this->Form->create('User', array(
          'action'  => 'login',
          'class' => 'clearfix',
          'inputDefaults' => array(
            'class' => 'blurFocus'
          )
        )); ?>
        <h1 class="gradient green">Login</h1>
        <?php echo $this->Session->flash('auth'); ?>

        <section class="fieldset">
          <?php echo $this->Form->input('email', array(
            'label' => 'E-mail Address',
            'maxlength'  => 256,
            'tabindex' => 11,
          )); 
          ?>
          <?php echo $this->Form->input('password', array(
            'label' => 'Password',
            // 'id'  => 'firstname',
            'maxlength'  => 256,
            'tabindex' => 12,
            'type'  => 'password'
          )); ?>

        </section>
        <?php echo $this->Form->end(array('label' => 'Login', 'class' => 'btn white')); ?>
    </section>

    <section id="facebook-login" class="canvas right">
        <button class="sign-in-with-facebook">Sign In with Facebook</button>
    </section>
   




         <?php /* ?>
      <section class="content-middle clearfix">

        <?php echo $this->Form->create('User', array(
            'action'  => 'login',

            'class' => 'clearfix',
            'inputDefaults' => array(
              'class' => 'blurFocus'
            )
          )); ?>
          <h1>Login</h1>
          <section class="fieldset">
            <?php echo $this->Form->input('User.email', array(
              'label' => 'E-mail Address',
              'maxlength'  => 256,
              'tabindex' => 1
            )); 
            ?>
            <?php echo $this->Form->input('User.password', array(
              'label' => 'Password',
              // 'id'  => 'firstname',
              'maxlength'  => 256,
              'tabindex' => 2,
              'type'  => 'password'
            )); ?>

          </section>
          <?php echo $this->Form->end(array('label' => 'Login', 'div' => array('class' => 'login ajax-submit'))); ?>
        </section>


    */ ?>
    
</div>
