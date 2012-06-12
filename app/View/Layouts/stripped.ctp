<?php echo $this->element('global/doctype'); ?>
<?php echo $this->element('global/head') ?>
<body id="<?php echo $this->layout; ?>" <?php echo 'class="' . $this->params['controller'] . ' ' . $this->params['action'] . '"'; ?>>
    <div id="main">
        <div class="container">
            <?php echo $this->Html->link(
                $this->Html->image('logo_small_white.png', array('alt'=> __('We help you find and buy tea. DrinkChai.com', true), 'border' => '0', 'class' => 'logo', 'height' => '49', 'width' => '220')),
                    '/',
                    array('escape' => false)
                    );
            ?>
            <?php echo $this->Session->flash(); ?>
            <?php echo $content_for_layout; ?>
        </div>
    </div>
    <?php echo $this->element('global/end_scripts'); ?>
</body>
</html>