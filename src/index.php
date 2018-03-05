<?php

require_once('nexus/main.php');

use Blog\Blog;
use Codisart\Collection;
use Codisart\Controller;

$controller = Controller::getInstance()
    ->recoverGET('page')
    ->recoverGET('p', 'page')
    ->recoverGET('n', 'nombreArticles');

$page           = $controller->isNumber($page) ? (int) $page : 1;
$nombreArticles = $controller->isNumber($nombreArticles) ? $nombreArticles : 10;

$thisBlog = new Blog();
try {
    $articles = $thisBlog->getArticles($page, $nombreArticles);
    $maxPages = ceil($thisBlog->getNombreAllArticles()/$nombreArticles);
}
catch (Exception $e) {
    echo '<!-- LOG : '.$e->getMessage().'-->';
    $articles = new Collection;
    $maxPages = 0;
}

echo $templates->render('pages/index', [
    'articles' => $articles,
    'page' => $page,
    'maxPages' => $maxPages,
    'nombreArticles' => $nombreArticles,
    'title' => 'Accueil'
]);
