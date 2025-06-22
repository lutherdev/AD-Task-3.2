<?php

require_once __DIR__ . '/../utils/envSetter.util.php';

$mongoUri = $typeConfig['mongo_uri'];

try {
    $mongo = new MongoDB\Driver\Manager($mongoUri);

    $command = new MongoDB\Driver\Command(["ping" => 1]);
    $mongo->executeCommand("admin", $command);

    echo "✅ Connected to MongoDB successfully. WEH  <br>";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "❌ MongoDB connection failed: " . $e->getMessage() . "  <br>";
}
