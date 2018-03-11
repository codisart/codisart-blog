<?php

require_once('nexus/main.php');

$controller = \Codisart\Controller::getInstance();
$controller
    ->recoverPOST('asali')
    ->recoverPOST('idArticle', 'id');

if (!$asali) {
    $controller
        ->recoverPOST('comment', 'comment')
        ->recoverPOST('mail', 'mail')
        ->recoverPOST('pseudo', 'pseudo')
        ->recoverPOST('action');

    if ('ajouter' === $action) {
        if (
            $controller->isString($comment)
            && $controller->isEmailAddress($mail)
            && $controller->isString($pseudo)
            && $controller->isNumber($id)
        ) {
            try {
                \Blog\Commentaire::ajouter($id, $pseudo, $mail, $comment);
            }
            catch (\Exception $e) {
                echo '<!-- LOG : '.$e->getMessage().'-->';
            }
        }
        else {
            echo '<h5 class="error">Votre mail n\'est pas valide !</h5>';
        }
    }
}

$controller->recoverGET('idArticle', 'id');
$article = new \Blog\Article($id);

echo $templates->render('pages/article', [
    'article' => $article
]);
