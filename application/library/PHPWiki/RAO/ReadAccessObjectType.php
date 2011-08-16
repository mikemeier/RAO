<?php

	namespace PHPWiki\RAO;

	class ReadAccessObjectType {
		
		/**
		 * @var \Closure 
		 */
		protected $contentClosure;
		
		/**
		 * @var \Closure 
		 */
		protected $headersClosure;
		
		/**
		 * @var \Closure 
		 */
		protected $metaDataClosure;
		
		/**
		 * @var \Closure 
		 */
		protected $hasAccess;
		
		/**
		 * @param \Closure $contentClosure
		 * @param \Closure $headersClosure
		 * @param \Closure $metaDataClosure
		 * @param \Closure $hasAccessClosure
		 */
		public function __construct(
			\Closure $contentClosure,
			\Closure $headersClosure,
			\Closure $metaDataClosure	= null,
			\Closure $hasAccessClosure	= null
		){
			if(is_null($metaDataClosure))
				$metaDataClosure = function(){return array();};
			if(is_null($hasAccessClosure))
				$hasAccessClosure = function(){return true;};
			$this->contentClosure	= $contentClosure;
			$this->headersClosure	= $headersClosure;
			$this->metaDataClosure	= $metaDataClosure;
			$this->hasAccessClosure = $hasAccessClosure;
		}
		
		/**
		 * @return \Closure 
		 */
		public function getContentClosure(){
			return $this->contentClosure;
		}
		
		/**
		 * @return \Closure 
		 */
		public function getHeadersClosure(){
			return $this->headersClosure;
		}
		
		/**
		 * @return \Closure 
		 */
		public function getMetaDataClosure(){
			return $this->metaDataClosure;
		}
		
		/**
		 * @return \Closure 
		 */
		public function getHasAccessClosure(){
			return $this->hasAccessClosure;
		}
		
	}