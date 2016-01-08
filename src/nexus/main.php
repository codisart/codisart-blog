<?php

	define('NEXUSDIR', __DIR__.'/');

	if (is_file(NEXUSDIR.'config.php')) {
		include(NEXUSDIR.'config.php');
	}
	require(NEXUSDIR.'default.config.php');


	function connexionBDD() {
		try {
			$connexionBDD = new \PDO(SERVER, USER, PASS);
			$connexionBDD->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$connexionBDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

	define("VENDOR", __DIR__."/../vendor");

	function loadVendorFile($class) {
		$parts = explode('\\', $class);
		array_shift($parts);
		array_splice($parts, 1, 0, "src");
		$path = implode('/', $parts);

		if (is_file(VENDOR."/$path.php")) {
			require VENDOR."/$path.php";
		}
	}

	spl_autoload_register("loadVendorFile");
	
	$templates = new League\Plates\Engine('./blocs');
