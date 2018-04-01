<?php $this->layout('layouts/front', ['title' => 'Recherche : ' . $expression]) ?>

<?= $this->insert('subtitle', ['subtitle' => 'Recherche de l\'expression : '.$expression]) ?>

<?= $this->insert('article/listAll', ['articles' => $articles]) ?>

<?=  $this->insert('navigation', [
    'url' => 'index.php?',
    'page' => $page,
    'maxPages' => $maxPages,
    'nombreArticles' => $nombreArticles,
]) ?>
