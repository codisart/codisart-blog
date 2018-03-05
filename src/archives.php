<?php

require_once('nexus/main.php');

use Blog\Blog;
use Codisart\Collection;
use Codisart\Controller;

$controller = Controller::getInstance()
    ->recoverGET('a', 'annee')
    ->recoverGET('m', 'mois');

if (
    !$controller->isNumber($mois)
    || !$controller->isNumber($annee)
    || ($mois > 12 && $mois < 1)
    || $annee < 2010
) {
    header('Location: ./');
    exit;
}

$thisBlog = new Blog();
try {
    $articles = $thisBlog->getArticlesByMonth($annee, $mois);
}
catch (Exception $e) {
    echo '<!-- LOG : '.$e->getMessage().'-->';
    $articles = new Collection;
}

echo $templates->render('pages/archives', [
    'articles' => $articles,
    'mois' => $mois,
    'annee' => $annee,
    'title' => 'Archives de ' . \Codisart\DateTime::MOIS[$mois] . ' ' . $annee,
]);
