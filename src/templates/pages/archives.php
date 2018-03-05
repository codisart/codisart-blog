<?php $this->layout('layouts/front', ['title' => $title]) ?>

<?= $this->insert('subtitle', ['subtitle' => \Codisart\DateTime::MOIS[$mois]." ".$annee]) ?>

<?php if (!count($articles)): ?>
    <h5 class="error">Il n'y a pas d'articles enregistrés pour cette période donnée.</h5>
    <div>
        <a id="retourArticle" href="index.php">Retour à la liste des articles</a>
    </div>
<?php else: ?>
    <?= $this->insert('article/listAll', ['articles' => $articles]) ?>
<?php endif ?>
