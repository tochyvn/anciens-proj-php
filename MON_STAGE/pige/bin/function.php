<?php
	function ldlc_base16_decode($chaine)
	{
            $base16=array('0','A','1','2','B','3','4','C','5','6','D','7','8','E','9','F');
            $retour='';
            for($i=0;$i<strlen($chaine);$i+=2)
            {
                    $ch=array_search(substr($chaine,$i,1),$base16);
                    $cl=array_search(substr($chaine,$i+1,1),$base16);
                    $retour.=chr($ch*16+$cl);
            }
            return $retour;
	}
        
        function log_ftp_error_login($ftp){
            $mail_1 = "guillaume.cozic@aicom.fr";
            $mail_2 = "laurent.salvo@aicom.fr";
            $message = 'Erreur de login sur le ftp : '.$ftp;
            mail($mail_1, 'Arret.php a ete appele', $message );
            mail($mail_2, 'Arret.php a ete appele', $message );
        }
        
        function log_ftp_error_put($destination, $source, $ftp){
            $mail_1 = "guillaume.cozic@aicom.fr";
            $mail_2 = "laurent.salvo@aicom.fr";
            $message = 'Erreur d\'upload sur le ftp : '.$ftp.' fichier : '.$source.', destination : '.$destination.'' ;
            mail($mail_1, 'Arret.php a ete appele', $message );
            mail($mail_2, 'Arret.php a ete appele', $message );
        }
?>