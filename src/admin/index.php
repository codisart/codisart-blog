 <?php
    if (!isset($_SESSION)) {session_start(); }
    if (!isset($_SESSION['login'])) {require 'connexion.php'; exit(); }
?>

<!DOCTYPE html>
<html lang="fr" >

<head>
	<meta charset="utf-8" />
	<title>CodisArt - Back Office - Accueil</title>

	<link rel="stylesheet" href="css/admin.css" />
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
</head>


<body>

	<div class="global">

		<header class="header">
			<h1>Bienvenue sur le back-office du blog !</h1>
		</header>

		<nav class="nav">
			<ul>
				<li class="tab actif"><a class="option" href="index.php">Articles</a></li></li>
				<li class="tab bg-light-blue"><a class="option" href="suggestions.php">Suggestions</a></li>
				<li class="tab bg-light-blue"><a class="option" href="divers.php">Divers</a></li>
				<li class="tab bg-light-blue"><a class="option" href="deconnexion.php">Se déconnecter</a></li>
			</ul>
		</nav>

		<div class="contenu grand">

			<button id="create_new_article" class="button ajouter bd-grey" >Ecrire un nouvel article</button>

			<table class="workspace">

				<thead>
					<tr>
						<th class="titre">titre</th>
						<th class="date">date</th>
						<th class="commentaires">commentaires</th>
						<th class="operations">operations</th>
					</tr>
				</thead>

				<tbody id="list_articles"><?php
                        do {$directories = glob('nexus'); } while (empty($directories) && chdir('..'));
                        require_once(getcwd().'/nexus/main.php');

                        defined('REPARTITION') || define('REPARTITION', 10);

                        $thisBlog = new Blog\Blog();
                        try {
                            $articles = $thisBlog->getArticles(1, REPARTITION);
                            $totalArticles = $thisBlog->getNombreAllArticles();
                        }
                        catch (Exception $e) {
                            echo '<!-- LOG : '.$e->getMessage().'-->';
                            $articles = null;
                            $totalArticles = 0;
                        }

                        if(empty($articles)) {
                    ?>
						<tr>
							<td colspan="4">Il n'y a aucun article à afficher </td>
						</tr>
					</tbody>
					<?php
                        }
                        else {
                            foreach ($articles as $article) {
                    ?>
					<tr class="article" id="article<?php echo $article->id; ?>">
						<td class="titre"><?php echo $article->titre; ?></td>

						<td class="date"><?php echo $article->getDate('fr'); ?></td>

						<td class="commentaires">
							<a
                href="commentaires.php?id_article=<?= $article->id; ?>"
                title="Voir les commentaires de cet article"
              >
								<?php echo $article->getAllCommentaires()->count(); ?>
							</a>
						</td>

						<td class="operations">
							<img class="edit_article" src="img/edit.png" title="Modifier" alt="edit" width="20" data-article="<?= $article->id; ?>" />
							<img class="delete_article" src="img/delete.png" title="Supprimer" alt="delete" width="20" data-article="<?= $article->id; ?>"/>
						</td>
					</tr>
					<?php
                            }
                    ?>
				</tbody>

				<tbody>
					<tr>
						<td class="load-articles" colspan="4" >
							<a href="" onclick="loadArticles(this);return false;" data-total="<?php echo $totalArticles; ?>"data-count="<?php echo $articles->count(); ?>" data-periode="<?php echo REPARTITION; ?>">Charger plus d'articles</a>
						</td>
					</tr>
				</tbody>
				<?php
                        }
                ?>

			</table>
		</div>

		<footer class="footer">
			<h3>© punkka</h3>
			<h4>Since 2010</h4>
		</footer>

	</div>

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="//cdn.ckeditor.com/4.4.5/full/ckeditor.js"></script>
	<script type="text/javascript" src="//punkka.alwaysdata.net/blog/js/jquery.lightbox.min.js"></script>
	<script type="text/javascript" src="../js/script.js"></script>

	<script>
		$(document).ready( function() {

			$('#create_new_article').on('click',function(){
				formulaire('article.php', 'ajouter');
			});


			$('.edit_article').on('click',function(){
				formulaire('article.php', 'modifier', $(this).data("article"));
			})
			.on('mouseover',function(){
				this.src='img/edit_hover.png';
			})
			.on('mouseout',function(){
				this.src='img/edit.png';
			});


			$('.delete_article').on('click',function(){
				formulaire('article.php', 'supprimer', $(this).data("article"));
			})
			.on('mouseover',function(){
				this.src='img/delete_hover.png';
			})
			.on('mouseout',function(){
				this.src='img/delete.png';
			});


			$('#load_more_articles').on('click', function (){
				// var articles = {};

				// articles = loadMoreArticles($(this).data('count'), $(this).data('periode'));

				// for (article in articles) {

				// }

				// $('tbody#list_articles') =
			})
		});
	</script>

</body>

</html>
