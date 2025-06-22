<?php
if (!defined('BASE_PATH')) define('BASE_PATH', realpath(__DIR__));
if (!defined('UTILS_PATH')) define('UTILS_PATH', BASE_PATH . '/utils');


chdir(BASE_PATH);

require_once __DIR__ . '/utils/envSetter.util.php';