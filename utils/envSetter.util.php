<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env file from the root directory
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
