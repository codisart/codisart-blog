
<div class="encart">
	<h3 class="siderTitre">Who am I ?</h3>

	<p class="profil">
		<img src="img/profil.jpg" alt="profil"/>

		Bienvenue sur mon blog.<br/><br/>Passionné de<br/> programmation,<br/> je développe des sites<br/> et des applications<br/> internet depuis 4 ans.
		<br/>Je travaille dans une SS2I.<!--Bienvenue sur mon blog.<br/>  Je m'appelle <em>LoudVoice</em>.<br/>
		Je suis un passionné de médias en tout genre avec une grosse préférence pour la littérature, le cinéma et les jeux vidéos.<br/>
		J'ai aussi un très grand intéret pour la sociologie, les mathématiques et l'histoire.
		Par passion et hobby, je développe des sites et des applications internet depuis trois ans.<br/>
		onfocus="inputRecherche(this);" onblur="inputRecherche(this)" type="text" value="Rechercher"
		-->
	</p>
</div>

<div class="encart">
	<h3 class="siderTitre">Recherche</h3>

	<form id="form_recherche" action="recherche.php" class="recherche">
		<p>
			<input id="champ_recherche" class="saisie" name="expression" placeholder="rechercher" type="text"/>
			<input class="bouton" type="submit" value="OK" />
		</p>
	</form>
</div>

<?php
	try {
		$archives = Blog\Blog::getArchives(); // On récupère une collection.
	}
	catch (Exception $e) {
		echo '<!-- LOG : '.$e->getMessage().'-->';
		$archives = null;
	}

	if (!empty($archives)) {
?>
	<div class="encart">
		<h3 class="siderTitre">Archives</h3>

		<ul class="archives">
		<?php
            foreach ($archives as $mois => $lien):
        ?>
			<li><a href="<?php echo $lien; ?>"><?php echo $mois; ?></a></li>
		<?php
            endforeach;
        ?>
		</ul>
	</div>
<?php
    }
?>

<div class="encart">
	<h3 class="siderTitre" title="Article aléatoire">
		<a href="article.php?idArticle=<?= Blog\Blog::getRandomArticle()->id; ?>">
			Random
		</a>
	</h3>
</div>
