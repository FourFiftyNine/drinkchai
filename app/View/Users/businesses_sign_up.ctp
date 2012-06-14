 <div class="already account right">
    <span>Not a business?</span>
    <?php echo $this->Html->link('Sign Up', array('controller' => 'users', 'action' => 'sign-up'), array('class' => 'btn gradient green')); ?>
    <?php echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'), array('class' => 'btn gradient green')); ?>
</div>
<section id="content">
      <section id="business-sign-up" class="canvas clearfix">
         <h1 class="gradient brown">Make a Deal <span class="small">Its Free!</span></h1>

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

</section>