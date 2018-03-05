<?php

require '../vendor/autoload.php';

define('NEXUSDIR', __DIR__.'/');

if (is_file(NEXUSDIR.'config.php')) {
    include(NEXUSDIR.'config.php');
}
require(NEXUSDIR.'default.config.php');

function connexionBDD() {
    try {
        $connexionBDD = new \PDO(SERVER, USER, PASS);
        $connexionBDD->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        $connexionBDD->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e) {
        echo 'Connexion échouée : '.$e->getMessage();
        return null;
    }
    return $connexionBDD;
}

$templates = new League\Plates\Engine('./templates');
