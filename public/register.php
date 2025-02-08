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
    <link href="/assets/css/auth.css" rel="stylesheet">
</head>
<body class="login-page">
    <div class="auth-container">
        <div class="auth-welcome">
            <div class="brand-logo">
                <i class="bi bi-people-fill"></i>
            </div>
            <h1 class="welcome-text">Добро пожаловать в Nexus</h1>
            <p class="welcome-description">
                Присоединяйтесь к нашему сообществу, чтобы общаться с друзьями, делиться моментами и находить новые знакомства
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
            
            <form class="login-form" action="/auth/register.php" method="POST">
                <div class="text-center mb-4">
                    <h2 class="auth-form-title">Создайте аккаунт</h2>
                    <p class="auth-form-subtitle">Заполните форму для регистрации</p>
                </div>

                <div class="form-row">
                    <div class="mb-3">
                        <label class="form-label">Имя</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" class="form-control dynamic-placeholder" 
                                   placeholder="Введите имя" 
                                   name="name" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Фамилия</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" class="form-control dynamic-placeholder" 
                                   placeholder="Введите фамилию" 
                                   name="family" required>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" class="form-control dynamic-placeholder" 
                                   placeholder="Введите ваш email" 
                                   name="email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Телефон</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-phone"></i>
                            </span>
                            <input type="tel" class="form-control dynamic-placeholder" 
                                   placeholder="Введите номер телефона" 
                                   name="phone" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Дата рождения</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-calendar"></i>
                        </span>
                        <input type="date" class="form-control dynamic-placeholder" 
                               placeholder="дд.мм.гггг" 
                               name="age" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="mb-3">
                        <label class="form-label">Пароль</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control dynamic-placeholder" 
                                   placeholder="Минимум 6 символов" 
                                   name="password" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Подтверждение</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" class="form-control dynamic-placeholder" 
                                   placeholder="Повторите пароль" 
                                   name="password_confirm" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        Уже есть аккаунт? <a href="/login.php" class="text-decoration-none">Войти</a>
                    </small>
                </div>
            </form>
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

                // Очищаем предыдущие классы
                input.classList.remove('small-placeholder', 'smaller-placeholder', 'smallest-placeholder');

                // Определяем необходимый размер текста
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

        // Вызываем функцию при загрузке и изменении размера окна
        window.addEventListener('load', adjustPlaceholderSize);
        window.addEventListener('resize', adjustPlaceholderSize);

        // Дополнительно вызываем через небольшую задержку для надежности
        setTimeout(adjustPlaceholderSize, 100);
    </script>
</body>
</html> 