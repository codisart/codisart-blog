<?php
	if ($nombreArticles != 0) {
		$url = isset($url) ? $url : 'index.php';
		if ($page > 1 && $page < $maxPages) {
			echo '
				<div  style="float:left">
					<a href="'.$url.'?&page='.($page - 1).($nombreArticles === 10 ? '' : '&n='.$nombreArticles).'">Recents articles</a>
				</div>';
		}

		if ($maxPages > 1 && $page == $maxPages) {
			echo '
				<div  style="float:left">
					<a href="'.$url.'?page=1">Retour à la première page</a>
				</div>';
		}

		if ($page < $maxPages) {
			echo '
				<div  style="float:right">
					<a href="'.$url.'?page='.($page + 1).($nombreArticles === 10 ? '' : '&n='.$nombreArticles).'">Anciens articles</a>
				</div>';
		}
	}
