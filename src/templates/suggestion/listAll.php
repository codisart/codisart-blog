<?php if (!count($suggestions)): ?>
    <p>Il n'y a aucune suggestion à afficher </p>
<?php else : ?>
    <?php foreach ($suggestions as $suggestion): ?>

    <div class="message">
    	<?= $this->insert('suggestion/row', ['suggestion' => $suggestion]) ?>
    </div>
    <?php endforeach ?>

    <div id="navigationSuggestions">
        <span>plus de suggestions</span>
    </div>
<?php endif ?>
