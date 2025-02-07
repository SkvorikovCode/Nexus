<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Безопасное получение POST-параметров
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Валидация
    if (empty($email) || empty($password)) {
        $error = 'Пожалуйста, заполните все поля';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Пожалуйста, введите корректный email';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['pass'])) {
                // Создаем сессию пользователя
                create_user_session($user);
                
                // Перенаправляем на главную или на запрошенную страницу
                $redirect_to = isset($_SESSION['return_to']) ? $_SESSION['return_to'] : '/';
                unset($_SESSION['return_to']);
                redirect($redirect_to);
            } else {
                $error = 'Неверный email или пароль';
            }
        } catch (PDOException $e) {
            error_log("Ошибка при входе пользователя: " . $e->getMessage());
            $error = 'Произошла ошибка при входе. Пожалуйста, попробуйте позже.';
        }
    }
}

// Получаем значение email для автозаполнения формы при ошибке
$email_value = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
?>

<!DOCTYPE html>
<html lang="ru" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Nexus</title>
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
                        <h1 class="h3 font-bold">Вход в Nexus</h1>
                        <p class="text-muted">Войдите в свой аккаунт</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo e($error); ?></div>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control" 
                                   value="<?php echo $email_value; ?>"
                                   required 
                                   autocomplete="email">
                            <div class="invalid-feedback">
                                Пожалуйста, введите корректный email
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Пароль</label>
                            <input type="password" 
                                   name="password" 
                                   class="form-control" 
                                   required 
                                   autocomplete="current-password">
                            <div class="invalid-feedback">
                                Пожалуйста, введите пароль
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Войти</button>
                        
                        <p class="text-center mb-0">
                            Нет аккаунта? <a href="/auth/register.php">Зарегистрироваться</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/theme-switcher.js"></script>
    <script>
    // Включаем валидацию форм Bootstrap
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
    </script>
</body>
</html> 