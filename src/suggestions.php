<?php

require_once('nexus/main.php');

use Blog\Blog;
use Blog\Suggestion;
use Codisart\Collection;
use Codisart\Controller;

class SuggestionController
{
    private $controller;
    private $blog;
    private $templatesEngine;

    public function __construct(
        Controller $controller,
        Blog $blog,
        $templatesEngine
    ) {
        $this->controller = $controller;
        $this->blog = $blog;
        $this->templatesEngine = $templatesEngine;
    }

    public function indexAction() : string
    {
        if ($this->formIsValid()) {
            $this->createSuggestion();
        }

        try {
            $suggestions = $this->blog->getAllSuggestions();
        } catch (\Exception $e) {
            return '<!-- LOG : '.$e->getMessage().'-->' . "\n";
        }

        return $this->renderPage($suggestions);
    }

    private function formIsValid()
    {
        $this->controller->recoverPOST('asali');

        global $asali;
        if ($asali) {
            return false;
        }

        $this->controller
            ->recoverPOST('suggestion')
            ->recoverPOST('email')
            ->recoverPOST('pseudo');

        global $suggestion, $email, $pseudo;
        return $this->controller->isPlainText($suggestion)
            && $this->controller->isEmailAddress($email)
            && $this->controller->isString($pseudo);
    }

    private function createSuggestion()
    {
        try {
            global $suggestion, $email, $pseudo;
            Suggestion::ajouter($pseudo, $email, $suggestion);
        }
        catch (\Exception $e) {
            echo '<!-- LOG : '.$e->getMessage().'-->' . "\n";
        }
        unset($pseudo, $email, $suggestion);
    }

    private function renderPage($suggestions) {
        return $this->templatesEngine->render('pages/suggestions', [
            'suggestions' => $suggestions,
            'title' => 'Suggestions',
        ]);
    }
}

$suggestionController = new \SuggestionController(
    Controller::getInstance(),
    new Blog(),
    $templates
);

echo $suggestionController->indexAction();
