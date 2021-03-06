<!DOCTYPE html>
<html lang="fr" >

<head>
	<title>Projets</title>

	<meta charset="utf-8" />

	<link href="css/general.css" rel="stylesheet" />

	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
</head>

<?php require_once('nexus/main.php'); ?>
<body>

	<div id="global">
		<?=$templates->render('header') ?>

		<div id="contenu" class="projets">
			<div>
				<a href="http://apymeal.alwaysdata.net/"><img src="img/APYMeal_screen.jpg" /></a>
				<h1>APYMeal</h1>

				<p>
					APYMeal est un projet créé pendant mes études, qui permet à un restaurant d'équiper ses tables d'écran tactiles surlesquels les clients peuvent passer leur commandes.
					L'application fournit un back office pour l'administrateur, mais aussi une interface pour la gestion des commandes en cuisine.
				</p>
			</div>

			<div>
				<a href="http://punkka.alwaysdata.net/projets/KiNaN/"><img src="img/KiNaN_screen.jpg" /></a>
				<h1>KiNaN</h1>

				<p>
					KiNaN est un projet personnel dans le but de pouvoir modifier des pages webs directement dans un navigateur internet.
					C'est pour l'instant un explorateur de fichiers et un éditeur de texte.
				</p>
			</div>

			<div>
				<a href="http://punkka.alwaysdata.net/projets/GiftReminder/"><img src="img/VisuelNonDisponible.jpg" /></a>
				<h1>Gift Reminder</h1>

				<p>
					Description à Venir !!
				</p>
			</div>
		</div>

	<?=$templates->render('footer') ?>
</body>
</html>
