<!-- File: src/Template/Articles/index.ctp -->

<h3>Mes Trajets demandés</h3>
<p><?= $this->Html->link('Ajouter un Trajet', ['action' => 'add']) ?></p>
<table>
    <tr>
        <th>Id</th>
        <th>Depart</th>
        <th>Destination</th>
        <th>Date Depart</th>
        <th>Id de l'user</th>
        <th>Username</th>
        <th>Type</th>
    </tr>

<!-- C'est ici que nous itérons à travers notre objet query $articles, -->
<!-- en affichant les informations de l'article -->

    <?php foreach ($trajets as $trajet): ?>
    <tr>
        <td><?= $trajet->id ?></td>
        <td>
            <?= $this->Html->link($trajet->depart, ['action' => 'view', $trajet->id]) ?>
        </td>
        <td>
            <?= $trajet->destination ?>
        </td>
        <td>
            <?= $trajet->date_depart ?>
        </td>
        <td>
            <?= $trajet->user_id ?>
        </td>
        <td>
            <?= $trajet->user->username ?>
        </td>
        <td>
            <?= $trajet->choix ?>
        </td>
    </tr>
    
    <?php endforeach; ?>

</table>
