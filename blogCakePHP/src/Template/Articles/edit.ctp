<!-- File: src/Template/Articles/edit.ctp -->

<h1>Modifier un article</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->input('title');
    echo $this->Form->input('body', ['rows' => '3']);
    echo $this->Form->button(__('Sauvegarder l\'article'));
    echo $this->Form->end();


