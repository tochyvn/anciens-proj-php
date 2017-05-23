<h3>Liste des utilisateurs</h3>
<?= $this->Html->link('Ajouter un utilisateur', ['controller'=>'utilisateurs', 'action'=>'add']); ?>
<table>
    <tr>
        <th>Id</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Ville</th>
    </tr>

<!-- C'est ici que nous itérons à travers notre objet query $utilisateurs, -->
<!-- en affichant les informations de l'utilisateur -->

    <?php foreach ($utilisateurs as $utilisateur): ?>
    <tr>
        <td><?= $utilisateur->id; ?></td>
        
        <td>
            <?= $utilisateur->nom; ?>
        </td>
        <td>
            <?= $utilisateur->prenom; ?>
        </td>
        <td>
            <?= $utilisateur->ville; ?>
        </td>
        
    </tr>
    
    <?php endforeach; ?>

</table>



