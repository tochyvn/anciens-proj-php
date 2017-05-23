<!-- File: src/Template/Articles/add.ctp -->
<div class="users form">
<h1>Proposer ou demander un trajet</h1>
<?php
    echo $this->Form->create($trajet);
    
    echo $this->Form->input('depart', ['label'=>'Point de depart']);
    echo $this->Form->input('destination', ['label'=>'Point de destination']);
    echo $this->Form->input('date_depart',['type'=>'date']);
    echo $this->Form->input('choix', ['label'=>'Demande ou proposition', 'options' => ['D' => 'demande', 'P' => 'proposition']]);
    
    echo $this->Form->button(__("Sauvegarder le trajet"));
    echo $this->Form->end();
    
?>

</div>