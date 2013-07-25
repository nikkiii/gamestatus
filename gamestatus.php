<?php
/*
 *  GameStatus (PHP Query script)
 *  Copyright (C) 2012 Nikki <nikki@nikkii.us>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'includes/gsquery/gsquery.php';

$config = array(
	// Empty
);

/**
 * Whitelist, recommended if you don't want to have the data available to anyone who queries
 */
/*
$config['whitelist'] = array(
	'server1.myserver.com:27015'
);
*/

/**
 * Blacklist, useful if you want it to be open, but have a specific server causing problems
 */
/*
$config['blacklist'] = array(
	'server2.myserver.com:25565'
);*/

/**
 * File cache, usually good enough
 */
$config['cache'] = array(
	'type' => 'file',
	'cachedir' => '/var/www/nikkii.us/gamestatus/cache/',
	//Default cache time
	'cachetime' => 30
);

/**
 * Memcache, better if you have it :)
 */
/*
$config['cache'] = array(
	'type' => 'memcache',
	'host' => 'localhost',
	'port' => 11211,
	//Default cache time
	'cachetime' => 30
);
*/

/*
 * MySQL Cache, could cause unneeded load, but could be better than file for some things.
 */
/**
$config['cache'] = array(
	'type' => 'mysql',
	'host' => 'localhost',
	'database' => 'gamestatus',
	'username' => 'username',
	'password' => 'password',
	//Default cache time
	'cachetime' => 30
);
*/

$defaultports = array(
	'halflife2' => 27015,
	'minecraft' => 25565
);

$address = $_GET['address'];
$type = isset($_GET['type']) ? $_GET['type'] : 'halflife2';

if(!stristr($address, ":")) {
	$address = $address . ":" . $defaultports[$type];
}

if(isset($config['whitelist']) && !in_array($address, $config['whitelist']) || isset($config['blacklist']) && in_array($address, $config['blacklist'])) {
	die(json_encode(array('status' => 'failed', 'message' => 'Invalid server')));
}

$cache = false;
if(!empty($config['cache'])) {
	require_once 'includes/gscache.php';
	
	$cache = GameStatus_Cache::create($config['cache']);
}

$cachekey = md5($address);

$info = false;

if($cache) {
	$info = $cache->get($cachekey);
}

if(!$info) {
	$info = array('status' => 'failed');
	
	$query = GSQuery::create($type, array(
		'host' => $address,
		'port' => $port
	));
	
	if($query) {
		$info = $query->queryInfo();
	
		if($type == 'minecraft') {
			$info->hostip = $address;
		} else if($type == 'halflife2') {
			$info->ipport = $address . ':' . $port;
			// HL2 Defaults
			if(!$info->name && !$info->map) {
				$info->name = 'Server Offline';
				$info->map = 'Unknown';
			}
		}
	} else {
		die('Invalid type!');
	}
	
	$info->time = time();
	
	if($cache) {
		$cache->set($cachekey, $info, $config['cache']['cachetime']);
	}
}

header("Pragma: public");
header("Cache-Control: maxage=" . $config->serverstatus['cachetime']);
header('Expires: ' . gmdate('D, d M Y H:i:s', $info->time + $config->serverstatus['cachetime']) . ' GMT');

echo json_encode($info);
?>