<?php
class GameStatus_Mysql extends GameStatus_Cache {
	
	private $setq = false;
	private $getq = false;
	private $delq = false;
	
	public function __construct($conf) {
		parent::__construct($conf);
		
		try {
			new PDO("mysql:host=$conf[host];dbname=$conf[database]", $conf['username'], $conf['password']);
		} catch(PDOException $e) {
			
		}
	}
	
	public function set($key, $value, $time) {
		if(!is_string($value)) {
			$value = json_encode($value);
		}
		if(!$this->setq) {
			$this->setq = $this->sql->prepare('INSERT INTO gamestatus_cache (`key`, `value`, `time`) VALUES (?, ?, ?)');
		}
		return $this->setq->execute(array($key, $value, time() + $time));
	}
	
	public function get($key) {
		if(!$this->getq) {
			$this->getq = $this->sql->prepare('SELECT `value` FROM gamestatus_cache WHERE `key` = ?');
		}
		$res = $this->getq->execute(array($key));
		if($res->rowCount() > 0) {
			$obj = $res->fetch(PDO::FETCH_OBJ);
			if(time() > $obj->time) {
				if(!$this->delq) {
					$this->delq = $this->sql->prepare('DELETE FROM gamestatus_cache WHERE `key` = ?');
				}
				$this->delq->execute(array($key));
				return false;
			}
			return $obj;
		}
		return false;
	}
}
?>