
<div class="entete bleu"></div>

<h3><a href="article.php?idArticle=<?= $article->id ?>"><?= $article->titre ?></a></h3>

<h6>par <span>punkka</span>, posté le <?= $article->getDate('fr') ?></h6>

<p>
    <?= nl2br($article->getContenu()) ?>
</p>

<em>
	<a style="float:left;" href="article.php?idArticle=<?= $article->id ?>#nombreCommentaires">
		Commentaires(<?= $article->getAllCommentaires()->count() ?>)
	</a>

	<a style="float:right;" href="">
		Catégorie
	</a>
</em>
