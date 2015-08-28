<?php
	if (!isset($_SESSION)){session_start();}
	if (!isset($_SESSION['login'])){require 'connexion.php';exit();}
?>

<!DOCTYPE html>
<html lang="fr" >

<head>
	<meta charset="utf-8" />
	<title>CodisArt - Back Office</title>

	<link rel="stylesheet" href="css/admin.css" />
	<link rel="shortcut icon" type="image/x-icon" href="images/admin_favicon.ico" />
</head>


<body>

	<div class="global">

		<header>
			<h1>Back-end : Codisart</h1>
		</header>

		<nav class="nav">
			<ul>
				<li class="tab bg-light-blue"><a class="option" href="index.php">Articles</a></li>
				<li class="tab actif"><a class="option">Suggestions</a></li>
				<li class="tab bg-light-blue"><a class="option" href="divers.php">Divers</a></li>
				<li class="tab bg-light-blue"><a class="option" href="deconnexion.php">Se déconnecter</a></li>
			</ul>
		</nav>

		<div class="contenu grand">

			<table  class="workspace suggestions" style='-moz-user-select: none;-webkit-user-select: none;' onselectstart='return false;'>

				<thead>
					<tr>
						<th class="checkbox">
							<input id="select_all_suggestions" type="checkbox" value="select all" />
							<img id="delete_all_suggestions" src="images/delete.png" title="Supprimer" alt="Supprimer" />
						</th>
						<th class="pseudo">pseudo</th>
						<th class="date">date</th>
						<th class="suggestion">suggestion</th>
						<th class="operations">operations</th>
					</tr>
				</thead>

			   <tbody>

			   	<?php
					while (empty($directories)){chdir('..'); $directories = glob('nexus');}
					require_once(getcwd().'/nexus/main.php');

					$suggestions = Blog::getAllSuggestions();

					foreach ($suggestions as $suggestion) :
				?>
					<tr class="message" id="message<?php echo $suggestion->id; ?>">
						<td class="checkbox"><input type="checkbox" /></td>
						<td class="pseudo"><?php echo $suggestion->pseudo; ?></td>
						<td class="date"><?php echo $suggestion->getDateOn2Rows(); ?></td>
						<td class="suggestion" ><?php echo $suggestion->contenu; ?></td>
						<td class="operations">
							<img class="supprimer_suggestion"src="images/delete.png" title="Supprimer" alt="Supprimer" data-suggestion="<?php echo $suggestion->id; ?>" />
						</td>
					</tr>
				<?php
					endforeach;
				?>
					<tr>
						<td class="load_more" colspan="5">Charger plus de suggestions</td>
					</tr>

				</tbody>

			</table>

		</div>

		<footer>
			<h3>© punkka</h3>
			<h4>Since 2010</h4>
		</footer>

	</div>


	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="//cdn.ckeditor.com/4.4.5/full/ckeditor.js"></script>
	<script type="text/javascript" src="//punkka.alwaysdata.net/blog/js/jquery.lightbox.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>

	<script>
		$(document).ready( function() {
			$('.supprimer_suggestion').on('click', function() {
				formulaire('suggestion.php', 'supprimer', $(this).data("suggestion") );
			})
			.on('mouseover', function() {
				this.src='images/delete_hover.png';
			})
			.on('mouseout', function() {
				this.src='images/delete.png';
			});


			$('#delete_all_suggestions').on('click', function() {
				supprimerAllArticles();
			})
			.on('mouseover', function() {
				this.src='images/delete_hover.png';
			})
			.on('mouseout', function() {
				this.src='images/delete.png';
			});


			// Interface de selection des différents messages
			$('#select_all_suggestions').on('change',function(){
				$('.workspace tbody input[type=checkbox]').prop('checked', $(this).is(':checked'));
				toggleBoutonSupprimerToutesSuggestions();
			});

			$('.message').children().not('.checkbox, .operations').on('click', function() {
				var input = $(this).parent().find('input[type=checkbox]');
				input.prop('checked', !input.prop('checked'));
				hideCheckBoxSelectAll
				toggleBoutonSupprimerToutesSuggestions();
			});

			$('.workspace tbody input[type=checkbox]').on('change', function() {
				hideCheckBoxSelectAll();
				toggleBoutonSupprimerToutesSuggestions();
			})
		});
	</script>

	</body>
</html>
