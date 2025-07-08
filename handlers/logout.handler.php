<?php
declare(strict_types=1);


require_once BASE_PATH . '/bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';

Auth::logout();

header('Location: /login');
exit;
