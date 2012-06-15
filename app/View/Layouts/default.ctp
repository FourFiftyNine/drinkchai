<?php echo $this->element('global/doctype'); ?>
<?php echo $this->element('global/head', array('scripts_for_layout' => $scripts_for_layout)) ?>
<body id="<?php echo $this->layout; ?>" <?php echo 'class="' . $this->params['controller'] . ' ' . $this->params['action'] . ' ' . $this->params['prefix'] . '"'; ?>>

	<?php echo $this->element('default/navigation', array('user' => ((isset($user)) ? $user : ''))) ?>
	<div id="content" class="container main">
		<?php echo $content_for_layout; ?>
	</div>
	<?php // echo $this->element('default/footer'); ?>
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->element('global/end_scripts'); ?>
</body>
</html>