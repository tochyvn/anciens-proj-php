<?php
	require_once(PWD_ADHERENT_V2.'configuration.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT_V2.'entete.php');?>
</head>
<body>
<?php
	if(!isset($_REQUEST['adsense_identifiant']) || $_REQUEST['adsense_identifiant']=='468x60')
	{
?>
<script type="text/javascript"><!--
	google_ad_client = "pub-9592588828246820";
	/* Localerte 468x60 */
	google_ad_slot = "2856140032";
	google_ad_width = 468;
	google_ad_height = 60;
	//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
<?php
	}
	else
	{
		if(isset($_REQUEST['adsense_mode']) && $_REQUEST['adsense_mode']=='detail')
		{
			?>
<script type="text/javascript"><!--
google_ad_client = "pub-9592588828246820";
/* Localerte détail textuel */
google_ad_slot = "0342046119";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
<?php
		}
		else
		{
?>
<script type="text/javascript"><!--
	google_ad_client = "pub-9592588828246820";
	/* Localerte 728x90 */
	google_ad_slot = "6171368322";
	google_ad_width = 728;
	google_ad_height = 90;
	//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
<?php
		}
	}
?>
</body>
</html>
