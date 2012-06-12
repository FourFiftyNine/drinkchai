<?php echo $this->element('global/doctype'); ?>
<head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $title_for_layout . ' - DrinkChai.com'; ?></title>
    <?php /* ?><meta name="description" content="<?php echo $metaDescription . 'tea' ?>"> */?>
    <meta name="author" content="Anthony Sessa">
    <meta name="viewport" content="width=device-width,initial-scale=.5">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta property="fb:app_id" content="331823930171141" />
    <meta property="fb:admins" content="1410801" />
    <meta property="og:title" content="DrinkChai.com - <?php echo $title_for_layout; ?>"/>
    <meta property="og:url" content="http://drinkchai.com"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="http://drinkchai.com/img/emblem_large.png" />
    <meta property="og:site_name" content="DrinkChai"/>
    <meta property="og:description"
          content="DrinkChai brings you the best handpicked teas at a great price, delivered right to your door."/>
    <?php echo $this->Html->meta('icon'); ?>

    <?php 
    echo $this->Html->script('libs/modernizr.custom.min');

    // echo $this->AssetCompress->includeCss();
    // echo $this->Html->css(array('fonts/santana/santana.css'));
    echo $this->Html->css(array('normalize', 'general', 'site'));
    echo $this->Html->css('layouts/' . $this->layout);

    echo $this->Html->css('http://fonts.googleapis.com/css?family=News+Cycle&v1|Arimo&v1');
    echo $this->Html->css(array('fonts/chunkfive/stylesheet.css'));
    echo $scripts_for_layout; 
    ?>
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
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