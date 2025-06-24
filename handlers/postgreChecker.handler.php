<?php
require_once 'bootstrap.php';

// $host = $_ENV['PG_HOST'];
// $port = $_ENV['PG_PORT'];
// $username = $_ENV['PG_USER'];
// $password = $_ENV['PG_PASS'];
// $dbname = $_ENV['PG_DB'];


//$conn_string = "host=$host port=$port dbname=$dbname user=$username password=$password";
$conn_string = "host={$typeConfig['pg_host']} port={$typeConfig['pg_port']} dbname={$typeConfig['pg_db']} user={$typeConfig['pg_user']} password={$typeConfig['pg_pass']}";


$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    echo "❌ Connection Failed: ", pg_last_error() . "  <br>";
    exit();
} else {
    echo "✔️ PostgreSQL Connection <br>";
    pg_close($dbconn);
}