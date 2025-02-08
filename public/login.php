<?php
require_once __DIR__ . '/../includes/init.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Nexus</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="/assets/css/styles.css" rel="stylesheet">
    <link href="/assets/css/auth.css" rel="stylesheet">
</head>
<body class="login-page">
    <div class="auth-container">
        <div class="auth-welcome">
            <div class="brand-logo">
                <i class="bi bi-people-fill"></i>
            </div>
            <h1 class="welcome-text">С возвращением!</h1>
            <p class="welcome-description">
                Войдите в свой аккаунт, чтобы продолжить общение с друзьями и быть в курсе последних событий
            </p>
        </div>

        <div class="auth-form-container">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form class="login-form" action="/auth/login.php" method="POST">
                <div class="text-center mb-4">
                    <h2 class="auth-form-title">Вход в аккаунт</h2>
                    <p class="auth-form-subtitle">Введите ваши данные для входа</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" class="form-control dynamic-placeholder" 
                               placeholder="Введите ваш email" 
                               name="username" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Пароль</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" class="form-control dynamic-placeholder" 
                               placeholder="Введите ваш пароль" 
                               name="password" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Запомнить меня</label>
                    </div>
                    <a href="/forgot-password.php" class="text-decoration-none small">Забыли пароль?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100">Войти</button>

                <div class="text-center mt-4">
                    <div class="divider">
                        <span class="divider-text">или</span>
                    </div>
                </div>

                <div class="social-login mt-4">
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-outline-light social-btn">
                            <i class="bi bi-google"></i>
                        </button>
                        <button type="button" class="btn btn-outline-light social-btn">
                            <i class="bi bi-facebook"></i>
                        </button>
                        <button type="button" class="btn btn-outline-light social-btn">
                            <i class="bi bi-apple"></i>
                        </button>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        Ещё нет аккаунта? <a href="/register.php" class="text-decoration-none">Создать аккаунт</a>
                    </small>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Функция для адаптивного размера placeholder
        function adjustPlaceholderSize() {
            document.querySelectorAll('.dynamic-placeholder').forEach(input => {
                const inputWidth = input.offsetWidth;
                const placeholder = input.getAttribute('placeholder');
                const tempSpan = document.createElement('span');
                tempSpan.style.visibility = 'hidden';
                tempSpan.style.position = 'absolute';
                tempSpan.style.whiteSpace = 'nowrap';
                tempSpan.style.font = window.getComputedStyle(input).font;
                tempSpan.textContent = placeholder;
                document.body.appendChild(tempSpan);

                const textWidth = tempSpan.offsetWidth;
                document.body.removeChild(tempSpan);

                input.classList.remove('small-placeholder', 'smaller-placeholder', 'smallest-placeholder');

                if (textWidth > inputWidth * 0.9) {
                    if (textWidth > inputWidth * 1.3) {
                        input.classList.add('smallest-placeholder');
                    } else if (textWidth > inputWidth * 1.1) {
                        input.classList.add('smaller-placeholder');
                    } else {
                        input.classList.add('small-placeholder');
                    }
                }
            });
        }

        window.addEventListener('load', adjustPlaceholderSize);
        window.addEventListener('resize', adjustPlaceholderSize);
        setTimeout(adjustPlaceholderSize, 100);
    </script>
</body>
</html>
