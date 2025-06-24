<?php
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

echo "✅ ENV LOADED TEST: PG_HOST = " . $_ENV['PG_HOST'] . "<br>";
echo "✅ ENV LOADED TEST: MONGO_URI = " . $_ENV['MONGO_URI'] . "<br>";

global $typeConfig;
$typeConfig = [
    'env'       => $_ENV['ENV_NAME'] ?? 'unknown',
    'pg_host'   => $_ENV['PG_HOST'] ?? 'missing',
    'pg_port'   => $_ENV['PG_PORT'] ?? 'missing',
    'pg_db'     => $_ENV['PG_DB'] ?? 'missing',
    'pg_user'   => $_ENV['PG_USER'] ?? 'missing',
    'pg_pass'   => $_ENV['PG_PASS'] ?? 'missing',
    'mongo_uri' => $_ENV['MONGO_URI'] ?? 'missing',
    'mongo_db'  => $_ENV['MONGO_DB'] ?? 'missing',
];