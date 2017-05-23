<?php
	$tableau=array(
		'marker'=>array(),
		'iconUrl'=>'http://cdn.leafletjs.com/leaflet-0.4/images/marker-icon.png',
		'iconSize'=>array(16,27)
	);
	$selected=false;
	for($i=0;$i<sizeof($ville_liste->occurrence);$i++)
	{
		if($ville_liste->occurrence[$i]['selected'])
		{
			$tableau['latitude']=round($ville_liste->occurrence[$i]['latitude'],2);
			$tableau['longitude']=round($ville_liste->occurrence[$i]['longitude'],2);
			$selected=true;
		}
		
		$tableau['marker'][]=array(
			'latitude'=>round($ville_liste->occurrence[$i]['latitude'],2),
			'longitude'=>round($ville_liste->occurrence[$i]['longitude'],2),
			'click'=>'<a href="?annonce_ville='.urlencode($ville_liste->occurrence[$i]['identifiant']).'&amp;annonce_statut=">'.ma_htmlentities($ville_liste->occurrence[$i]['nom']).'</a>'
		);
	}
	
	if(!$selected)
	{
		$tableau['latitude']=round($ville->latitude,2);
		$tableau['longitude']=round($ville->longitude,2);
	}
	
	switch($alerte->rayon)
	{
		case '5':
			$tableau['zoom']=11;
			break;
		case '10':
			$tableau['zoom']=10;
			break;
		case '20':
			$tableau['zoom']=9;
			break;
		case '35':
			$tableau['zoom']=8;
			break;
		case '50':
			$tableau['zoom']=7;
			break;
	}
?>
  <div id="map" title="<?php print(ma_htmlentities(json_encode($tableau)));?>"></div>
