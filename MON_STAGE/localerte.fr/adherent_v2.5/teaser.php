<!--p><br /><span class="gros">Vous cherchez<br />
un logement &agrave; louer ?</span></p>
<p><br /><span class="orange">Inscrivez-vous gratuitement</span><br />pour cr&eacute;er vos alertes</p>
<p><br />Et faire votre choix<br />avant les autres</p-->
<?php
$rd = rand(1,4);
?>
<object id="teaser_flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="337" height="246" align="middle">
  <param name="allowScriptAccess" value="sameDomain" />
  <param name="allowFullScreen" value="false" />
  <param name="movie" value="<?php print(HTTP_ADHERENT.'image/teaser/banniere'.$rd.'b.swf');?>" />
  <param name="quality" value="high" />
  <param name="scale" value="noscale" />
  <param name="wmode" value="transparent" />
  <embed src="<?php print(HTTP_ADHERENT.'image/teaser/banniere'.$rd.'b.swf');?>" quality="high" bgcolor="#ffffff" width="337" height="246" name="teaser" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_fr" />
</object>

