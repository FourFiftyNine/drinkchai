
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script> -->
<div id="fb-root"></div>
<?php echo $this->Html->script(
	array(
		// 'facebook', 
		// 'libs/jquery.color.js', 
		// 'libs/colorbox/jquery.colorbox-min.js'
		// 'email-submit'
	)
); ?>
<?php echo $this->Html->script(array(
  'global', 
  'facebook', 
  'layouts/' . 
  $this->layout, 
  'libs/jquery.ui.widget.js',
  'libs/jquery.iframe-transport.js',
  'libs/jquery.fileupload.js',
  'libs/jquery.countdown.pack.js',
  'libs/jquery.backstretch.min.js',
  // '/lib/jquery-file-upload/js/jquery.fileupload-ui.js'
  )); ?>

<?php if ($this->params['controller'] == 'orders' && $this->params['action'] == 'review'): ?>
  <?php //echo $this->Html->script(array('libs/jquery.formatCurrency-1.4.0.pack')); ?>
<?php endif; ?>

<!-- <script src="js/vendor/jquery.ui.widget.js"></script>
<script src="js/jquery.iframe-transport.js"></script>
<script src="js/jquery.fileupload.js"></script> -->

<!-- Facebook, twitter, google share apis -->
<script>

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "https://connect.facebook.net/en_US/all.js";
     d.getElementsByTagName('head')[0].appendChild(js);
   }(document));
</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

<script type="text/javascript" src="https://assets.pinterest.com/js/pinit.js"></script>

<!--[if lt IE 7 ]>
<script src="js/libs/dd_belatedpng.js"></script>
<script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
<![endif]-->

<!--[if lte IE 8]>
<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28186499-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php //echo $this->Js->writeBuffer(); ?>
<?php //echo $this->element('sql_dump'); ?>