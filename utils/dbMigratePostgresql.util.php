<?php
declare(strict_types=1);

require_once 'bootstrap.php';

$dsn = "pgsql:host={$databases['pg_host']};port={$databases['pg_port']};dbname={$databases['pg_db']}";

try {
$pdo = new PDO($dsn, $databases['pg_user'], $databases['pg_pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "Connected to PostgreSQL!\n";

echo "Dropping old tables…\n";
foreach (['users', 'meetings', 'meeting_users', 'tasks', 'roles', 'groups'] as $table) {
$pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
}

echo "Applying schema from database/user.model.sql…\n";

$sql = file_get_contents('database/user.model.sql');

if ($sql === false) {
    throw new RuntimeException("Could not read database/user.model.sql");
} else {
    echo "Creation Success from the database/user.model.sql\n";
}
$pdo->exec($sql);
} catch (Exception $e) {
echo "❌ ERROR: " . $e->getMessage() . "\n";
exit(255);
}