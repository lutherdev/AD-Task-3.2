<?php
if (!defined("HANDLERS_PATH")) define("HANDLERS_PATH", __DIR__ . "/handlers");
if (!defined("UTILS_PATH")) define("UTILS_PATH", __DIR__ . "/utils");

?>
<html>
    <body>
    <?php 
    include_once HANDLERS_PATH . "/mongodbChecker.handler.php";
    include_once HANDLERS_PATH . "/postgreChecker.handler.php";
    include_once UTILS_PATH . "/dbResetPostgresql.util.php";
    ?>
    </body>
</html>
