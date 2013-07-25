<?php
//Generic class representing a cache type
class GameStatus_Cache {
	
	function &create($conf) {
		if(!is_array($conf)) {
			$conf = array('type' => $conf);
		}
		
		if(!isset($conf['cachetime'])) {
			$conf['cachetime'] = 30;
		}
		
		$filename = $conf['type'] . '.php';
		$classname = 'GameStatus_' . ucfirst($conf['type']);
		
		if(require_once('cache/' . $filename)) {
			$cache =& new $classname($conf);
			return $cache;
		}
		return false;
	}
	
	private $conf;
	
	public function __construct($conf) {
		$this->conf = $conf;
		//Nothing
	}
	
	public function set($key, $value, $time) {
		
	}
	
	public function get($key) {
		
	}
	
}
?>