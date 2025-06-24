<?php
declare(strict_types=1);

require_once 'bootstrap.php';

$pgConfig = [
'host' => $_ENV['PG_HOST'],
'port' => $_ENV['PG_PORT'],
'db'   => $_ENV['PG_DB'],
'user' => $_ENV['PG_USER'],
'pass' => $_ENV['PG_PASS'],
];

if (file_exists('/.dockerenv')) {
    $pgConfig['host'] = $_ENV['PG_HOST'] = 'postgresql';
    $pgConfig['port'] = '5432'; 
} else {
    $pgConfig['host'] = 'localhost';
}

$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";
try {
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "Connected to PostgreSQL!\n";

$dbfiles = ['database/user.model.sql', 'database/meeting.model.sql', 'database/meeting_users.model.sql', 'database/task.model.sql'];

foreach ($dbfiles as $dbfile){
$sql = file_get_contents($dbfile);
if (!$sql) {
    throw new RuntimeException("❌ Could not read SQL file");
}

$pdo->exec($sql);
}

echo "✅ Tables created successfully.\n";

foreach (['users', 'roles', 'groups'] as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}

echo "✅ Tables truncated.\n";

} catch (Exception $e) {
echo "❌ ERROR: " . $e->getMessage() . "\n";
  exit(255);
}