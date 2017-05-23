<?php
	

        function log_arret(){
            $date = date("d-m-Y H:i:s");
            $ip = $_SERVER['REMOTE_ADDR'];
            $mail_1 = "guillaume.cozic@aicom.fr";
            $mail_2 = "laurent.salvo@aicom.fr";
            $message = 'arret.php a ete appele le '.$date.' par '.$ip.'';
            $result = mail($mail_1, 'Arret.php a ete appele', $message );
	    var_dump($result);
            mail($mail_2, 'Arret.php a ete appele', $message );
        }
        log_arret();
        
        if(!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT']==''){
		$_SERVER['DOCUMENT_ROOT']='/var/www/vhost/aicom/pige.aicom.fr';
	}

	exec('ps x | grep \''.$_SERVER['DOCUMENT_ROOT'].'\' | egrep -o \'^ *[0-9]+ \' | egrep -o \'[0-9]+\' | xargs kill');
?>