<?php
	if ($nombreArticles != 0) {
		//@TODO l'url est fausse pour les archives et la recherche 
		if ($page > 1 && $page < $maxPages) { ?>
            <div  style="float:left">
                <a href="index.php?page=<?php echo $page-1; echo $nombreArticles === 10 ? '': '&n='.$nombreArticles; ?>">Recents articles</a>
            </div>
        <?php }

		if ($page == $maxPages) { ?>
            <div  style="float:left">
                <a href="index.php?page=1">Retour à la première page</a>
            </div>
        <?php }

		if ($page < $maxPages) { ?>
            <div  style="float:right">
                <a href="index.php?page=<?php echo $page+1; echo $nombreArticles === 10 ? '': '&n='.$nombreArticles; ?>">Anciens articles</a>
            </div>
        <?php }


	}
?>
