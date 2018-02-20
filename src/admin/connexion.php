<?php

$directories = glob('nexus');
while (empty($directories)) {chdir('..'); $directories = glob('nexus'); }
require_once(getcwd().'/nexus/main.php');

$controller = Controller::getInstance();
$controller->recoverPOST('login')->recoverPOST('password');

if ($controller->isString($login) && $controller->isString($password)) {
    if (Blog\User::validLogin($login, $password)) {
        $_SESSION['login'] = $login;
        header("Location: ".basename($_SERVER['REQUEST_URI']));
        exit();
    }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

<head>
	<title>CodisArt</title>

	<meta charset="utf-8" />

	<link rel="stylesheet" href="css/admin.css" />
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
</head>


<body>

	<div id="global">

		<header>
			<h1>Back office</h1>
		</header>

		<div class="contenu connexion">
			<?php
                $nom_fichier = basename(__FILE__);
                $nom_page_appelee = str_replace('?'.$_SERVER['QUERY_STRING'], '', basename($_SERVER['REQUEST_URI']));
                $nom_redirection_apache = basename($_SERVER['PHP_SELF']);
                $url_variables = empty($_SERVER['QUERY_STRING']) ? "" : '?'.$_SERVER['QUERY_STRING'];
            ?>
			<form action="<?= ($nom_page_appelee != $nom_redirection_apache || $nom_fichier == $nom_page_appelee ? 'index.php' : $nom_redirection_apache).$url_variables; ?>" method="POST">
				<p>
					<input type="text" class="textbox" name="login" placeholder="Identifiant" value="<?= isset($login) ? $login : ''; ?>"/>
				</p>
				<p>
					<input type="password" class="textbox" name="password" placeholder="Mot de passe" />
				</p>
				<p>
					<input class="button" type="submit" value="Login" />
				</p>
			</form>

		</div>

		<footer>
			<h3>© punkka</h3>
			<h4>Since 2010</h4>
		</footer>
	</div>

</body>
</html>
