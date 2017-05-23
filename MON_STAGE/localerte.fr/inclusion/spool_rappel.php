<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'date.php');
	
	class ld_spool_rappel extends ld_sql
	{
		private /*var*/ $champs;
		
		/*function ld_spool_rappel()
		{
			if(floatval(phpversion())<5)
			{
				$func_get_args=func_get_args();
				call_user_func_array(array(&$this,'__construct'),$func_get_args);
				foreach($this->champs as $clef=>$valeur)
					$this->{$clef}=&$this->champs[$clef];
			}
		}*/
		
		function __construct()
		{
			$this->champs=array();
			$this->champs['chargement']=NULL;
			$this->champs['debut']=NULL;
			$this->champs['fin']=NULL;
			$this->champs['total']=NULL;
			$this->champs['restant']=NULL;
			$this->champs['envoye']=NULL;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->lire();
		}
		
		/*function __destruct()
		{
			$this->fermer();
		}*/
		
		function __get($variable)
		{
			if(array_key_exists($variable,$this->champs))
				return $this->champs[$variable];
			else
			{
				trigger_error('Variable '.$variable.' non d&eacute;finie'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
		}
		
		function __set($variable,$valeur)
		{
			if(array_key_exists($variable,$this->champs))
			{
				if($variable!='chargement' && $variable!='debut' && $variable!='fin' && $variable!='debut' && $variable!='total' && $variable!='restant' && $variable!='envoye')
					$this->champs[$variable]=$valeur;
				else
				{
					trigger_error('Variable '.$variable.' non modifiable'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
				}
			}
			else
			{
				trigger_error('Variable '.$variable.' non d&eacute;finie'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
		}
		
		public function lire()
		{
			$this->executer
			('
				select
					unix_timestamp(spool_rappel_chargement) as spool_rappel_chargement,
					unix_timestamp(spool_rappel_debut) as spool_rappel_debut,
					unix_timestamp(spool_rappel_fin) as spool_rappel_fin,
					spool_rappel_total,
					(select count(adherent) from spool_rappel) as spool_rappel_restant,
					spool_rappel_envoye
				from preference
			');
			
			if($this->donner_suivant($occurrence))
			{
				$this->champs['chargement']=$occurrence['spool_rappel_chargement'];
				$this->champs['debut']=$occurrence['spool_rappel_debut'];
				$this->champs['fin']=$occurrence['spool_rappel_fin'];
				$this->champs['total']=$occurrence['spool_rappel_total'];
				if($this->champs['chargement']===NULL)
					$this->champs['restant']=NULL;
				else
					$this->champs['restant']=$occurrence['spool_rappel_restant'];
				$this->champs['envoye']=$occurrence['spool_rappel_envoye'];
			}
			
			return true;
		}
		
		private function modifier()
		{
			$this->executer
			('
				update preference
				set
					spool_rappel_chargement='.(($this->champs['chargement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['chargement'])).'\''):('null')).',
					spool_rappel_debut='.(($this->champs['debut']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['debut'])).'\''):('null')).',
					spool_rappel_fin='.(($this->champs['fin']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['fin'])).'\''):('null')).',
					spool_rappel_total='.(($this->champs['total']!==NULL)?('\''.addslashes($this->champs['total']).'\''):('null')).',
					spool_rappel_envoye='.(($this->champs['envoye']!==NULL)?('\''.addslashes($this->champs['envoye']).'\''):('null')).'
			');
		}
		
		public function charger()
		{
			if($this->champs['chargement']===NULL)
			{
				$this->executer
				('
					select datediff(current_date(),spool_rappel_dernier) as ecart
					from preference
					limit 1
				');
				$this->donner_suivant($occurrence);
				
				if($occurrence['ecart'])
				{
					$ajourd_hui=time();
					$rappel_cas1=array();
					$rappel_cas2=array();
					$rappel_cas3=array();
					for($i=0;$i<$occurrence['ecart'];$i++)
					{
						$date=mktime(0,0,0,date('m',$ajourd_hui),date('d',$ajourd_hui)-$i,date('Y',$ajourd_hui));
						$rappel_cas1[]='datediff(\''.addslashes(date(_SQL_DATE,$date)).'\',adherent.date_action)%(select spool_rappel_interval from preference limit 1)=0';
						$rappel_cas2[]='datediff(\''.addslashes(date(_SQL_DATE,$date)).'\',adherent.date_abonnement)%(select spool_rappel_interval from preference limit 1)=0';
						$rappel_cas3[]='datediff(\''.addslashes(date(_SQL_DATE,$date)).'\',\'2008-09-01 00:00:00\')%(select spool_rappel_interval from preference limit 1)=0';
					}
					
					$this->executer
					('
						insert into spool_rappel (adherent)
						select distinct adherent.identifiant
						from adherent
							inner join alerte on adherent.identifiant=alerte.adherent
						where adherent.abonne=\'OUI\'
							and adherent.brule=\'NON\'
							and adherent.validation=\'OUI\'
							and adherent.spamtrap=\'NON\'
							and
							(
								(select hardbounce_limite from preference limit 1) is null
								or adherent.hardbounce<(select hardbounce_limite from preference limit 1)
							)
							and
							(
								(select softbounce_limite from preference limit 1) is null
								or adherent.softbounce<(select softbounce_limite from preference limit 1)
							)
							and
							(
								(select plainte_limite from preference limit 1) is null
								or adherent.plainte<(select plainte_limite from preference limit 1)
							)
							and
							(
								(adherent.email not rlike \'@(hotmail|live|msn|outlook|dbmail|dartybox)\' and (select spool_veille_jour from preference limit 1) is null)
								or (adherent.email not rlike \'@(hotmail|live|msn|outlook|dbmail|dartybox)\' and datediff(date_abonnement + interval (select spool_veille_jour from preference limit 1) day,now())>0)
								or (adherent.email not rlike \'@(hotmail|live|msn|outlook|dbmail|dartybox)\' and datediff(date_action + interval (select spool_veille_jour from preference limit 1) day,now())>0)
							)
							and
							(
								(
									adherent.date_action is not null
									and ('.implode(' or ',$rappel_cas1).')
									and datediff(\''.addslashes(date(_SQL_DATE,$date)).'\',adherent.date_action)>0
								)
								or
								(
									adherent.date_action is null
									and adherent.date_abonnement>=\'2008-09-01 00:00:00\'
									and ('.implode(' or ',$rappel_cas2).')
									and datediff(\''.addslashes(date(_SQL_DATE,$date)).'\',adherent.date_abonnement)>0
								)
								or
								(
									adherent.date_action is null
									and adherent.date_abonnement<\'2008-09-01 00:00:00\'
									and ('.implode(' or ',$rappel_cas3).')
									and datediff(\''.addslashes(date(_SQL_DATE,$date)).'\',\'2008-09-01 00:00:00\')>0
								)
							)
					');
					
					$this->champs['chargement']=time();
					$this->champs['debut']=NULL;
					$this->champs['fin']=NULL;
					$this->champs['total']=$this->donner_ligne_affecte();
					$this->champs['restant']=$this->champs['total'];
					$this->champs['envoye']='NON';
					
					$this->modifier();
					
					return true;
				}
			}
			
			return false;
		}
		
		public function vider()
		{
			if($this->champs['chargement']!==NULL)
			{
				$this->executer('truncate table spool_rappel');
				
				$this->champs['chargement']=NULL;
				$this->champs['debut']=NULL;
				$this->champs['fin']=NULL;
				$this->champs['total']=NULL;
				$this->champs['restant']=NULL;
				$this->champs['envoye']=NULL;
					
				$this->modifier();
			
				return true;
			}
			
			return false;
		}
		
		public function envoyer()
		{
			if($this->champs['chargement']!==NULL && $this->champs['envoye']=='NON')
			{
				if($this->champs['debut']===NULL)
					$this->champs['debut']=time();
				
				$this->champs['envoye']='OUI';
				$this->modifier();
				
				set_time_limit(0);
				$max_execution_time=ini_get('max_execution_time');
				//ini_set('max_execution_time',0);
				$ignore_user_abort=ignore_user_abort(true);
				
				$compteur=0;
				$total=0;
				$position=0;
				$depart=time();
				
				do
				{
					
					$preference=new ld_preference();
					
					print('<span class="important">D&eacute;but du traitement du spool: '.strftime(STRING_DATETIMECOMLPLET).'</span><br />'.str_repeat(' ',$preference->spool_flush_mail));
					flush();
					
					$compteur++;
					
					$envoye=0;
					$rejete=0;
					
					$debut=time();
					
					$this->executer
					('
						(
							select spool_rappel.adherent
							from spool_rappel
								inner join adherent on spool_rappel.adherent=adherent.identifiant
							where adherent.email in (\'aicom123@hotmail.fr\', \'aicom123@gmail.com\', \'aicom123@yahoo.fr\', \'aicom123@caramail.com\', \'aicom123@orange.fr\', \'aicom123@voila.fr\', \'aicom123@laposte.net\', \'aicom123@aol.fr\', \'aicom123@neuf.fr\', \'aicom123@free.fr\')
						)
						union
						(
							select spool_rappel.adherent
							from spool_rappel
								inner join adherent on spool_rappel.adherent=adherent.identifiant
							where adherent.email not in (\'aicom123@hotmail.fr\', \'aicom123@gmail.com\', \'aicom123@yahoo.fr\', \'aicom123@caramail.com\', \'aicom123@orange.fr\', \'aicom123@voila.fr\', \'aicom123@laposte.net\', \'aicom123@aol.fr\', \'aicom123@neuf.fr\', \'aicom123@free.fr\')
						)
						limit '.$preference->spool_boucle_mail.'
					');
					
					$spool=array();
					while($this->donner_suivant($spool[]));
					unset($spool[sizeof($spool)-1]);
					
					print('<div>Position: '.$position.'</div>'.str_repeat(' ',$preference->spool_flush_mail));
					print('<div>Nombre: '.sizeof($spool).'</div>'.str_repeat(' ',$preference->spool_flush_mail));
					print('<div id="envoye_'.$compteur.'">Envoyé: '.$envoye.'</div>'.str_repeat(' ',$preference->spool_flush_mail));
					print('<div id="rejete_'.$compteur.'">Réjeté: '.$rejete.'</div>'.str_repeat(' ',$preference->spool_flush_mail));
					flush();
					
					for($i=0;$i<sizeof($spool);$i++)
					{
						$adherent=new ld_adherent();
						$adherent->identifiant=$spool[$i]['adherent'];
						
						if($adherent->envoyer('rappel')===false)
							$rejete++;
						else
							$envoye++;
						
						$this->executer('delete from spool_rappel where adherent=\''.addslashes($spool[$i]['adherent']).'\'');
						
						if(($i+1)%$preference->spool_message_interval==0 || ($preference->spool_message_interval>$preference->spool_boucle_mail && ($i+1)%$preference->spool_boucle_mail==0))
						{
							$this->ecrire('envoye_'.$compteur.'','Envoyé: '.$envoye,$preference);
							$this->ecrire('rejete_'.$compteur.'','Rejeté: '.$rejete,$preference);
						}
						
						usleep($preference->spool_mail_pause);
					}
					
					$this->ecrire('envoye_'.$compteur.'','Envoyé: '.$envoye,$preference);
					$this->ecrire('rejete_'.$compteur.'','Rejeté: '.$rejete,$preference);
					
					$this->lire();
					
					$total+=$envoye;
					$position+=$envoye+$rejete;
					
					print('<span class="important">Fin du traitement du spool: '.duree(time()-$debut,'%mm %ss').'</span><br />'.str_repeat(' ',$preference->spool_flush_mail));
					print('<span class="important">Moyenne d\'envoi: '.round($total/(time()-$depart+1)*60,2).' par minute</span><br />'.str_repeat(' ',$preference->spool_flush_mail));
					flush();
					
					print('<br />'.str_repeat(' ',$preference->spool_flush_mail));
					flush();
					
					usleep($preference->spool_boucle_pause);
				}
				while($this->champs['restant']!=0 && $this->champs['envoye']=='OUI');
				
				if($this->champs['restant']==0 && $this->champs['fin']===NULL)
				{
					$this->champs['fin']=time();
					$this->champs['envoye']='NON';
					$this->modifier();
					
					$this->executer('update preference set spool_rappel_dernier=\''.addslashes(date(_SQL_DATE,time())).'\'');
				}
				
				ini_set('max_execution_time',$max_execution_time);
				ignore_user_abort($ignore_user_abort);
				
				return true;
			}
			
			return false;
		}
		
		public function stopper()
		{
			if($this->champs['envoye']=='OUI')
			{
				$this->champs['envoye']='NON';
				
				$this->modifier();
				
				return true;
			}
			
			return false;
		}
		
		private function ecrire($id, $message, $preference)
		{
			print
			('
				<script language="javascript">
					document.getElementById(\''.ma_htmlentities($id).'\').innerHTML=\''.ma_htmlentities($message).'\';
				</script>
				<noscript>'.ma_htmlentities($message).'<br /></noscript>'.str_repeat(' ',$preference->spool_flush_mail).'
			');
			flush();
		}
	}
?>