<?php
	require_once(PWD_INCLUSION.'sql.php');
	
	class ld_localisation_recherche extends ld_sql
	{
		public function __construct()
		{
			if(!ld_localisation_recherche::ouvrir())
				return false;
			
			return true;
		}
		
		public function remplacer()
		{
			/*ld_localisation_recherche::executer
			('
				replace into localisation_recherche
				select
					concat(\'VILLE_\',identifiant),
					concat(code_postal,\' \',nom)
				from ville
			');
			ld_localisation_recherche::executer
			('
				replace into localisation_recherche
				select
					concat(\'DEPARTEMENT_\',identifiant),
					concat(code,\' \',nom)
				from departement
			');*/
			ld_localisation_recherche::executer
			('
				replace into localisation_recherche
				select
					concat(\'REGION_\',identifiant),
					nom
				from region
			');
			
			return true;
		}
		
		public function creer_xml($chaine)
		{
			$recherche_sur_chaine=array
			(
				 '/\' +/',
				 '/[^a-zA-Z0-9ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ ]/',
				 '/ +/',
				 '/^ $/',
				 '/^ /',
				 '/ $/',
				 '/ ((e|è)me( |$))/i',
				 '/ (er( |$))/i',
				 '/^PARIS I(er?)?$/i',
				 '/^PARIS II((e|è)m?e?)?$/i',
				 '/^PARIS III((e|è)m?e?)?$/i',
				 '/^PARIS IV((e|è)m?e?)?$/i',
				 '/^PARIS V((e|è)m?e?)?$/i',
				 '/^PARIS VI((e|è)m?e?)?$/i',
				 '/^PARIS VII((e|è)m?e?)?$/i',
				 '/^PARIS VIII((e|è)m?e?)?$/i',
				 '/^PARIS IX((e|è)m?e?)?$/i',
				 '/^PARIS X((e|è)m?e?)?$/i',
				 '/^PARIS XI((e|è)m?e?)?$/i',
				 '/^PARIS XII((e|è)m?e?)?$/i',
				 '/^PARIS XIII((e|è)m?e?)?$/i',
				 '/^PARIS XIV((e|è)m?e?)?$/i',
				 '/^PARIS XV((e|è)m?e?)?$/i',
				 '/^PARIS XVI((e|è)m?e?)?$/i',
				 '/^PARIS XVII((e|è)m?e?)?$/i',
				 '/^PARIS XVIII((e|è)m?e?)?$/i',
				 '/^PARIS XIX((e|è)m?e?)?$/i',
				 '/^PARIS XX((e|è)m?e?)?$/i',
				 '/^PARIS ([1-9])((e|è)m?e?)?$/i',
				 '/^PARIS ([1-9])(er?)?$/i',
				 '/^PARIS ([1-2][0-9])((e|è)m?e?)?$/i',
				 '/^PARIS ([1-2][0-9])(er?)?$/i',
				 '/^MARSEILLE I(er?)?$/i',
				 '/^MARSEILLE II((e|è)m?e?)?$/i',
				 '/^MARSEILLE III((e|è)m?e?)?$/i',
				 '/^MARSEILLE IV((e|è)m?e?)?$/i',
				 '/^MARSEILLE V((e|è)m?e?)?$/i',
				 '/^MARSEILLE VI((e|è)m?e?)?$/i',
				 '/^MARSEILLE VII((e|è)m?e?)?$/i',
				 '/^MARSEILLE VIII((e|è)m?e?)?$/i',
				 '/^MARSEILLE IX((e|è)m?e?)?$/i',
				 '/^MARSEILLE X((e|è)m?e?)?$/i',
				 '/^MARSEILLE XI((e|è)m?e?)?$/i',
				 '/^MARSEILLE XII((e|è)m?e?)?$/i',
				 '/^MARSEILLE XIII((e|è)m?e?)?$/i',
				 '/^MARSEILLE ([1-9])((e|è)m?e?)?$/i',
				 '/^MARSEILLE ([1-9])(er?)?$/i',
				 '/^MARSEILLE ([1-2][0-9])((e|è)m?e?)?$/i',
				 '/^MARSEILLE ([1-2][0-9])(er?)?$/i',
				 '/^LYON I(er?)?$/i',
				 '/^LYON II((e|è)m?e?)?$/i',
				 '/^LYON III((e|è)m?e?)?$/i',
				 '/^LYON IV((e|è)m?e?)?$/i',
				 '/^LYON V((e|è)m?e?)?$/i',
				 '/^LYON VI((e|è)m?e?)?$/i',
				 '/^LYON VII((e|è)m?e?)?$/i',
				 '/^LYON VIII((e|è)m?e?)?$/i',
				 '/^LYON IX((e|è)m?e?)?$/i',
				 '/^LYON ([1-9])((e|è)m?e?)?$/i',
				 '/^LYON ([1-9])(er?)?$/i',
				 '/^LYON ([1-2][0-9])((e|è)m?e?)?$/i',
				 '/^LYON ([1-2][0-9])(er?)?$/i',
				 '/^IDF$/i',
			);
			$remplacement_sur_chaine=array
			(
				'\'',
				' ',
				' ',
				'',
				'',
				'',
				'$1',
				'$1',
				'PARIS 75001',
				'PARIS 75002',
				'PARIS 75003',
				'PARIS 75004',
				'PARIS 75005',
				'PARIS 75006',
				'PARIS 75007',
				'PARIS 75008',
				'PARIS 75009',
				'PARIS 75010',
				'PARIS 75011',
				'PARIS 75012',
				'PARIS 75013',
				'PARIS 75014',
				'PARIS 75015',
				'PARIS 75016',
				'PARIS 75017',
				'PARIS 75018',
				'PARIS 75019',
				'PARIS 75020',
				'PARIS 7500$1',
				'PARIS 7500$1',
				'PARIS 750$1',
				'PARIS 750$1',
				'MARSEILLE 13001',
				'MARSEILLE 13002',
				'MARSEILLE 13003',
				'MARSEILLE 13004',
				'MARSEILLE 13005',
				'MARSEILLE 13006',
				'MARSEILLE 13007',
				'MARSEILLE 13008',
				'MARSEILLE 13009',
				'MARSEILLE 13010',
				'MARSEILLE 13011',
				'MARSEILLE 13012',
				'MARSEILLE 13013',
				'MARSEILLE 1300$1',
				'MARSEILLE 1300$1',
				'MARSEILLE 130$1',
				'MARSEILLE 130$1',
				'LYON 69001',
				'LYON 69002',
				'LYON 69003',
				'LYON 69004',
				'LYON 69005',
				'LYON 69006',
				'LYON 69007',
				'LYON 69008',
				'LYON 69009',
				'LYON 6900$1',
				'LYON 6900$1',
				'LYON 690$1',
				'LYON 690$1',
				'ILE DE FRANCE',
			);
			
			$recherche_sur_mot=array
			(
				 '/^st$/i',
				 '/^ste$/i',
				 '/2A/i',
				 '/2B/i',
			);
			$remplacement_sur_mot=array
			(
				'saint',
				'sainte',
				'20',
				'20',
			);
			
			$exclusion_sur_mot=array('');
			
			$masque=$chaine;
			$masque=preg_replace($recherche_sur_chaine,$remplacement_sur_chaine,$masque);
			
			if(preg_match_all('/[0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ][0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\'"]*/',$masque,$resultat))
				$mot_debut=$resultat[0];
			else
				$mot_debut=array();
			//$mot_debut=str_word_count($masque,1,'0123456789ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ');
			$mot_fin=array();
			for($i=0;$i<sizeof($mot_debut);$i++)
			{
				$mot_debut[$i]=preg_replace($recherche_sur_mot,$remplacement_sur_mot,$mot_debut[$i]);
				if(array_search($mot_debut[$i],$exclusion_sur_mot)===false)
					$mot_fin[]=$mot_debut[$i];
			}
			
			if(sizeof($mot_fin))
				$masque='+'.implode('* +',array_map('addslashes',$mot_fin)).'*';
			else
				$masque='';
			
			$xml='<?xml version="1.0" encoding="UTF-8"?>'.CRLF;
	
			if($masque!='')
			{
				$xml.='<items>'.CRLF;
				
				ld_localisation_recherche::executer
				('
					select
							identifiant,
							designation,
							match(designation) against (\''.$masque.'\' in boolean mode) as score
						from localisation_recherche
						having score
						order by score desc, designation
						limit 20
				');
				
				while(ld_localisation_recherche::donner_suivant($occurrence))
				{
					$xml.='<item>'.CRLF;
					$xml.='<value>'.htmlspecialchars(utf8_encode($occurrence['identifiant'])).'</value>'.CRLF;
					$xml.='<text>'.htmlspecialchars(utf8_encode($occurrence['designation'])).'</text>'.CRLF;
					$xml.='</item>'.CRLF;
				}
				
				$xml.='</items>'.CRLF;
			}
			else
				$xml.='<items />'.CRLF;
			
			return $xml;
		}

		public function creer_json($chaine=NULL)
		{
			$tableau=array();
			
			ld_localisation_recherche::executer
			('
				select
					identifiant,
					designation,
					if(identifiant like \'PAYS_%\',0,
						if(identifiant like \'REGION_%\',1,
							if(identifiant like \'DEPARTEMENT_%\',2,3))) as zone
				from localisation_recherche
				where 1
				'.($chaine!==NULL?'and (instr(designation,\''.addslashes($chaine).'\')=1 or instr(designation,\''.addslashes(' '.$chaine).'\'))':'').'
				order by zone, designation
			');
			
			while(ld_localisation_recherche::donner_suivant($occurrence))
			{
				$temp=array();
				$temp['value']=$occurrence['identifiant'];
				$temp['text']=utf8_encode(ucwords(strtolower($occurrence['designation'])));
				if(!$temp['text']) die('merde');
				$tableau[]=$temp;
			}
			
			return json_encode($tableau);
		}
	}
	
	if(isset($_REQUEST['localisation_ajax']))
	{
		$localisation_recherche=new ld_localisation_recherche();
		$contenu=$localisation_recherche->creer_xml(utf8_decode($_REQUEST['localisation_ajax']));
		
		header('content-type: text/xml');
		header('content-length: '.strlen($contenu));
		
		die($contenu);
	}

	if(isset($_REQUEST['localisation_json']))
	{
		$tableau=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9');
		for($i=0;$i<sizeof($tableau);$i++)
			for($j=0;$j<sizeof($tableau);$j++)
			{
				$localisation_recherche=new ld_localisation_recherche();
				file_put_contents(PWD_INCLUSION.'/prive/temp/localisation-'.$tableau[$i].$tableau[$j].'.json',$localisation_recherche->creer_json($tableau[$i].$tableau[$j]));
			}
	}
?>