<?php if (!count($articles)): ?>
    <p>Il n'y a aucun article à afficher.</p>
<?php else: ?>
    <?php foreach ($articles as $article): ?>
    <br/>

    <div class="article">
    	<?= $this->insert('article/row', ['article' => $article]) ?>
    </div>

    <hr/>
    <?php endforeach ?>
<?php endif ?>
