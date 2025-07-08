<?php
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// echo "✅ ENV LOADED TEST: PG_HOST = " . $_ENV['PG_HOST'] . "\n";
// echo "✅ ENV LOADED TEST: MONGO_URI = " . $_ENV['MONGO_URI'] . "\n";
global $databases;
$databases = [
    'env'       => $_ENV['ENV_NAME'] ?? 'unknown',
    'pg_host'   => $_ENV['PG_HOST'] ?? 'missing',
    'pg_port'   => $_ENV['PG_PORT'] ?? 'missing',
    'pg_db'     => $_ENV['PG_DB'] ?? 'missing',
    'pg_user'   => $_ENV['PG_USER'] ?? 'missing',
    'pg_pass'   => $_ENV['PG_PASS'] ?? 'missing',
    'mongo_uri' => $_ENV['MONGO_URI'] ?? 'missing',
    'mongo_db'  => $_ENV['MONGO_DB'] ?? 'missing',
];

$runningInsideDocker = file_exists('/.dockerenv');

if ($runningInsideDocker) {
    $databases['pg_host'] = $_ENV['PG_HOST'] = 'host.docker.internal'; 
    $databases['pg_port'] = $_ENV['PG_PORT'] = '3333';
} else {
    
    $databases['pg_host'] = $_ENV['PG_HOST'] = 'localhost';
    $databases['pg_port'] = $_ENV['PG_PORT'] = '3333';
}
