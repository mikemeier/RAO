<?php

	/**
	 * Error Reporting aktivieren
	 */
	error_reporting(E_ALL);
	ini_set('display_errors', true);
	
	/**
	 * Pfade definieren
	 */
	define('DS',		DIRECTORY_SEPARATOR);
	define('APP_PATH',	__DIR__);
	define('LIB_PATH',	APP_PATH . DS . 'library');
	
	/**
	 * Date und Locale einstellen
	 */
	date_default_timezone_set('Europe/Zurich');
	setlocale(LC_ALL, 'de_CH.UTF-8');

	/**
	 * Autoloader registrieren
	 */
	require_once LIB_PATH . DS . 'Autoloader.php';
	Autoload\Autoloader::register();