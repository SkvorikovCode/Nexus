<?php
require_once __DIR__ . '/../includes/init.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Nexus</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="/assets/css/styles.css" rel="stylesheet">
</head>
<body class="login-page">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-4">
                <div class="text-center mb-4">
                    <h1 class="h3">Создайте аккаунт</h1>
                    <p class="lead">Присоединяйтесь к Nexus!</p>
                </div>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <form class="login-form" action="/auth/register.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Имя</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-person text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" 
                                   placeholder="Введите ваше имя" 
                                   name="name" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Фамилия</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-person text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" 
                                   placeholder="Введите вашу фамилию" 
                                   name="family" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-envelope text-muted"></i>
                            </span>
                            <input type="email" class="form-control border-start-0" 
                                   placeholder="Введите ваш email" 
                                   name="email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Телефон</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-phone text-muted"></i>
                            </span>
                            <input type="tel" class="form-control border-start-0" 
                                   placeholder="Введите ваш телефон" 
                                   name="phone" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Дата рождения</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-calendar text-muted"></i>
                            </span>
                            <input type="date" class="form-control border-start-0" 
                                   name="age" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Пароль</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-lock text-muted"></i>
                            </span>
                            <input type="password" class="form-control border-start-0" 
                                   placeholder="Придумайте пароль" 
                                   name="password" required>
                        </div>
                        <div class="form-text">Минимум 6 символов</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Подтверждение пароля</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-lock-fill text-muted"></i>
                            </span>
                            <input type="password" class="form-control border-start-0" 
                                   placeholder="Повторите пароль" 
                                   name="password_confirm" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">Зарегистрироваться</button>

                    <div class="text-center">
                        <p class="mb-0">
                            Уже есть аккаунт? <a href="/login.php" class="text-decoration-none">Войти</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- IMask -->
    <script src="https://unpkg.com/imask"></script>
    <script>
        // Маска для телефона
        IMask(document.querySelector('input[name="phone"]'), {
            mask: '+{7}(000)000-00-00'
        });
    </script>
</body>
</html> 