<?php 

	/***** Base de données *****/
	
	define("SERVER","mysql:host=mysql.alwaysdata.com;dbname=punkka_blog");
	define("USER", "punkka_blog");
	define("PASS", "wcGRJZ9LHQpnbXK8");
	
	function connexionBDD() {

		try {
			$connexionBDD = new \PDO(SERVER, USER, PASS);
			$connexionBDD->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$connexionBDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);			
		} catch (Exception $e) {
    		echo 'Connexion échouée : ' . $e->getMessage();
    		return null;
		}
			
		return $connexionBDD;
	}
	

	/***** Classes & Librairies*****/
	
	define("CLASSES",__DIR__."/classes");
	define("LIBS",__DIR__."/librairies");	

    function loadFile($file) {

		if (is_file(CLASSES."/$file.class.php")) {
			require CLASSES."/$file.class.php";
		}
		
		if (is_file(LIBS."/$file.lib.php")) {
			 require LIBS."/$file.lib.php";
		}
    }
    
    spl_autoload_register("loadFile");