<?php
require_once UTILS_PATH . '/auth.util.php';
Auth::init(); // 🔑 Start session so $_SESSION is available
$user = Auth::user(); 
var_dump($_SESSION);
?>
<body>
  <h1>🛠️ System Status</h1>

  <div class="status-wrapper">
    <div class="status-box">
      <h2>PostgreSQL</h2>
      <?php include_once HANDLERS_PATH . "/postgreChecker.handler.php"; ?>
      <?= $_SESSION['user']['username'];?>
    </div>

    <div class="status-box">
      <h2>MongoDB</h2>
      <?php include_once HANDLERS_PATH . "/mongodbChecker.handler.php"; ?>
    </div>

  </div>
</body>