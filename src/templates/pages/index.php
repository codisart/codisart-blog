<?php $this->layout('layouts/front', ['title' => $title]) ?>

<?php if ($page === 1): ?>
    <?= $this->insert('subtitle', ['subtitle' => 'Derniers articles']) ?>    
<?php endif; ?>

<?= $this->insert('article/listAll', ['articles' => $articles]) ?>

<?=  $this->insert('navigation', [
    'url' => 'index.php?',
    'page' => $page,
    'maxPages' => $maxPages,
    'nombreArticles' => $nombreArticles,
]) ?>
