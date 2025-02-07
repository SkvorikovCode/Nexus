<?php
require_once __DIR__ . '/../../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['username'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (!$email) {
        $_SESSION['error'] = 'Пожалуйста, введите корректный email';
        header('Location: /login.php');
        exit;
    }

    if (strlen($password) < 6) {
        $_SESSION['error'] = 'Пароль должен быть не менее 6 символов';
        header('Location: /login.php');
        exit;
    }
    
    try {
        $db = getDB();
        
        // Ищем пользователя по email
        $stmt = $db->prepare("SELECT id, email, pass FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && verifyPassword($password, $user['pass'])) {
            // Успешная авторизация
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            
            if ($remember) {
                // Если пользователь хочет быть запомненным, устанавливаем куки на 30 дней
                setcookie('user_id', $user['id'], time() + (86400 * 30), '/');
                setcookie('remember_token', bin2hex(random_bytes(32)), time() + (86400 * 30), '/');
            }
            
            header('Location: /');
            exit;
        } else {
            $_SESSION['error'] = 'Неверный email или пароль';
            header('Location: /login.php');
            exit;
        }
        
    } catch(PDOException $e) {
        $_SESSION['error'] = 'Ошибка авторизации: ' . $e->getMessage();
        header('Location: /login.php');
        exit;
    }
} else {
    header('Location: /login.php');
    exit;
} 