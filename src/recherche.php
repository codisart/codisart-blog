<?php

require_once('nexus/main.php');

$controller = \Codisart\Controller::getInstance();
$controller ->recoverGET('expression')
            ->recoverGET('page');

if (!$controller->isString($expression)) {
    header('Location: ./index.php');
    exit;
}

if (!$controller->isNumber($page)) {
    $page = 1;
}
$nombreArticles = 10;

$thisBlog = new \Blog\Blog();
try {
    $articles = $thisBlog->filtreRecherche($expression)->getArticles($page, $nombreArticles);
    $maxPages = ceil($thisBlog->getNombreAllArticles()/$nombreArticles);
}
catch (Exception $e) {
    echo '<!-- LOG : '.$e->getMessage().'-->';
    $articles = new \Codisart\Collection;
    $maxPages = 0;
}

echo $templates->render('pages/recherche', [
    'articles' => $articles,
    'page' => $page,
    'maxPages' => $maxPages,
    'nombreArticles' => $nombreArticles,
    'expression' => $expression
]);
