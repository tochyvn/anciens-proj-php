<?php
	require_once(PWD_INCLUSION.'fpdf/fpdf.php');
	require_once(PWD_INCLUSION.'sql.php');
	
	class ld_facture_pdf extends FPDF
	{
		private /*var*/ $largeur;
		private /*var*/ $hauteur;
		private /*var*/ $marge;
		private /*var*/ $sql;
		
		/*function ld_facture_pdf()
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
			$this->sql=new ld_sql();
			
			if(!$this->sql->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
		}
		
		/*function __destruct()
		{
			$this->sql->fermer();
		}*/
		
		public function creer($identifiant,$mode)
		{
			$this->sql->executer
			('
				SELECT
					facture.identifiant AS identifiant,
					facture.nom AS nom,
					facture.prenom AS prenom,
					facture.raison_sociale AS raison_sociale,
					facture.adresse AS adresse,
					facture.complement_adresse AS complement_adresse,
					facture.code_postal AS code_postal,
					facture.ville AS ville,
					unix_timestamp(facture.emission) AS emission
				FROM facture
				WHERE facture.identifiant=\''.addslashes($identifiant).'\'
			');
			if(!$this->sql->donner_suivant($occurrence_facture))
			{
				trigger_error('R&eacute;f&eacute;rence de facture inconnue'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->sql->executer
			('
				SELECT 
					reference,
					designation,
					prix_ht,
					quantite,
					tva
				FROM facture_ligne
				WHERE facture=\''.addslashes($identifiant).'\'
			');
			while($this->sql->donner_suivant($occurrence_facture_ligne[]));
			unset($occurrence_facture_ligne[sizeof($occurrence_facture_ligne)-1]);
			
			$this->marge=10;
			$this->largeur=210;
			$this->hauteur=297;
			
			$this->FPDF('P','mm','A4');
			
			$this->SetMargins($this->marge,$this->marge,$this->marge);
			
			$this->SetAuthor='AICOM';
			$this->SetCreator='LD';
			$this->SetKeywords='';
			$this->SetSubject='Facture '.$occurrence_facture['identifiant'];
			$this->SetTitle='Facture '.$occurrence_facture['identifiant'];
			
			$this->AddPage();
			
			$hauteur=4;
			$ecart=5;
			
			//COORDONNEE
			$coordonnee_champ=35;
			$coordonnee_valeur=$this->largeur-$coordonnee_champ-$this->marge*2-2;
			$this->SetFillColor(221,221,221);
			$this->SetFont('Arial','BI',10);
			$this->Cell($coordonnee_champ,$hauteur,'Raison sociale :',0,0,'R',1);
			if($occurrence_facture['raison_sociale']!='')
			{
				$this->Write($hauteur,' ');
				$this->SetFont('Arial','',10);
				$this->Cell($coordonnee_valeur,$hauteur,$occurrence_facture['raison_sociale']);
			}
			$this->ln($ecart);
			$this->SetFont('Arial','BI',10);
			$this->Cell($coordonnee_champ,$hauteur,'Nom Prénom :',0,0,'R',1);
			if($occurrence_facture['raison_sociale']=='')
			{
				$this->Write($hauteur,' ');
				$this->SetFont('Arial','',10);
				$this->Cell($coordonnee_valeur,$hauteur,strtoupper($occurrence_facture['nom']).' '.ucwords(strtolower($occurrence_facture['prenom'])));
			}
			$this->ln($ecart);
			$this->SetFont('Arial','BI',10);
			$this->Cell($coordonnee_champ,$hauteur,'Adresse :',0,0,'R',1);
			$this->Write($hauteur,' ');
			$this->SetFont('Arial','',10);
			$this->Cell($coordonnee_valeur,$hauteur,$occurrence_facture['adresse']);
			$this->ln($ecart-1);
			$this->SetFont('Arial','BI',10);
			$this->Cell($coordonnee_champ,$hauteur,'',0,0,'R',1);
			$this->Write($hauteur,' ');
			$this->SetFont('Arial','',10);
			$this->Cell($coordonnee_valeur,$hauteur,$occurrence_facture['complement_adresse']);
			$this->ln($ecart-1);
			$this->SetFont('Arial','BI',10);
			$this->Cell($coordonnee_champ,$hauteur,'',0,0,'R',1);
			$this->Write($hauteur,' ');
			$this->SetFont('Arial','',10);
			$this->Cell($coordonnee_valeur,$hauteur,$occurrence_facture['code_postal'].' '.ucwords(strtolower($occurrence_facture['ville'])));
			
			//FACTURE
			$this->ln($ecart*2);
			$this->SetFont('Arial','BI',10);
			$this->Cell($coordonnee_champ,$hauteur,'Facture N° : ',0,0,'R',1);
			$this->Write($hauteur,' ');
			$this->SetFont('Arial','',10);
			$this->Cell($coordonnee_valeur,$hauteur,$occurrence_facture['identifiant']);
			$this->ln($ecart);
			$this->SetFont('Arial','BI',10);
			$this->Cell($coordonnee_champ,$hauteur,'Emise le : ',0,0,'R',1);
			$this->Write($hauteur,' ');
			$this->SetFont('Arial','',10);
			$this->Cell($coordonnee_valeur,$hauteur,date('d/m/Y',$occurrence_facture['emission']));
			
			$this->ln($ecart*6);
			
			//TABLEAU
			$reference_largeur=23;
			$designation_largeur=78;
			$prix_ht_largeur=22;
			$quantite_largeur=10;
			$tva_largeur=16;
			$champ_largeur=$reference_largeur+$designation_largeur+$prix_ht_largeur+$quantite_largeur+$tva_largeur+4;
			$total_ht_largeur=$this->largeur-$champ_largeur-$this->marge*2-2;
			$this->SetFont('Arial','BI',9);
			$this->Cell($reference_largeur,$hauteur,'Référence',0,0,'L',1);
			$this->Write($hauteur,' ');
			$this->Cell($designation_largeur,$hauteur,'Désignation',0,0,'L',1);
			$this->Write($hauteur,' ');
			$this->Cell($prix_ht_largeur,$hauteur,'PU HT',0,0,'R',1);
			$this->Write($hauteur,' ');
			$this->Cell($quantite_largeur,$hauteur,'Qte',0,0,'R',1);
			$this->Write($hauteur,' ');
			$this->Cell($tva_largeur,$hauteur,'TVA',0,0,'R',1);
			$this->Write($hauteur,' ');
			$this->Cell($total_ht_largeur,$hauteur,'Montant TTC',0,0,'R',1);
						
			$this->SetFont('Arial','',9);
			
			$montant_ht=0;
			$montant_tva=0;
			for($i=0;$i<sizeof($occurrence_facture_ligne);$i++)
			{
				$this->ln($ecart);
				$this->Cell($reference_largeur,$hauteur,$occurrence_facture_ligne[$i]['reference']);
				$this->Write($hauteur,' ');
				$this->Cell($designation_largeur,$hauteur,$occurrence_facture_ligne[$i]['designation']);
				$this->Write($hauteur,' ');
				$this->Cell($prix_ht_largeur,$hauteur,number_format(round($occurrence_facture_ligne[$i]['prix_ht'],2),2,',',' ').' €',0,0,'R');
				$this->Write($hauteur,' ');
				$this->Cell($quantite_largeur,$hauteur,$occurrence_facture_ligne[$i]['quantite'],0,0,'R');
				$this->Write($hauteur,' ');
				$this->Cell($tva_largeur,$hauteur,number_format(round($occurrence_facture_ligne[$i]['tva'],2),2,',',' ').' %',0,0,'R');
				$this->Write($hauteur,' ');
				$this->Cell($total_ht_largeur,$hauteur,number_format(round($occurrence_facture_ligne[$i]['prix_ht']*$occurrence_facture_ligne[$i]['quantite']*(1+$occurrence_facture_ligne[$i]['tva']/100),2),2,',',' ').' €',0,0,'R');
				$montant_ht+=$occurrence_facture_ligne[$i]['prix_ht']*$occurrence_facture_ligne[$i]['quantite'];
				$montant_tva+=$occurrence_facture_ligne[$i]['prix_ht']*$occurrence_facture_ligne[$i]['quantite']*$occurrence_facture_ligne[$i]['tva']/100;
			}
			$montant_ttc=$montant_ht+$montant_tva;
			
			//TOTAL
			$this->ln($ecart*6);
			$this->SetFont('Arial','BI',10);
			$this->Cell($champ_largeur,$hauteur,'Total HT :',0,0,'R',0);
			$this->SetFont('Arial','',10);
			$this->Write($hauteur,' ');
			$this->Cell($total_ht_largeur,$hauteur,number_format(round($montant_ht,2),2,',',' ').' €',0,0,'R',1);
			$this->ln($ecart);
			$this->SetFont('Arial','BI',10);
			$this->Cell($champ_largeur,$hauteur,'Montant TVA :',0,0,'R',0);
			$this->SetFont('Arial','',10);
			$this->Write($hauteur,' ');
			$this->Cell($total_ht_largeur,$hauteur,number_format(round($montant_tva,2),2,',',' ').' €',0,0,'R',1);
			$this->ln($ecart);
			$this->SetFont('Arial','BI',10);
			$this->Cell($champ_largeur,$hauteur,'Montant TTC :',0,0,'R',0);
			$this->SetFont('Arial','',10);
			$this->Write($hauteur,' ');
			$this->Cell($total_ht_largeur,$hauteur,number_format(round($montant_ttc,2),2,',',' ').' €',0,0,'R',1);
			$this->ln($ecart*3);
			$this->SetFont('Arial','BI',10);
			$this->Cell($champ_largeur,$hauteur,'Condition de paiement :',0,0,'R',0);
			$this->SetFont('Arial','',10);
			$this->Write($hauteur,' ');
			$this->Cell($total_ht_largeur,$hauteur,'à réception',0,0,'R',1);

			if($mode=='F')
				return $this->Output(PWD_INCLUSION.'prive/temp/facture_'.$occurrence_facture['identifiant'].'.pdf','F');
			elseif($mode=='S')
				return $this->Output('facture_'.$occurrence_facture['identifiant'].'.pdf',$mode);
			else
				$this->Output('facture_'.$occurrence_facture['identifiant'].'.pdf',$mode);
		}

		public function Header()
		{
			$this->Image(PWD_INCLUSION.'logo.jpg',$this->marge,5,47,17,'JPG',HTTP_ADHERENT);
			$this->Line($this->marge,25,$this->largeur-$this->marge,25);
			$this->ln(25);
		}
	
		public function Footer()
		{
			$this->Line($this->marge,$this->hauteur-14,$this->largeur-$this->marge,$this->hauteur-14);
			$this->SetY(-10);
			$this->SetFont('Arial','I',8);
			$chaine1='AICOM';
			$largeur1=$this->GetStringWidth($chaine1);
			$chaine2=' 117, rue de la République 83210 LA FARLEDE';
			$largeur2=$this->GetStringWidth($chaine2);
			$this->SetX(($this->largeur-($largeur1+$largeur2))/2);
			$this->SetTextColor(0,0,255);
			$this->Write(0,$chaine1);
			$this->SetTextColor(0,0,0);
			$this->Write(0,$chaine2);
			$this->SetX(0);
			$this->ln(3);
			$chaine1='Tél: 04.94.27.81.71  Fax: 04.94.27.81.72 E-mail: ';
			$largeur1=$this->GetStringWidth($chaine1);
			$chaine2='aicom@wanadoo.fr';
			$largeur2=$this->GetStringWidth($chaine2);
			$this->SetX(($this->largeur-($largeur1+$largeur2))/2);
			$this->SetTextColor(0,0,0);
			$this->Write(0,$chaine1);
			$this->SetTextColor(0,0,255);
			$this->Write(0,$chaine2,'mailto:'.$chaine2);
			$this->SetTextColor(0,0,0);
			$this->SetX(0);
			$this->ln(3);
			$this->Cell(0,0,'SARL au capital de 7622.45€  RCS TOULON B392485 892  SIRET 392 485 892  APE 723 Z',0,0,'C');
		}
	}
	
	/*header('Content-type: application/pdf');
	$facture_pdf=new ld_facture_pdf();
	echo $facture_pdf->creer('AAAAAAAAAA','S');*/
?>