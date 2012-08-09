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
    <?php echo $this->Html->meta(
    'favicon.ico',
    '/favicon.ico',
    array('type' => 'icon'));?>

    <?php echo $this->Html->css('style.css'); ?>
    <?php if ($this->params['controller'] == 'image' && $this->params['action'] == 'manage'): ?>
        <?php
        
        echo $this->Html->css('/lib/file-uploader/client/fileuploader.css');

        // $libJqueryFileUpload = '/lib/jquery-file-upload/';
        // echo $this->Html->css('http://blueimp.github.com/cdn/css/bootstrap.min.css');
        // echo $this->Html->css($libJqueryFileUpload . 'css/style.css');
        // echo $this->Html->css('"http://blueimp.github.com/cdn/css/bootstrap-responsive.min.css"'); 
        // echo $this->Html->css('http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css'); 
        // echo $this->Html->css($libJqueryFileUpload . 'css/jquery.fileupload-ui.css'); 
        ?>
    <?php endif; ?>
    <?php //  $this->AssetCompress->addCss(
    //     array(
    //         'normalize.css', 
    //         'general.css', 
    //         'site.css', 
    //         'last.css', 
    //         // 'colorbox/colorbox.css'
    //     )
    // );
    // echo $this->AssetCompress->includeCss();

    if(Configure::read('debug')){
        echo $this->Html->css('cake.generic'); 
        // echo $this->Html->script('libs/live');
        echo $this->Html->script('libs/modernizr.custom.min');
      // echo $this->Html->script('libs/live');
    } else {
        echo $this->Html->script('libs/modernizr.custom.min');
    }
    echo $this->Html->css('//fonts.googleapis.com/css?family=News+Cycle&v1|Arimo&v1');
    echo $this->Html->css(array('fonts/chunkfive/stylesheet.css'));

    
    echo $scripts_for_layout; 
    ?>

    
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>