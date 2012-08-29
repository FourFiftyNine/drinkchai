<div id="checkout" class="login clearfix">
   <section id="login" class="canvas left">

      <?php echo $this->Form->create('Order', array(
          'action'  => '/login',
          'class' => 'clearfix',
          'inputDefaults' => array(
            'class' => 'blurFocus'
          )
        )); ?>
        <h1 class="gradient green">Login</h1>
        <?php echo $this->Session->flash('auth'); ?>

        <section class="fieldset">
          <?php echo $this->Form->input('User.email', array(
            'label' => 'E-mail Address',
            'maxlength'  => 256,
            'tabindex' => 11,
          )); 
          ?>
          <?php echo $this->Form->input('User.password', array(
            'label' => 'Password',
            // 'id'  => 'firstname',
            'maxlength'  => 256,
            'tabindex' => 12,
            'type'  => 'password'
          )); ?>

        </section>
        <div class="login-links">
          <?php echo $this->Html->link("Forgot Password?",array('controller'=>'users', 'action'=>'forgot_password')); ?>
          <?php echo $this->Html->link("I don't have a password", '/checkout/signup'); ?>
        </div>
        <?php echo $this->Form->end(array('label' => 'Login', 'class' => 'btn white')); ?>
    </section>
    
    <section id="facebook-login" class="canvas right">
        <button class="sign-in-with-facebook">Sign In with Facebook</button>
    </section>  
</div>
