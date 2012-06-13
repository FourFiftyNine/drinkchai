<?php echo $this->element('global/doctype'); ?>
<?php echo $this->element('global/head', array('scripts_for_layout' => $scripts_for_layout)) ?>
<body id="<?php echo $this->layout; ?>" <?php echo 'class="' . $this->params['controller'] . ' ' . $this->params['action'] . '"'; ?>>
  <div class="container">
    <div class="content">
      <?php echo $this->Session->flash(); ?>
      <?php echo $content_for_layout; ?>
    </div>
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write("<script src='js/libs/jquery-1.7.1.min.js'>\x3C/script>")</script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>

<?php echo $this->Html->script(array('global')); ?>

<?php //echo $this->element('sql_dump'); ?></body>
</html>