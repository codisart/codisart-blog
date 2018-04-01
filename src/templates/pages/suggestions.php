<?php $this->layout('layouts/front', ['title' => $title]) ?>

<h1 id="messageAccueil">
    Je suis à la recherche d'idées d'applications web innovantes à réaliser.<br/>
    Si vous avez des suggestions, n'hésitez pas à m'en faire part :<br/>
</h1>

<?= $this->insert('suggestion/form') ?>

<?= $this->insert('suggestion/listAll', ['suggestions' => $suggestions]) ?>
