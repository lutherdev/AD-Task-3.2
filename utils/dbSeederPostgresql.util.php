<?php
declare(strict_types=1);

require_once 'bootstrap.php';

$users = require_once DUMMIES_PATH . '/users.staticData.php';
$roles = require_once DUMMIES_PATH . '/roles.staticData.php';

$dsn = "pgsql:host={$databases['pg_host']};port={$databases['pg_port']};dbname={$databases['pg_db']}";

try {
    $pdo = new PDO($dsn, $databases['pg_user'], $databases['pg_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    echo "Connected to PostgreSQL!\n";

    $checkStmt = $pdo->query("SELECT to_regclass('public.users')");
    $tableExists = $checkStmt->fetchColumn();

    if (!$tableExists) {
        throw new Exception("Table 'users' does not exist. Please run migrations first.");
    }

    echo "Seeding roles…\n";

    $roleStmt = $pdo->prepare("
        INSERT INTO roles (id, name) VALUES (:id, :name)
        ON CONFLICT (id) DO NOTHING
    ");

    foreach ($roles as $r) {
        try {
            $roleStmt->execute([
                ':id' => $r['id'],
                ':name' => $r['name']
            ]);
            echo "Inserted role: {$r['name']}\n";
        } catch (PDOException $e) {
            echo "Failed to insert role {$r['name']}: " . $e->getMessage() . "\n";
        }
    }

    echo "All roles seeded.\n\n";

    echo "Seeding users…\n";

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO users (username, role_id, first_name, last_name, password)
        VALUES (:username, :role_id, :fn, :ln, :pw)
    ");

    foreach ($users as $u) {
        try {
            $stmt->execute([
                ':username' => $u['username'],
                ':role_id'     => $u['role'],
                ':fn'       => $u['first_name'],
                ':ln'       => $u['last_name'],
                ':pw'       => password_hash($u['password'], PASSWORD_DEFAULT),
            ]);
            echo "Inserted user: {$u['username']}\n";
        } catch (PDOException $e) {
            echo "Failed to insert {$u['username']}: " . $e->getMessage() . "\n";
        }
    }

    $pdo->commit();

    echo "All users seeded.\n\n";

    


    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $roleStmt = $pdo->query("SELECT * FROM roles");
    $rolesRaw = $roleStmt->fetchAll(PDO::FETCH_ASSOC);

    $roles = [];
    foreach ($rolesRaw as $r) {
        $roles[$r['id']] = $r['name'];
    }
    //FOR CHECKING OUTPUT LOGS
    foreach ($users as $user) {
        echo "---------------------------\n";
        echo "User ID:    {$user['id']}\n";
        echo "Username:   {$user['username']}\n";
        echo "First Name: {$user['first_name']}\n";
        echo "Last Name:  {$user['last_name']}\n";
        $roleName = $roles[$user['role_id']] ?? 'Unknown';
        echo "Role:       {$roleName}\n";
        echo "---------------------------\n";
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(255);
}




