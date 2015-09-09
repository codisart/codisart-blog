<?php

	include('config.php');
	require('default.config.php');


	function connexionBDD() {

		try {
			$connexionBDD = new \PDO(SERVER, USER, PASS);
			$connexionBDD->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$connexionBDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		}
		catch (Exception $e) {
			echo 'Connexion échouée : '.$e->getMessage();
			return null;
		}

		return $connexionBDD;
	}


	/***** Classes & Librairies*****/

	define("CLASSES", __DIR__."/classes");
	define("LIBS", __DIR__."/librairies");

	function loadFile($class) {
		$parts = explode('\\', $class);
		$file = end($parts);
		
		if (is_file(CLASSES."/$file.class.php")) {
			require CLASSES."/$file.class.php";
		}

		if (is_file(LIBS."/$file.lib.php")) {
			 require LIBS."/$file.lib.php";
		}
	}

	spl_autoload_register("loadFile");
