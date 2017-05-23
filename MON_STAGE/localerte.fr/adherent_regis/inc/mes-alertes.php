<?php
	$mesalertes_liste=new ld_liste
	('
		select
			alerte.identifiant as identifiant,
			alerte.rayon as rayon,
			ville.nom as ville,
			ville.code_postal as code_postal,
			group_concat(type.designation separator \',\') as type
		from alerte
			inner join ville on alerte.ville=ville.identifiant
			inner join alerte_type on alerte.identifiant=alerte_type.alerte
			inner join type on alerte_type.type=type.identifiant
		where 1
			and adherent='.$_SESSION['adherent_identifiant'].'
		group by alerte.identifiant
		order by alerte.enregistrement, alerte.identifiant
	');
	
	for($i=0;$i<$mesalertes_liste->total;$i++)
	{
		$mesalertes_type=explode(',',$mesalertes_liste->occurrence[$i]['type']);
		
		$url='ma-liste.php';
		$url.='?alerte_identifiant='.urlencode($mesalertes_liste->occurrence[$i]['identifiant']);
		if(
			!array_key_exists('alerte_identifiant',$_SESSION) || 
			$mesalertes_liste->occurrence[$i]['identifiant']!=$_SESSION['alerte_identifiant'] ||
			!preg_match('/(ma-liste|ma-selection)\.php/',$_SERVER['PHP_SELF'])
		)
			$url.='&annonce_ville=';
		
		$onclick=' onclick="window.location=\''.ma_htmlentities($url).'\'"';
		
		if(sizeof($mesalertes_type)>0) $mesalertes_type[0]=str_replace(array('Chambre de bonne','Colocation'),array('Ch. de bonne','Coloc.'),$mesalertes_type[0]);
		if(sizeof($mesalertes_type)>1) $mesalertes_type[1]=str_replace(array('Chambre de bonne','Colocation'),array('Ch. de bonne','Coloc.'),$mesalertes_type[1]);
		if(sizeof($mesalertes_type)>2) $mesalertes_type[2]=str_replace(array('Chambre de bonne','Colocation'),array('Ch. de bonne','Coloc.'),$mesalertes_type[2]);
		
		print
		('
		    <div class="alerte'.(array_key_exists('alerte_identifiant',$_SESSION) && $mesalertes_liste->occurrence[$i]['identifiant']==$_SESSION['alerte_identifiant'] && preg_match('/(ma-liste|ma-selection)\.php/',$_SERVER['PHP_SELF'])?' selected':'').'">
		    <h2><a href="'.ma_htmlentities($url).'">Mon alerte '.($i+1).'</a><img src="'.HTTP_STATIC.'/img/fleche.png" width="20" height="20" alt=""></h2>
			<div>
			<table>
			 <tr>
			   <td colspan="3"'.$onclick.'><img src="'.HTTP_STATIC.'/img/marker.png" width="14" height="23" alt="">'.ma_htmlentities($mesalertes_liste->occurrence[$i]['code_postal'].' '.ucwords(strtolower($mesalertes_liste->occurrence[$i]['ville']))).'</td>
			 </tr>
			 <tr>
			   <td'.(sizeof($mesalertes_type)>0?$onclick:' class="trans-border"').'>'.(sizeof($mesalertes_type)>0?ma_htmlentities($mesalertes_type[0]):'<span></span>').'</td>
			   <td'.(sizeof($mesalertes_type)>1?$onclick:' class="trans-border"').'>'.(sizeof($mesalertes_type)>1?ma_htmlentities($mesalertes_type[1]):'<span></span>').'</td>
			   <td'.(sizeof($mesalertes_type)>2?$onclick:' class="trans-border"').'>'.(sizeof($mesalertes_type)>2?ma_htmlentities($mesalertes_type[2]):'<span></span>').'</td>
			 </tr>
			 <tr>
			   <td colspan="3"'.$onclick.'>Rayon de '.ma_htmlentities($mesalertes_liste->occurrence[$i]['rayon']).' Km</td>
			 </tr>
			</table>
			<ul>
			  <li><a class="mon-alerte" href="mon-alerte.php?alerte_identifiant='.urlencode($mesalertes_liste->occurrence[$i]['identifiant']).'" title="Modifier">Modifier</a></li>
			  <li><a href="suppression-alerte.php?alerte_identifiant='.urlencode($mesalertes_liste->occurrence[$i]['identifiant']).'" title="Supprimer" class="suppression-alerte">Supprimer</a></li>
			</ul>
            <div class="clear"></div>
			</div>
			</div>
		');
	}
	if($i<3)
	//for(;$i<3;$i++)
	{
		print
		('
		    <div class="alerte vide">
            <h2><span></span></h2>
			<div>
		    <ul>
			  <li><a class="mon-alerte" href="mon-alerte.php">Cr&eacute;er une alerte '.($i+1).'</a></li>
		    </ul>
            <div class="clear"></div>
			</div>
			</div>
		');
	}
?>
<div class="clear"></div>
