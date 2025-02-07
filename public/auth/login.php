<?php
require_once __DIR__ . '/../../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    // TODO: Добавить валидацию и проверку в базе данных
    
    try {
        $db = getDB();
        
        // Здесь будет проверка пользователя
        // Пока просто редирект на главную
        $_SESSION['user_id'] = 1; // Временно
        $_SESSION['username'] = $username;
        
        header('Location: /');
        exit;
        
    } catch(PDOException $e) {
        $_SESSION['error'] = 'Ошибка авторизации: ' . $e->getMessage();
        header('Location: /login.php');
        exit;
    }
} else {
    header('Location: /login.php');
    exit;
} 