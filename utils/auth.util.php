<?php
class Auth
{

    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
        $_SESSION['user'] = [
            'id' => '',
            'username' => '',
            'role' => 'guest',
            'first_name' => '',
            'last_name' => '',
        ];
    }
    }

    public static function login($username, $password)
    {
        require_once BASE_PATH . '/bootstrap.php';
        require_once UTILS_PATH . '/envSetter.util.php';
        global $databases;
        $dsn = "pgsql:host={$databases['pg_host']};port={$databases['pg_port']};dbname={$databases['pg_db']}";
        try {
        $pdo = new PDO($dsn, $databases['pg_user'], $databases['pg_pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);} catch (Exception $e) {
        echo "❌ ERROR: " . $e->getMessage() . "\n";
        exit(255);
        }

        if (!$pdo) {
            return ['success' => false, 'message' => 'Database connection failed.'];
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return ['success' => false, 'message' => 'User not found.'];
        }

        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Incorrect password.'];
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role_id'], 
            'first_name' => $user['first_name'], 
            'last_name' => $user['last_name'],  
        ];
        

        return ['success' => true, 'message' => 'Login successful.'];
    }

    public static function user()
    {
        self::init();
        return $_SESSION['user'] ?? null;
    }

    public static function check()
    {
        self::init();
        return isset($_SESSION['user']);
    }

    public static function logout()
    {
        self::init();
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    }

}
