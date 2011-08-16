<?php
	
	/**
	 * Bootstrap ausführen
	 */
	require_once '../../application/Bootstrap.php';
	
	/**
	 * Manuell initialisierte Textdatei ohne ObjectType
	 */
	use PHPWiki\RAO\ReadAccessObject;
	$text = new ReadAccessObject(
		null,
		null,
		'Simpler Text',
		array (
			'Content-Type' => 'text/plain'
		)
	);
	$text->output();
	
	if($errorCode = $text->getErrorCode()){
		header('Content-Type: text/plain');
		switch($errorCode){
			case ReadAccessObject::ERROR_NOT_FOUND:
				die('Datei nicht gefunden');
			break;
			case ReadAccessObject::ERROR_NO_ACCESS:
				die('Kein Zugriff auf diese Datei');
			break;
			default:
				die('Unbekannter Fehler');
			break;
		}
	}