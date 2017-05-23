<?php
	function lalettredujour_email($genre,$email)
	{
		$theme=array();
		$theme[]='59812773';
		$theme[]='69131873';
		$theme[]='115740965';
		$theme[]='119388731';
		$theme[]='136650910';
		$theme[]='154438303';
		$theme[]='183163482';
		$theme[]='190751505';
		$theme[]='214830679';
		$theme[]='225434873';
		$theme[]='229314537';
		$theme[]='269473695';
		$theme[]='298715541';
		$theme[]='302034850';
		$theme[]='337792155';
		$theme[]='376353483';
		$theme[]='453404138';
		$theme[]='475544383';
		$theme[]='495009951';
		$theme[]='500443293';
		$theme[]='528608286';
		$theme[]='586972982';
		$theme[]='613816308';
		$theme[]='754542379';
		$theme[]='768201660';
		$theme[]='818091476';
		$theme[]='840241428';
		$theme[]='871378381';
		$theme[]='941011360';
		
		switch($genre)
		{
			case 'locataire':
				$theme[]='492465775';
				break;
			case 'proprietaire':
				$theme[]='107061072';
				break;
			case 'acquereur':
				$theme[]='297428603';
				break;
			case 'vendeur':
				$theme[]='455015722';
				break;
		}
		
		$socket=@fsockopen('lalettredujour.fr',80,$errno,$errstr,30);
		if(!$socket)
			print($errno.': '.$errstr);
		else
		{
			$fichier='--------aaaaaa------
Content-Disposition: form-data; name="fichier"; filename="fichier.xml"
Content-Type: text/xml

<?xml version="1.0"?>
<adherents>
<adherent submit="">
<email>'.ma_htmlentities($email).'</email>
<themes>
<theme>'.implode('</theme>'.CRLF.'<theme>',array_map('htmlentities',$theme)).'</theme>
</themes>
<provenances>
<provenance>407434646</provenance>
</provenances>
</adherent>
</adherents>
--------aaaaaa--------';
			$requete='POST /inclusion/adherent_distant.php?compression=AUCUN HTTP/1.1'."\r\n";
			$requete.='Host: lalettredujour.fr'."\r\n";
			$requete.='Connection: Close'."\r\n";
			$requete.='Authorization: Basic YWljb206cm90ZTE1Ly00'."\r\n";
			$requete.='Content-Type: multipart/form-data; boundary="------aaaaaa------"'."\r\n";
			$requete.='Content-Length: '.strlen($fichier)."\r\n";
			$requete.="\r\n";
			$requete.=$fichier;
			
			fwrite($socket,$requete);
			
			//while(!feof($socket))
			//	print(fgets($socket,128));
			
			fclose($socket);
		}
	}
?>