<!-- File: src/Template/Articles/index.ctp -->

<h1>Tous les articles du Blog</h1>

<?= $this->Html->link('Ajouter un article', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Created</th>
        <th>Suppression</th>
        <th>Modification</th>
    </tr>

    <!-- Ici se trouve l'itération sur l'objet query de nos $articles, l'affichage des infos des articles -->

    <?php foreach ($articles as $article): ?>
    <tr>
        <td><?= $article->id ?></td>
        <td>
            <?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?>
        </td>
        <td>
            <?= $article->created->format(DATE_RFC850) ?>
        </td>
        <td>
            <?= $this->Html->link($article->Supprimer, ['action' => 'delete', $article->id]) ?>
        </td>
        <td>
            <?= $this->Html->link($article->Modifier, ['action' => 'edit', $article->id]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
