<?php

	use PHPWiki\RAO\ReadAccessObject;

	session_start();
	$_SESSION['loggedin'] = (bool)@$_GET['loggedin'];
	
	/**
	 * Bootstrap ausführen
	 */
	require_once '../../application/Bootstrap.php';
	
	/**
	 * ObjectTypes laden
	 */
	require_once 'createObjectTypes.php';
	
	/**
	 * Ein Bild gemäss spezifiziertem ImageObjectType
	 */
	$image = new ReadAccessObject(@$_GET['id'], $imageObjectType);
	$image->output();
	
	if($errorCode = $image->getErrorCode()){
		header('Content-Type: text/plain');
		switch($errorCode){
			case ReadAccessObject::ERROR_NOT_FOUND:
				die('Bild nicht gefunden');
			break;
			case ReadAccessObject::ERROR_NO_ACCESS:
				die('Kein Zugriff auf dieses Bild');
			break;
			default:
				die('Unbekannter Fehler');
			break;
		}
	}