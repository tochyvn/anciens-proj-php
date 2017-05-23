<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Publicité - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body class="no-bg-image">
<script type="text/javascript">
<!--
	google_ad_client = "<?php print($_REQUEST['google_ad_client']);?>";
	google_ad_slot = "<?php print($_REQUEST['google_ad_slot']);?>";
	google_ad_width = <?php print($_REQUEST['google_ad_width']);?>;
	google_ad_height = <?php print($_REQUEST['google_ad_height']);?>;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</body>
</html>
