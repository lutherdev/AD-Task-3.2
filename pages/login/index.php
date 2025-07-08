<form action="/handlers/auth.handler.php" method="POST">
    <input id="username" name="username" type="text" required class="input" placeholder="Username">
    <input id="password" name="password" type="password" required class="input" placeholder="Password">
    <button type="submit" class="btn">Login</button>

    <?php if (isset($_GET['error'])): ?>
        <p style="color:red"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['message'])): ?>
        <p style="color:green"><?= htmlspecialchars($_GET['message']) ?></p>
    <?php endif; ?>
</form>
