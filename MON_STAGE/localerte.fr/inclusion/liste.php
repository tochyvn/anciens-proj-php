<?php
	require_once(PWD_INCLUSION.'sql.php');
	
	class ld_liste extends ld_sql
	{
		private /*var*/ $champs;
		
		/*function ld_liste()
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
			$this->champs['total']=0;
			$this->champs['page_debut']=0;
			$this->champs['page_courante']=0;
			$this->champs['page_fin']=0;
			$this->champs['page_total']=0;
			$this->champs['page_precedente']=0;
			$this->champs['page_suivante']=0;
			$this->champs['occurrence']=array();
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			switch(func_num_args())
			{
				case 2:
					list($requete,$nombre_page)=func_get_args();
					
					if(preg_match('/([^a-z0-9])limit([^a-z0-9])+([0-9]+)([^a-z0-9])*,([^a-z0-9])*([0-9]+)/i',$requete,$resultat))
					{
						if(!preg_match('/([^a-z0-9])+select([^a-z0-9])+sql_calc_found_rows([^a-z0-9])+/i',$requete))
							$requete=preg_replace('/(([^a-z0-9])+select([^a-z0-9*])+)/i','\\1sql_calc_found_rows ',$requete);
						
						$arret=false;
						do
						{
							if(!$this->executer($requete))
								$arret=true;
							else
							{
								while($this->donner_suivant($occurrence))
									$this->champs['occurrence'][]=$occurrence;
								
								$this->champs['total']=$this->donner_ligne_sans_limit();
								
								$this->champs['page_total']=ceil($this->champs['total']/$resultat[6]);
								
								if($this->champs['total']>0 && !sizeof($this->champs['occurrence']))
								{
									$nouvelle_limite=$resultat[1].'limit'.$resultat[2].(($this->champs['page_total']-1)*$resultat[6]).$resultat[4].','.$resultat[5].$resultat[6];
									$requete=str_replace($resultat[0],$nouvelle_limite,$requete);
									$resultat[0]=$nouvelle_limite;
									$resultat[3]=($this->champs['page_total']-1)*$resultat[6];
								}
								else
									$arret=true;
							}
						}
						while(!$arret);
						
						if($this->champs['total'])
						{
							$this->champs['page_courante']=(int)($resultat[3]/$resultat[6])+1;
							
							$this->champs['page_debut']=$this->champs['page_courante']-floor($nombre_page/2);
							if($this->champs['page_debut']<1)
								$this->champs['page_debut']=1;
							
							$this->champs['page_fin']=$this->champs['page_debut']+$nombre_page-1;
							if($this->champs['page_fin']>$this->champs['page_total'])
							{
								$this->champs['page_debut']=$this->champs['page_total']-$nombre_page+1;
								$this->champs['page_fin']=$this->champs['page_total'];
								if($this->champs['page_debut']<1)
									$this->champs['page_debut']=1;
							}
							
							$this->champs['page_precedente']=$this->champs['page_courante']-1;
							if($this->champs['page_precedente']<1)
								$this->champs['page_precedente']=1;
							
							$this->champs['page_suivante']=$this->champs['page_courante']+1;
							if($this->champs['page_suivante']>$this->champs['page_total'])
								$this->champs['page_suivante']=$this->champs['page_total'];
						}
						
						break;
					}
					
				case 1:
					list($requete)=func_get_args();
					
					$this->executer($requete);
					while($this->donner_suivant($occurrence))
						$this->champs['occurrence'][]=$occurrence;
					
					$this->champs['total']=sizeof($this->champs['occurrence']);
					if($this->champs['total'])
					{
						$this->champs['page_debut']=1;
						$this->champs['page_courante']=1;
						$this->champs['page_fin']=1;
						$this->champs['page_total']=1;
						$this->champs['page_precedente']=1;
						$this->champs['page_suivante']=1;
					}
					
					break;
				default:
					trigger_error('Nombre d\'arguments incorrect'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
			}
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
	}
?>