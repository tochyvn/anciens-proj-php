<?php
        
        if(!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT']==''){
            $_SERVER['DOCUMENT_ROOT']='/var/www/vhost/aicom/pige.aicom.fr';
        }
	echo "statut de la pige : " .exec('ps x | grep \''.$_SERVER['DOCUMENT_ROOT'].'\'', $output, $result);
        echo '<br/><br/>';
        foreach($output as $detail){
            echo $detail."<br/>";
        }
?>


