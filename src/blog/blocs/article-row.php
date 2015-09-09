
<div class="entete bleu"></div>

<h3><a href="article.php?idArticle=<?php echo $article->id; ?>"><?php echo $article->titre; ?></a></h3>

<h6>par <span>punkka</span>, posté le <?php echo $article->getDate('fr'); ?></h6>

<p>
<?php echo nl2br($article->getContenu()); ?>
</p>

<em>
	<a style="float:left;" href="article.php?idArticle=<?php echo $article->id; ?>#nombreCommentaires">
		Commentaires(<?php echo $article->getAllCommentaires()->count(); ?>)
	</a>

	<a style="float:right;" href="">
		Catégorie
	</a>
</em>
