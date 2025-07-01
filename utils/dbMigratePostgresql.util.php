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

echo "Dropping old tables…\n";
foreach ([
'users',
] as $table) {
  // Use IF EXISTS so it won’t error if the table is already gone
$pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
}


echo "Applying schema from database/user.model.sql…\n";

$sql = file_get_contents('database/user.model.sql');

if ($sql === false) {
    throw new RuntimeException("Could not read database/user.model.sql");
} else {
    echo "Creation Success from the database/user.model.sql";
}
echo "testtttttt";
$pdo->exec($sql);

echo "testtttttt2222222222";
$stmt = $pdo->query("SELECT * FROM users");

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "testtttttt2222222222";

echo "\nDEBUG DUMP:\n";
var_dump($users);
echo "\n";

foreach ($users as $user) {
    echo "---------------------------\n";
    echo "User ID: " . $user['id'] . "\n";
    echo "Username: " . $user['username'] . "\n";
    echo "First Name: " . $user['first_name'] . "\n";
    echo "Last Name: " . $user['last_name'] . "\n";
    echo "Role: " . $user['role'] . "\n";
    echo "---------------------------\n";
}
echo "testtttttt222555555555555555";

} catch (Exception $e) {
echo "❌ ERROR: " . $e->getMessage() . "\n";
exit(255);
}