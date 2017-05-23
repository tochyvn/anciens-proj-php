<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'date.php');
	
	class ld_spool_optimisation extends ld_sql
	{
		private /*var*/ $champs;
		
		/*function ld_spool_veille()
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
					unix_timestamp(spool_optimisation_chargement) as spool_optimisation_chargement,
					unix_timestamp(spool_optimisation_debut) as spool_optimisation_debut,
					unix_timestamp(spool_optimisation_fin) as spool_optimisation_fin,
					spool_optimisation_total,
					(select count(adherent) from spool_optimisation) as spool_optimisation_restant,
					spool_optimisation_envoye
				from preference
			');
			
			if($this->donner_suivant($occurrence))
			{
				$this->champs['chargement']=$occurrence['spool_optimisation_chargement'];
				$this->champs['debut']=$occurrence['spool_optimisation_debut'];
				$this->champs['fin']=$occurrence['spool_optimisation_fin'];
				$this->champs['total']=$occurrence['spool_optimisation_total'];
				if($this->champs['chargement']===NULL)
					$this->champs['restant']=NULL;
				else
					$this->champs['restant']=$occurrence['spool_optimisation_restant'];
				$this->champs['envoye']=$occurrence['spool_optimisation_envoye'];
			}
			
			return true;
		}
		
		private function modifier()
		{
			$this->executer
			('
				update preference
				set
					spool_optimisation_chargement='.(($this->champs['chargement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['chargement'])).'\''):('null')).',
					spool_optimisation_debut='.(($this->champs['debut']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['debut'])).'\''):('null')).',
					spool_optimisation_fin='.(($this->champs['fin']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['fin'])).'\''):('null')).',
					spool_optimisation_total='.(($this->champs['total']!==NULL)?('\''.addslashes($this->champs['total']).'\''):('null')).',
					spool_optimisation_envoye='.(($this->champs['envoye']!==NULL)?('\''.addslashes($this->champs['envoye']).'\''):('null')).'
			');
		}
		
		public function charger()
		{
			if($this->champs['chargement']===NULL)
			{
				$maintenant=time();
				$this->executer
				('
					insert into spool_optimisation (adherent)
					select distinct adherent.identifiant
					from adherent
						inner join alerte on adherent.identifiant=alerte.adherent
					where adherent.abonne=\'OUI\'
						and adherent.brule=\'NON\'
						and adherent.validation=\'OUI\'
						and adherent.spamtrap=\'NON\'
						and datediff(adherent.date_abonnement,now())
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
							(select spool_veille_jour from preference limit 1) is null
							
							or datediff(date_abonnement + interval (select spool_veille_jour from preference limit 1) day,now())>0
							or datediff(date_action + interval (select spool_veille_jour from preference limit 1) day,now())>0
							or datediff(date_visite + interval (select spool_veille_jour from preference limit 1) day,now())>0
							
							/*or (adherent.email not rlike \'@(hotmail|live|msn|outlook|dbmail|dartybox|gmail|googlemail|yahoo|ymail|rocketmail)\' and datediff(date_abonnement + interval (select spool_veille_jour from preference limit 1) day,now())>0)
							or (adherent.email not rlike \'@(hotmail|live|msn|outlook|dbmail|dartybox|gmail|googlemail|yahoo|ymail|rocketmail)\' and datediff(date_action + interval (select spool_veille_jour from preference limit 1) day,now())>0)
							or (adherent.email not rlike \'@(hotmail|live|msn|outlook|dbmail|dartybox|gmail|googlemail|yahoo|ymail|rocketmail)\' and datediff(date_visite + interval (select spool_veille_jour from preference limit 1) day,now())>0)
							or (adherent.email rlike \'@(hotmail|live|msn|outlook|dbmail|dartybox)\' and datediff(date_abonnement + interval 6 day,now())>0)
							or (adherent.email rlike \'@(hotmail|live|msn|outlook|dbmail|dartybox)\' and datediff(date_action + interval 6 day,now())>0)
							or (adherent.email rlike \'@(hotmail|live|msn|outlook|dbmail|dartybox)\' and datediff(date_visite + interval 6 day,now())>0)
							or (adherent.email rlike \'@(gmail|googlemail)\' and datediff(date_abonnement + interval 6 day,now())>0)
							or (adherent.email rlike \'@(gmail|googlemail)\' and datediff(date_action + interval 6 day,now())>0)
							or (adherent.email rlike \'@(gmail|googlemail)\' and datediff(date_visite + interval 6 day,now())>0)
							or (adherent.email rlike \'@(yahoo|ymail|rocketmail)\' and datediff(date_abonnement + interval 6 day,now())>0)
							or (adherent.email rlike \'@(yahoo|ymail|rocketmail)\' and datediff(date_action + interval 6 day,now())>0)
							or (adherent.email rlike \'@(yahoo|ymail|rocketmail)\' and datediff(date_visite + interval 6 day,now())>0)*/
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
			
			return false;
		}
		
		public function vider()
		{
			if($this->champs['chargement']!==NULL)
			{
				$this->executer('truncate table spool_optimisation');
				
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
				
				$this->executer
				('
					select unix_timestamp(timestamp(date(now()-interval (spool_inactivite_jour+datediff(current_date(),spool_inactivite_dernier)-1) day))) as debut,
						unix_timestamp(timestamp(date(now()-interval spool_inactivite_jour day)+interval 1 day-interval 1 second)) as fin
					from preference
					limit 1
				');

				$this->donner_suivant($ecart);
				
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
						select adherent.identifiant as adherent
						from spool_optimisation
							inner join adherent on spool_optimisation.adherent=adherent.identifiant
						order by adherent.date_abonnement desc
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
						
						if($adherent->envoyer('optimisation')===false)
							$rejete++;
						else
							$envoye++;
						
						$this->executer('delete from spool_optimisation where adherent=\''.addslashes($spool[$i]['adherent']).'\'');
						
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
					
					print('<div>Restant: '.$this->champs['restant'].'</div>'.str_repeat(' ',$preference->spool_flush_mail));
					print('<div>Etat envoye: '.$this->champs['envoye'].'</div>'.str_repeat(' ',$preference->spool_flush_mail));
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
					
					$this->executer('update preference set spool_inactivite_dernier=\''.addslashes(date(_SQL_DATE,time())).'\'');
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
	
	if(isset($_REQUEST['mode']))
	{
		$spool=new ld_spool_optimisation();
		$spool->charger();
		$spool->envoyer();
	}
?>
