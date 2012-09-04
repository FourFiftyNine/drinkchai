<?php echo $this->element('global/doctype'); ?>
<?php echo $this->element('global/head', array('scripts_for_layout' => $scripts_for_layout)) ?>
<body id="<?php echo $this->layout; ?>" <?php echo 'class="' . $this->params['controller'] . ' ' . $this->params['action'] . ' ' . $this->params['prefix'] . '"'; ?>>

	<?php echo $this->element('default/navigation', array('user' => ((isset($user)) ? $user : ''))) ?>
	<div id="content" class="container main">
		<?php echo $content_for_layout; ?>
	</div>
  <div id="footer" class="container">
    <div id="footer-content" class="canvas">
      <span class="copyright">Copyright <?php echo date('Y') ?> DrinkChai, Inc.</span>
      <nav id="footer-nav">
        <ul>
<!--           <li>
            <?php echo $this->Html->link('Current Deal', '/'); ?>
          </li> -->
          <li>
            <?php echo $this->Html->link('Do You Sell Tea?', '/businesses/how-it-works'); ?>
          </li>
<!--           <li>
            <?php echo $this->Html->link('Account', '/account'); ?>
          </li> -->
          <li>
            <?php echo $this->Html->link('About Us', '/about-us'); ?>
          </li>
          <li>
            <?php echo $this->Html->link('Terms and Conditions', '/terms'); ?>
          </li>
          <li>
            <?php echo $this->Html->link('Privacy Policy', '/privacy_policy'); ?>
          </li>
        </ul>
      </nav>
    </div>
  </div>
	<?php // echo $this->element('default/footer'); ?>
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->element('global/end_scripts'); ?>
</body>
</html>