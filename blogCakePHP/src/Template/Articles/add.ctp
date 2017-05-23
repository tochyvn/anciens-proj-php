<!-- File: src/Template/Articles/add.ctp -->

<h1>Ajouter un article</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->input('title');
    echo $this->Form->input('body', ['rows' => '3']);
    echo $this->Form->input('email',['type'=>'email']);
    echo $this->Form->input('birth_dt', ['type'=>'datetime',
        'label' => 'Date de naissance',
        'minYear' => date('Y') - 70,
        'maxYear' => date('Y') - 18,
    ]);
    echo $this->Form->button(__("Sauvegarder l'article"));
    echo $this->Form->end();

