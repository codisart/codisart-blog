<?php
	if (!isset($_SESSION)){session_start();}
	if (!isset($_SESSION['login'])){require 'connexion.php';exit();}
?>

<!DOCTYPE html>
<html lang="fr" >

<head>
	<meta charset="utf-8" />
	<title>CodisArt - Back Office - Commentaires</title>

	<link rel="stylesheet" href="css/admin.css" />
	<link rel="shortcut icon" type="image/x-icon" href="images/admin_favicon.ico" />
</head>

<body>

	<div id="global">

		<header class="header">
			<h1>Bienvenue sur le back-office du blog !</h1>
		</header>

		<nav class="nav">
			<ul>
				<li class="tab bg-light-blue"><a class="option" href="index.php">Articles</a></li></li>
				<li class="tab actif"><a class="option" href="index.php">Commentaires</a></li></li>
				<li class="tab bg-light-blue"><a class="option" href="suggestions.php">Suggestions</a></li>
				<li class="tab bg-light-blue"><a class="option" href="divers.php">Divers</a></li>
				<li class="tab bg-light-blue"><a class="option" href="deconnexion.php">Se déconnecter</a></li>
			</ul>
		</nav>

		<div class="contenu grand">
			<table class="workspace">
				<tr>
				   <th class="pseudo">Pseudo</th>
				   <th class="date">date</th>
				   <th class="commentaires">Message</th>
				   <th class="operations">operations</th>
			   </tr>

				<?php
					while(empty($directories)){chdir('..'); $directories = glob('nexus');}
					require_once(getcwd().'/nexus/main.php');

					$controller = Controller::getInstance();
					$controller->recoverGET('id_article');

					$article = new Article($id_article);

					$comments = $article->getAllCommentaires();

					foreach ($comments as $comment):
				?>
				<tr class="commentaire" id="commentaire<?php echo $comment->id; ?>">
					<td class="pseudo"><?php echo $comment->pseudo; ?></td>
					<td class="date"><?php echo $comment->getDateOn2Rows(); ?></td>
					<td class="content"><?php echo $comment->contenu; ?></td>
					<td class="operations">
						<img class="delete_comment" src="images/delete.png" title="Supprimer" alt="delete" width="20" data-comment="<?php echo $comment->id; ?>"/>
					</td>
				</tr>
				<?php
					endforeach;
				?>

			</table>
		</div>
	</div>

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="//cdn.ckeditor.com/4.4.5/full/ckeditor.js"></script>
	<script type="text/javascript" src="//punkka.alwaysdata.net/blog/js/jquery.lightbox.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>

	<script>
		$(document).ready( function() {

			$('.delete_comment').on('click',function(){
				formulaire('commentaire.php', 'supprimer', $(this).data("comment"));
			})
			.on('mouseover',function(){
				this.src='images/delete_hover.png';
			})
			.on('mouseout',function(){
				this.src='images/delete.png';
			});

		});
	</script>
</body>
</html>
