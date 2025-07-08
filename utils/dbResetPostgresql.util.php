<?php
declare(strict_types=1);
require_once 'bootstrap.php';

$dsn = "pgsql:host={$databases['pg_host']};port={$databases['pg_port']};dbname={$databases['pg_db']}";

try {
$pdo = new PDO($dsn, $databases['pg_user'], $databases['pg_pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "Connected to PostgreSQL!\n";

$dbfiles = ['database/user.model.sql', 'database/meeting.model.sql', 'database/meeting_users.model.sql', 'database/task.model.sql'];

foreach ($dbfiles as $dbfile){
$sql = file_get_contents($dbfile);
if (!$sql) {
    throw new RuntimeException("❌ Could not read the SQL file" . $dbfile);
}
echo "✅ Tables $dbfile is created.\n";
$pdo->exec($sql);
}

echo "✅ All Tables created successfully.\n";

echo "Truncating tables…\n";
foreach (['users', 'roles', 'groups'] as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
    echo "the table $table has been truncated. \n";
}

echo "✅ All Tables truncated.\n";

} catch (Exception $e) {
echo "❌ ERROR: " . $e->getMessage() . "\n";
exit(255);
}