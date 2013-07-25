<?php
/**
 * A GameStatus cache implementation for Memcache
 * 
 * @author Nikki
 *
 */
class GameStatus_Memcache extends GameStatus_Cache {
	
	private $memcache;
	
	public function __construct($conf) {
		$conf += array(
			'host' => 'localhost',
			'port' => 11211,
			'prefix' => 'gs_'
		);
		
		parent::__construct($conf);
		
		$this->memcache = new Memcache();
		$this->memcache->connect($conf['host'], $conf['port']);
	}
	
	public function set($key, $value, $time) {
		return $this->memcache->set($this->conf['prefix'] . $key, $value, 0, $this->conf['cachetime']);
	}
	
	public function get($key) {
		return $this->memcache->get($this->conf['prefix'] . $key);
	}
}
?>