﻿<div class="header">
	
	<div class="logo">
		<h1><a href="index.php">CodisArt</a></h1>
	</div>

	<?php //<div id="ad">Acheter ICI </div> ?>
	
	<?php
		$onglets = glob("*.php");
		
		foreach ($onglets as $onglet) {	
			$onglet = preg_replace("#.php$#", "", $onglet);
			${$onglet} = '';
		}
		
		if (!isset($onglet_actif)) {
			$chemin = $_SERVER['PHP_SELF'];
			$onglet_actif = preg_replace("#.php$#", "", basename($chemin));
		}
		
		${$onglet_actif} = " actif";
	?>	
	<div class="navigation">
	
		<a class="onglet<?php echo $index; ?>" href="index.php">Accueil</a>
		<a class="onglet<?php echo $projects; ?>" href="projects.php">Projets</a> 	
		<a class="onglet<?php echo $suggestions; ?>" href="suggestions.php">Suggestions</a> 
		<a class="onglet<?php echo $challenges; ?>" href="challenges.php">Challenges</a> 	
		<a class="onglet<?php echo $contact; ?>" href="contact.php">Contact</a>
		<?php /*
		<a class="onglet<?php //echo $galerie; ?>" href="galerie.php">Multimedia</a> 
		<a class="onglet<?php //echo $cv; ?>" href="curriculum.php">C.V.</a>
		*/ ?> 	
	</div>
		
</div>
	