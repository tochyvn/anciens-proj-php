<h3>Formulaire d'ajout d'un utilisateur</h3>

<?= $this->Form->create($utilisateur) ?>

<?= $this->Form->input('nom', ['type'=>'text', 'label'=>'Entrer votre nom']); ?>
<?= $this->Form->input('prenom', ['type'=>'text', 'label'=>'Entrer votre prenom']); ?>
<?= $this->Form->input('ville', ['type'=>'text', 'label'=>'Entrer votre ville']); ?>
<?= $this->Form->button('<em>Ajouter utilisateur</em>', ['type'=>'submit', 'escape'=>FALSE]); ?>

<?= $this->Form->end(); ?>

