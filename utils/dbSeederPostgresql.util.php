<?php
declare(strict_types=1);

require_once 'bootstrap.php';

$users = require_once DUMMIES_PATH . '/users.staticData.php';

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

$dbfiles = ['database/user.model.sql'];

foreach ($dbfiles as $dbfile){
$num = 1;
$sql = file_get_contents($dbfile);
if (!$sql) {
    throw new RuntimeException("❌ Could not read the SQL file");
}
echo "✅ Tables $num created.\n";
$pdo->exec($sql);
$num++;
}

echo "✅ All Tables created successfully.\n";

foreach (['users'] as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
    echo "the table $table has been truncated. \n";
}

echo "✅ All Tables truncated.\n";

echo "Seeding users…\n";

$stmt = $pdo->prepare("
    INSERT INTO users (username, role, first_name, last_name, password)
    VALUES (:username, :role, :fn, :ln, :pw)
");

foreach ($users as $u) {
    $stmt->execute([
        ':username' => $u['username'],
        ':role' => $u['role'],
        ':fn' => $u['first_name'],
        ':ln' => $u['last_name'],
        ':pw' => password_hash($u['password'], PASSWORD_DEFAULT),
    ]);
}

echo "✅ All Tables seeded.\n";


$stmt = $pdo->query("SELECT * FROM users");

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo "---------------------------\n";
    echo "User ID: " . $user['id'] . "\n";
    echo "Username: " . $user['username'] . "\n";
    echo "First Name: " . $user['first_name'] . "\n";
    echo "Last Name: " . $user['last_name'] . "\n";
    echo "Role: " . $user['role'] . "\n";
    echo "---------------------------\n";
}

} catch (Exception $e) {
echo "❌ ERROR: " . $e->getMessage() . "\n";
exit(255);
}








