<?php

phpinfo();
die();
/**
 * Created by PhpStorm.
 * User: carina_boom
 * Date: 21-3-2018
 * Time: 14:12
 */

require_once('models/Team.php');
require_once('models/Member.php');
require_once('handlers/Database.php');
require_once('handlers/Cache.php');
require_once('handlers/TeamHandler.php');
require_once('handlers/MemberHandler.php');
require_once('handlers/TimeOffHandler.php');

$cache = new Cache();

$id = $cache->fetch('timeCleanCoffeeMachine');
$cache->delete('timeCleanCoffeeMachine');
var_dump($id);
