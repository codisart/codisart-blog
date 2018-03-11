<div class="article">
    <div class="entete bleu"></div>

    <h3><?= $article->titre; ?></h3>
    <h6>by <span>punkka</span>, posté le <?= $article->date; ?></h6>

    <p><?= nl2br($article->getContenu()); ?></p>

    <em>
        <a style="float:right;" href="">
            Catégorie
        </a>
    </em>
</div>
