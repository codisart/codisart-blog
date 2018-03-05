<!DOCTYPE html>
<html lang="fr">

<head>
    <title><?= $title ?></title>

    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/general.css" />
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
</head>

<body>
    <div id="global">
        <?= $this->insert('header') ?>

        <div id="contenu">
            <div id="principal">
                <?= $this->section('content') ?>
            </div>

            <div id="secondaire">
                <?= $this->insert('sidebar') ?>
            </div>
        </div>

        <?= $this->insert('footer') ?>
    </div>
</body>
</html>
