<?php echo $this->element('global/doctype'); ?>
<?php echo $this->element('global/head', array('scripts_for_layout' => $scripts_for_layout)) ?>
<body id="<?php echo $this->layout; ?>" <?php echo 'class="' . $this->params['controller'] . ' ' . $this->params['action'] . '"'; ?>>
  <div class="container">
    <div class="content">
      <?php echo $this->Session->flash(); ?>
      <?php echo $content_for_layout; ?>
    </div>
  </div>
    <?php echo $this->element('global/end_scripts'); ?>
</body>
</html>