<?php $this->layout('layouts/front', ['title' => $article->titre]) ?>

<a id="retourArticle" href="index.php">Retour à la liste des articles</a>

<?php if (!$article): ?>
    <h5 class="error">Il n'y a pas d'articles enregistrés pour cette période donnée.</h5>
<?php else: ?>
    <br/>
    <?= $this->insert('article/details', ['article' => $article]) ?>
    <hr/>
    <?= $this->insert('commentaire/listAll', ['comments' => $article->getAllCommentaires()]) ?>
    <hr/>
    <?= $this->insert('commentaire/form', ['articleId' => $article->id]) ?>
<?php endif ?>
