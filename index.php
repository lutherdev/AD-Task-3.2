<?php
session_start();

require_once BASE_PATH . '/bootstrap.php';
require_once LAYOUTS_PATH . '/main.layout.php';
require_once UTILS_PATH . '/auth.util.php';

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), "/");
if ($uri === "") {
    $folder = "/homepage";
} else {
    $folder = $uri;
}

$pageFile = PAGES_PATH . "/{$folder}/index.php";
$pageCssPath = "pages/{$folder}/assets/css/{$folder}.css";
$title = ucfirst($folder);

renderMainLayout(function () use ($pageFile) {
    if (file_exists($pageFile)) {
        require $pageFile;
    } else {
        echo "<h1>404 - Page Not Found</h1>";
    }
}, $title, $pageCssPath);

