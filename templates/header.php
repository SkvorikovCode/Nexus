<?php 
require_once ROOT_PATH . '/includes/config.php'; //TODO: ТУДУшка
?>
<!DOCTYPE html>
<html lang="ru" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus - социальная сеть</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="/assets/css/styles.css" rel="stylesheet">
    <script>
        // Проверяем системные настройки темы
        function getPreferredTheme() {
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                return 'dark';
            }
            return 'light';
        }

        // Применяем тему
        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            
            const themeSwitch = document.querySelector('.theme-switch');
            if (themeSwitch) {
                themeSwitch.classList.toggle('active', theme === 'dark');
            }
        }

        // Инициализация темы
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || getPreferredTheme();
            setTheme(savedTheme);

            // Следим за системными настройками
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!localStorage.getItem('theme')) {
                    setTheme(e.matches ? 'dark' : 'light');
                }
            });
        });
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="bi bi-people-fill"></i> Nexus</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/profile.php">
                            <i class="bi bi-person-circle"></i> Мой профиль
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/news.php">
                            <i class="bi bi-newspaper"></i> Новости
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/messages.php">
                            <i class="bi bi-chat-dots"></i> Сообщения
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/friends.php">
                            <i class="bi bi-people"></i> Друзья
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <form class="d-flex me-3">
                        <input class="form-control me-2" type="search" placeholder="Поиск">
                        <button class="btn btn-light" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                    <div class="d-flex align-items-center theme-controls">
                        <i class="bi bi-sun-fill theme-icon sun"></i>
                        <div class="theme-switch" role="button" tabindex="0" aria-label="Переключить тему"></div>
                        <i class="bi bi-moon-fill theme-icon moon"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Управление темой
        const themeSwitch = document.querySelector('.theme-switch');
        
        themeSwitch.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            setTheme(newTheme);

            // Анимация иконок
            const icons = document.querySelectorAll('.theme-icon');
            icons.forEach(icon => icon.style.transform = 'scale(1.2)');
            setTimeout(() => {
                icons.forEach(icon => icon.style.transform = 'scale(1)');
            }, 200);
        });

        // Доступность с клавиатуры
        themeSwitch.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    </script>
</body>
</html> 