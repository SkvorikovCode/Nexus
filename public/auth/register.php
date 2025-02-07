<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $family = trim($_POST['family']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $age = $_POST['age'];

    if (empty($name) || empty($family) || empty($email) || empty($password) || empty($confirm_password) || empty($age)) {
        $error = 'Пожалуйста, заполните все поля';
    } elseif ($password !== $confirm_password) {
        $error = 'Пароли не совпадают';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль должен содержать минимум 6 символов';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $error = 'Этот email уже зарегистрирован';
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (name, family, email, phone, pass, age) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$name, $family, $email, $phone, password_hash($password, PASSWORD_DEFAULT), $age])) {
                $success = 'Регистрация успешна! Теперь вы можете войти.';
                header('Location: /auth/login.php');
                exit;
            } else {
                $error = 'Произошла ошибка при регистрации';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Nexus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="/assets/css/styles.css" rel="stylesheet">
</head>
<body class="login-page">
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="login-form fade-in">
                    <div class="text-center mb-4">
                        <h1 class="h3 font-bold">Регистрация</h1>
                        <p class="text-muted">Создайте свой аккаунт в Nexus</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Имя</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Фамилия</label>
                            <input type="text" name="family" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Телефон</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Дата рождения</label>
                            <input type="date" name="age" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Пароль</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Подтвердите пароль</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Зарегистрироваться</button>
                        
                        <p class="text-center mb-0">
                            Уже есть аккаунт? <a href="/auth/login.php">Войти</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/theme-switcher.js"></script>
</body>
</html> 