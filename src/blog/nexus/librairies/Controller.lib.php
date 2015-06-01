<?php

	class Controller 
	{
		static private $instance;

		public $variables = array();
		
		function __construct()
		{			
			
		}
		
		
		public function __toString() {
			$string = "<pre>\n Le controller existe et contient les valeurs suivantes: \n ";
			
			foreach($this->variables as $key => $variable ) {
				$string .= "\t $key est egale a $variable \n";
			}
			$string .= "</pre>";
			
			return $string;
		}
		
		
		static public  function getInstance() {
			 if(is_null(self::$instance)) {
			   self::$instance = new Controller();  
			 }
		 
			 return self::$instance;
		}
		
		
		
		public function recoverPOST($key, $newKey = false) {
			if(false === $newKey) {
				$newKey = $key;
			}
			
			global ${$newKey};

			if(array_key_exists($key, $_POST)) {
				${$newKey} = $_POST[$key];
				$this->variables[$newKey] = $_POST[$key];
				unset($_POST[$key]);
			}

			return $this;	
		}
		
		public function recoverGET($key, $newKey = false) {
			if(false === $newKey) {
				$newKey = $key;
			}
			
			global ${$newKey};
				
			if(array_key_exists($key, $_GET)) {
				${$newKey} = $_GET[$key];
				$this->variables[$newKey] = $_GET[$key];
				unset($_GET[$key]);
			}
			
			return $this;
		}
	

		/***** To string *****/

		function toString() {
			$text = "";			
			
			if(empty($this->variables)) {
				$text = "Il n'y pas de variable à contrôler";
			}
			else {
				foreach($this->variables as $key => $valeur) {
					$text .= "la variable $key est égale à $valeur\n";
				}
			}
			return $text;
		}
		
		
		
		/***** Controleur pour type d'input *****/

		function isNumber($variable, $MAX_LENGTH = false) {
			if(!is_numeric($variable)) {
				return false;
			}	

			if(false === $MAX_LENGTH) {
				return true;
			}
			else if(strlen($variable) === $MAX_LENGTH) {
				return true;
			}
			return false;			
		}
		
		
		function isString(&$chaine) {	
			if(!is_string($chaine) || "" === $chaine) {			
				return false;
			}	
			
			$chaine = htmlspecialchars($chaine,ENT_QUOTES);
			return true;		
		}
		
		
		function isArray(&$array, $methode) {
			if(empty($array)) {
				$array = array();
				return false;
			}
			
			foreach($array as $key => $value) {			
				if(false === $this->$methode($array[$key])) {
					return false;
				}
			}

			return true;
		}
		
		
		function isHTML(&$text) {
			if(!is_string($text) || $text == "") {			
				return false;
			}	
			
			$text = preg_replace('#<script.*>(.*)<\/script>#isU', "", $text);
			$text = preg_replace('# onclick="(.*)"#isU', "", $text);			
			return true;
		}
		
		
		function isPlainText(&$text) {
			if(!is_string($text) || $text == "") {			
				return false;
			}	
			
			$text = strip_tags($text);			
			return true;
		}
		
		
		/***** Special Inputs *****/
		
		function isEmailAdresse(&$adresse) {
			if (preg_match('#^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.((net)|(com)|(org)|(fr)|(uk))#',$adresse)) {							
				return true;
			}

			return false;		
		}	
		

		function isTelephoneNumber(&$nombre) {
			if (preg_match('#^0[1-8]([-. ]?[0-9]{2}){4}$#',$nombre)) {							
				$nombre = str_replace(array("-","_"," "), "", $nombre);
				return true;
			}

			return false;	
		}
	
	
	}

	
	