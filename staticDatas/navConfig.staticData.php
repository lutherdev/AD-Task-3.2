<?php
return [
    'admin' => [
        ['label' => 'Dashboard', 'href' => '/dashboard'],
        ['label' => 'Profile', 'href' => '/profile'],
        ['label' => 'Settings', 'href' => '/settings'],
        ['label' => 'Logout', 'href' => '/handlers/logout.handler.php'],
    ],
    'member' => [
        ['label' => 'Home', 'href' => '/homepage'],
        ['label' => 'Profile', 'href' => '/profile'],
        ['label' => 'Logout', 'href' => '/handlers/logout.handler.php'],
    ],
    'guest' => [
        ['label' => 'Home', 'href' => '/homepage'],
        ['label' => 'Login', 'href' => '/login'],
        ['label' => 'Register', 'href' => '/register'],
    ],
];

