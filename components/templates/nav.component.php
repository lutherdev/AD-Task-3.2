<?php

$navItems = require STATICDATAS_PATH . '/navConfig.staticData.php';

$role = 'guest';

if ($user) {
    if ($user['role'] == 1) $role = 'admin';
    elseif ($user['role'] == 2) $role = 'member';
}

$items = $navItems[$role];
?>

<nav>
    <ul style="display: flex; list-style: none; gap: 15px;">
        <?php foreach ($items as $item): ?>
            <li><a href="<?= htmlspecialchars($item['href']) ?>"><?= htmlspecialchars($item['label']) ?></a></li>
        <?php endforeach; ?>
    </ul>
    <hr>
</nav>
