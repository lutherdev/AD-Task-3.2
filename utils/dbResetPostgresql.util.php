<?php
declare(strict_types=1);

// 1) Composer autoload
require 'vendor/autoload.php';

// 2) Composer bootstrap
require 'bootstrap.php';

// 3) envSetter
require_once UTILS_PATH . '/envSetter.util.php';

$pgConfig = [
'host' => $_ENV['PG_HOST'],
'port' => $_ENV['PG_PORT'],
'db'   => $_ENV['PG_DB'],
'user' => $_ENV['PG_USER'],
'pass' => $_ENV['PG_PASS'],
];

if (file_exists('/.dockerenv')) {
    $pgConfig['host'] = $_ENV['PG_HOST'] = 'postgresql';
    $pgConfig['port'] = '5432'; // This matches your docker-compose service name
} else {
    // Running locally (e.g., Windows terminal)
    $pgConfig['host'] = 'localhost'; // or 127.0.0.1 if preferred
}

$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";
try {
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "Connected to PostgreSQL!\n";

$sql = file_get_contents('database/user.model.sql');
if (!$sql) {
    throw new RuntimeException("❌ Could not read SQL file");
}

$pdo->exec($sql);
echo "✅ Tables created successfully.\n";

foreach (['users', 'roles', 'groups'] as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}

echo "✅ Tables truncated.\n";

} catch (Exception $e) {
echo "❌ ERROR: " . $e->getMessage() . "\n";
  exit(255); // return error code
}