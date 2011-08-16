<?php

	use PHPWiki\RAO\ReadAccessObjectType;
	use PHPWiki\RAO\ReadAccessObject;

	/**
	 * Db instanzieren
	 */
	$db = new PDO(
		'sqlite:'. APP_PATH . DS . 'RAO' . DS . 'sqlite'. DS .'database.sqlite',
		null,
		null,
		array(
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		)
	);
	
	/**
	 * Closure die verwendet werden kann um File-Inhalt zu lesen
	 * Braucht den Pfad um den Inhalt auszugeben der Datei
	 * Braucht das ReadAccessObject um den Error-Code zu setzen, falls Datei nicht gefunden
	 */
	$fileGetContentsClosure = function(ReadAccessObject $object, $path){
		if(!file_exists($path) || !is_readable($path)){
			$object->setErrorCode(ReadAccessObject::ERROR_NOT_FOUND);
			return '';
		}
		return file_get_contents($path);
	};
	
	/**
	 * Einfache Textausgabe mit dem Identifier des konkreten Objektes
	 * Die Text-Datei liegt auf dem Filesystem
	 */
	$textObjectType = new ReadAccessObjectType(
			
		function(ReadAccessObject $object) use ($fileGetContentsClosure){
			return $fileGetContentsClosure(
				$object,
				APP_PATH . DS . 'RAO' . DS . 'files' . DS . (int)$object->getIdentifier() .'.txt'
			);
		},
				
		function(ReadAccessObject $object){
			return array (
				'Content-Type' => 'text/plain'
			);
		}
		
	);
	
	/**
	 * Bild Ausgabe mit Content auf dem Filesystem
	 * und MetaDaten in einer Datenbank
	 * hasAccessClosure prüft ob der User eingeloggt ist
	 */
	$imageObjectType = new ReadAccessObjectType(
			
		function(ReadAccessObject $object) use ($fileGetContentsClosure){
			return $fileGetContentsClosure(
				$object,
				APP_PATH . DS . 'RAO' . DS .  'images' . DS . (int)$object->getIdentifier() .'.jpg'
			);
		},
				
		function(ReadAccessObject $object){
			return array (
				'Content-Type' => 'image/jpeg'
			);
		},
				
		function(ReadAccessObject $object) use ($db){
			$sql = 'SELECT `id`, `name` FROM `image` WHERE `id` = '. (int)$object->getIdentifier() .' LIMIT 1';
			if(!$result = $db->query($sql)->fetch()){
				$object->setErrorCode(ReadAccessObject::ERROR_NOT_FOUND);
				return array();
			}
			return $result;
		},
				
		function(ReadAccessObject $object){
			if(!isset($_SESSION['loggedin']) || true !== $_SESSION['loggedin']){
				$object->setErrorCode(ReadAccessObject::ERROR_NO_ACCESS);
				return false;
			}
			return true;
		}
		
	);