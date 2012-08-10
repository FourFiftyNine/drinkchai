<?php if ($this->params['action'] == 'login'): ?>
<div class="already account right"><span>Don't have an account?</span><?php echo $this->Html->link('Sign Up', '/signup', array('class' => 'btn gradient green')); ?>
</div>
<?php elseif ($this->params['action'] == 'sign_up'): ?>
<!-- User Signup -->
<div class="already account right"><span>Already have an account?</span><?php echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'), array('class' => 'btn gradient green')); ?>
</div>
<?php elseif ($this->params['action'] == 'businesses_sign_up'): ?>
<!-- Business Signup -->
 <div class="already account right">
    <span>Not a business?</span>
    <?php echo $this->Html->link('Sign Up', array('controller' => 'users', 'action' => 'sign-up'), array('class' => 'btn gradient green')); ?>
    <?php echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'), array('class' => 'btn gradient green')); ?>
</div>
<?php endif; ?>