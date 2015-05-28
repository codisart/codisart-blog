<?php
	
	class Logger
	{
		private static $instance = null;
		
		private function __construct()
		{
			
		}
	
		private static function getInstance()
		{
			if(is_null(self::$instance))
			{
				self::$instance = new Singleton();
			}
			
			return self::$instance;
		}
		
		
		public static function recordAction()
		{
			self::getInstance();
			
			$instance;
		}
	}
	
	
	