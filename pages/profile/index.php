<?php
declare(strict_types=1);
require_once BASE_PATH . '/bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';

if (!Auth::check()) {
    header('Location: /login');
    exit;
}

$user = Auth::user();

require_once TEMPLATES_PATH . '/head.component.php';
require_once TEMPLATES_PATH . '/nav.component.php';
?>

    
</head>
<body>
    <h1>👤 Session Information</h1>

    
    <div class="info-box">
        <h2>User Details</h2>
        <div><strong>ID:</strong> <?= htmlspecialchars((string) $user['id']) ?></div>
        <div><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></div>
        <div><strong>Role:</strong> <?= $user['role'] == 1 ? 'Admin' : 'Member' ?></div>
        <div><strong>First Name:</strong> <?= htmlspecialchars($user['first_name']) ?></div>
        <div><strong>Last Name:</strong> <?= htmlspecialchars($user['last_name']) ?></div>
    </div>
</body>
</html>
