<?php echo $this->element('global/doctype'); ?>
<?php echo $this->element('global/head', array('scripts_for_layout' => $scripts_for_layout)) ?>
<body id="<?php echo $this->layout; ?>" <?php echo 'class="' . $this->params['controller'] . ' ' . $this->params['action'] . ' ' . $this->params['prefix'] . '"'; ?>>
  <div id="content" class="container main">
    <?php 
    echo $this->Html->link(
            $this->Html->image('logo_large_white.png', array('alt'=> __('We help you find and buy tea. DrinkChai.com', true), 'border' => '0')), '/', array('escape' => false, 'class' => 'logo')
        );
    ?>
    <?php echo $content_for_layout; ?>
    <?php echo $this->Html->link('Go Home', '/', array('class' => 'go-home btn white')); ?>
  </div>
  
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->element('global/end_scripts'); ?>
</body>
</html>