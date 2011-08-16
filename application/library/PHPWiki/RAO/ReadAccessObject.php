<?php

	namespace PHPWiki\RAO;

	class ReadAccessObject {
		
		/**
		 * @var mixed 
		 */
		protected $identifier;
		
		/**
		 * @var string
		 */
		protected $content = null;
		
		/**
		 * @var array
		 */
		protected $metaData = null;
		
		/**
		 * @var array
		 */
		protected $headers = null;
		
		/**
		 * @var ReadAccessObjectType
		 */
		protected $type;
		
		/**
		 * @var int 
		 */
		protected $errorCode = null;
		
		const ERROR_NOT_FOUND = 1;
		const ERROR_NO_ACCESS = 2;

		/**
		 * @param mixed $identifier
		 * @param ReadAccessObjectType $type
		 * @param string $content
		 * @param array $headers 
		 * @param array $metaData 
		 */
		public function __construct(
			$identifier,
			ReadAccessObjectType $type = null,
			$content = null,
			array $headers = null,
			array $metaData = null
		){
			$this->identifier	= $identifier;
			$this->type			= $type;
			$this->content		= $content;
			$this->headers		= $headers;
			$this->metaData		= $metaData;
		}
		
		/**
		 * @return mixed 
		 */
		public function getIdentifier(){
			return $this->identifier;
		}
		
		/**
		 * @return string 
		 */
		public function getContent(){
			return $this->getData('content');
		}
		
		/**
		 * @return array 
		 */
		public function getMetaData(){
			return $this->getData('metaData');
		}
		
		/**
		 * @return array 
		 */
		public function getHeaders(){
			return $this->getData('headers');
		}
		
		/**
		 * @return mixed 
		 */
		public function output(){
			if(
				($headers = $this->getHeaders())
				&&
				($content = $this->getContent())
			){
				foreach($headers as $key => $value)
					header($key.': '. $value);
				echo $content;
			}
			return false;				
		}
		
		/**
		 * @return bool 
		 */
		public function hasAccess(){
			if(is_null($this->type))
				return true;
			$method = $this->type->getHasAccessClosure();
			return $method($this);
		}
		
		/**
		 * @param int $errorCode
		 * @return void
		 */
		public function setErrorCode($errorCode){
			$this->errorCode = (int)$errorCode;
		}
		
		/**
		 * @return int 
		 */
		public function getErrorCode(){
			return $this->errorCode;
		}
		
		/**
		 * @param string $what
		 * @return mixed 
		 */
		protected function getData($what){
			if(!$this->hasAccess()){
				$this->setErrorCode(self::ERROR_NO_ACCESS);
				return false;
			}
			
			if(!is_null($this->$what))
				return $this->$what;
			
			if(is_null($this->type))
				throw new \Exception("Need ReadAccessObjectType for $what");
			
			$methodName = 'get' . $what . 'Closure';
			$method		= $this->type->$methodName();
			
			return $this->$what = $method($this);
		}
		
	}