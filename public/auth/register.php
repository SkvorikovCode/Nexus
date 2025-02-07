<?php
require_once __DIR__ . '/../../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $family = trim($_POST['family'] ?? '');
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    
    // Обработка телефона: оставляем только цифры
    $phone = preg_replace('/[^0-9]/', '', $_POST['phone'] ?? '');
    
    // Форматируем телефон в нужный формат
    if (strlen($phone) === 11) {
        // Если первая цифра 8 или 7, заменяем на +7
        if ($phone[0] === '8' || $phone[0] === '7') {
            $phone = '+7' . substr($phone, 1);
        }
    } elseif (strlen($phone) === 10) {
        // Если 10 цифр, добавляем +7
        $phone = '+7' . $phone;
    }
    
    $age = $_POST['age'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Валидация
    $errors = [];

    if (strlen($name) < 2) {
        $errors[] = 'Имя должно быть не менее 2 символов';
    }

    if (strlen($family) < 2) {
        $errors[] = 'Фамилия должна быть не менее 2 символов';
    }

    if (!$email) {
        $errors[] = 'Введите корректный email';
    }

    // Проверка формата телефона
    if (strlen($phone) !== 12 || !str_starts_with($phone, '+7')) {
        $errors[] = 'Введите корректный номер телефона в формате +7XXXXXXXXXX';
    }

    if (empty($age)) {
        $errors[] = 'Введите дату рождения';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Пароль должен быть не менее 6 символов';
    }

    if ($password !== $password_confirm) {
        $errors[] = 'Пароли не совпадают';
    }

    if (empty($errors)) {
        try {
            $db = getDB();
            
            // Проверяем, не занят ли email
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $_SESSION['error'] = 'Этот email уже зарегистрирован';
                header('Location: /register.php');
                exit;
            }
            
            // Создаем нового пользователя
            $stmt = $db->prepare("
                INSERT INTO users (name, family, email, phone, age, pass) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $name,
                $family,
                $email,
                $phone,
                $age,
                hashPassword($password)
            ]);
            
            // Авторизуем пользователя
            $_SESSION['user_id'] = $db->lastInsertId();
            $_SESSION['email'] = $email;
            
            header('Location: /');
            exit;
            
        } catch(PDOException $e) {
            $_SESSION['error'] = 'Ошибка регистрации: ' . $e->getMessage();
            header('Location: /register.php');
            exit;
        }
    } else {
        $_SESSION['error'] = implode('<br>', $errors);
        header('Location: /register.php');
        exit;
    }
} else {
    header('Location: /register.php');
    exit;
} 