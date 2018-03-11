<form id="formCommentaire" action="article.php?idArticle=<?= $articleId; ?>" method="POST">
    <h2>Laisser un commentaire :</h2>

    <input type="hidden" name="idArticle" value="<?= $articleId; ?>">
    <input type="hidden" name="action" value="ajouter">

    <p>
        <input id="pseudo" name="pseudo" type="text" required="required" value="" >
        <label for="pseudo" >
            Pseudo <em>(obligatoire)</em>
        </label>
    </p>

    <p>
        <input id="mail" name="mail" type="text" required="required" value="" >
        <label for="mail" >
            Email <em>(obligatoire)</em> <strong>*ne sera pas publié</strong>
        </label>
    </p>

    <p>
        <textarea id="comment" name="comment" cols="50" rows="9" required="required"></textarea>
    </p>

    <p>
        <input type="text" name="asali" id="asali" value="" />
        <input id="submit" name="submit" value="Valider" type="submit" class="button">
    </p>
</form>
