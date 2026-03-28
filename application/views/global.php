<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" />

<!-- global declaration -->
<?php $url_prefix = $this->webspice->settings()->site_url_prefix; ?>

<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $url_prefix; ?>global/css/styles.css" />

<script type="text/javascript" src="<?php echo $url_prefix; ?>global/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="<?php echo $url_prefix; ?>global/js/functions.js?v=1.0"></script>
<script type="text/javascript" src="<?php echo $url_prefix; ?>global/parsley/parsley.min.js"></script> <!--JQuery form validation-->

<!--superfish menu-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $url_prefix; ?>global/superfish/superfish.css" />
<script type="text/javascript" src="<?php echo $url_prefix; ?>global/superfish/superfish.js"></script>

<!--bootstrap-->
<link rel="stylesheet" type="text/css" href="<?php echo $url_prefix; ?>global/bootstrap_3_2/css/bootstrap.min.css" />
<script type="text/javascript" src="<?php echo $url_prefix; ?>global/bootstrap_3_2/js/bootstrap.min.js"></script>

<!--calendar-->
<link rel="stylesheet" type="text/css" href="<?php echo $url_prefix; ?>global/calendar/jquery.datetimepicker.css" />
<script type="text/javascript" src="<?php echo $url_prefix; ?>global/calendar/jquery.datetimepicker.js"></script>

<!--[if lt IE 9]>
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $url_prefix; ?>global/css/styles_ie.css" />
  <script src="<?php echo $url_prefix; ?>global/js/html5shiv.min.js"></script>
  <script src="<?php echo $url_prefix; ?>global/js/respond.min.js"></script>
<![endif]-->

<link  type="image/x-icon" rel="Shortcut Icon" href="<?php echo $this->webspice->settings()->site_url; ?>global/img/favicon.png" />
<link rel="image_src" href="<?php echo $this->webspice->settings()->site_url; ?>global/img/logo.png" />
<meta property="og:image" content="<?php echo $this->webspice->settings()->site_url; ?>global/img/logo.png" />

<!--[if lt IE 9]>
	<script language="javascript" type="text/javascript" src="<?php echo $url_prefix; ?>global/jqplot/excanvas.js"></script>
<![endif]-->
<link class="include" rel="stylesheet" type="text/css" href="<?php echo $url_prefix; ?>global/jqplot/jquery.jqplot.min.css" />
<script class="include" type="text/javascript" src="<?php echo $url_prefix; ?>global/jqplot/jquery.jqplot.min.js"></script>
<!--<script class="include" type="text/javascript" src="<?php echo $url_prefix; ?>global/jqplot/plugins/jqplot.barRenderer.min.js"></script>-->
<script class="include" type="text/javascript" src="<?php echo $url_prefix; ?>global/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $url_prefix; ?>global/jqplot/plugins/jqplot.pointLabels.min.js"></script>