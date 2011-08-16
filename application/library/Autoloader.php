<?php

	namespace Autoload;

	class Autoloader {

		public static function register(){
			spl_autoload_register(
				function($classname){
					$dirname  = dirname(__FILE__);
					$fileName = str_replace('\\',DIRECTORY_SEPARATOR,$classname).'.php';
					$file     = $dirname.DIRECTORY_SEPARATOR.$fileName;
					if(is_readable($file))require_once $file;
				}
			);
		}

	}