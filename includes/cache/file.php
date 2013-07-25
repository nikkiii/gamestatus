<?php
class GameStatus_File extends GameStatus_Cache {
	
	private $cachedir;
	
	public function __construct($conf) {
		parent::__construct($conf);
		
		$this->cachedir = $conf['cachedir'];
	}
	
	public function set($key, $value, $time) {
		$obj = array(
			'time' => time() + $time,
			'type' => is_string($value) ? 'string' : 'json',
			'data' => $value
		);
		
		return file_put_contents($this->cachedir . $key . '.json', json_encode($obj)) ? true : false;
	}
	
	public function get($key) {
		if(file_exists($this->cachedir . $key)) {
			$obj = json_decode(file_get_contents($this->cachedir . $key . '.json'));
			if(time() > $obj->time) {
				unlink($this->cachedir . $key);
				return false;
			}
			return $obj->type == 'json' ? json_decode($obj->data) : $obj->data;
		}
		return false;
	}
}
?>