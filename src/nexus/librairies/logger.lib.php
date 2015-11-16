<?php

class Logger {
	private static $instance = null;

	protected function __construct() {

	}

	private static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new Logger();
		}

		return self::$instance;
	}

	public static function recordAction() {
		self::getInstance();
	}
}
