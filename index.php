<?php
require_once(dirname(__FILE__).'/system/Lateph.php');
$configFile = dirname(__FILE__).'/app/config/main.php';
$config = require($configFile);
Lateph::run($config);