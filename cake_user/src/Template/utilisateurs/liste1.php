<h3>Liste des utilisateurs avec (id > 1)</h3>

<table>
    <tr>
        <th>Id</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Ville</th>
    </tr>

<!-- C'est ici que nous itérons à travers notre objet query $articles, -->
<!-- en affichant les informations de l'article -->

    <?php foreach ($utilisateurs as $utilisateur): ?>
    <tr>
        <td><?= $utilisateur->id ?></td>
        
        <td>
            <?= $utilisateur->nom ?>
        </td>
        <td>
            <?= $utilisateur->prenom ?>
        </td>
        <td>
            <?= $utilisateur->ville ?>
        </td>
        
    </tr>
    
    <?php endforeach; ?>

</table>




