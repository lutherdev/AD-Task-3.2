<?php
require_once 'bootstrap.php';
global $databases;

$conn_string = "host={$databases['pg_host']} port={$databases['pg_port']} dbname={$databases['pg_db']} user={$databases['pg_user']} password={$databases['pg_pass']}";

$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    echo "❌ Connection Failed: ", pg_last_error() . "  <br>";
    exit();
} else {
    echo "✔️ PostgreSQL Connection <br>";
    pg_close($dbconn);
}