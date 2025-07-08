<?php
declare(strict_types=1);

require_once UTILS_PATH . '/auth.util.php';
require_once COMPONENTS_PATH . '/templates/head.component.php';

function renderMainLayout(callable $content, string $title, string $pageCss = ""): void
{
    Auth::init();
    $user = Auth::user(); 
    head($title, $pageCss);
    include TEMPLATES_PATH . '/nav.component.php';
    $content(); 

    echo "</body></html>";
}
