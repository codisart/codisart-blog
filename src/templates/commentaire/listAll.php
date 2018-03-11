<h2 id="nombreCommentaires" >
    <?= $comments->count(); ?> commentaires postés. <a href="#formCommentaire">Laisser un commentaire</a>
</h2>

<?php foreach ($comments as $comment): ?>
    <?= $this->insert('commentaire/row', ['comment' => $comment]) ?>
<?php endforeach; ?>

<hr/>
