class ThemeSwitcher {
    constructor() {
        this.themeSwitch = document.querySelector('.theme-switch');
        this.init();
    }

    // Получение предпочтительной системной темы
    getPreferredTheme() {
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    // Установка темы
    setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        
        if (this.themeSwitch) {
            this.themeSwitch.classList.toggle('active', theme === 'dark');
        }

        // Анимация при смене темы
        document.body.classList.add('theme-transition');
        setTimeout(() => {
            document.body.classList.remove('theme-transition');
        }, 300);
    }

    // Анимация иконок
    animateIcons() {
        const icons = document.querySelectorAll('.theme-icon');
        icons.forEach(icon => {
            icon.style.transform = 'scale(1.2)';
            setTimeout(() => {
                icon.style.transform = 'scale(1)';
            }, 200);
        });
    }

    // Обработчик переключения темы
    handleThemeSwitch() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        this.setTheme(newTheme);
        this.animateIcons();
    }

    // Инициализация
    init() {
        // Установка начальной темы
        const savedTheme = localStorage.getItem('theme') || this.getPreferredTheme();
        this.setTheme(savedTheme);

        if (this.themeSwitch) {
            // Установка начального состояния переключателя
            this.themeSwitch.classList.toggle('active', savedTheme === 'dark');
            
            // Обработчик клика
            this.themeSwitch.addEventListener('click', () => this.handleThemeSwitch());

            // Доступность с клавиатуры
            this.themeSwitch.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.handleThemeSwitch();
                }
            });
        }

        // Следим за системными настройками
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                this.setTheme(e.matches ? 'dark' : 'light');
            }
        });
    }
}

// Инициализация после загрузки DOM
document.addEventListener('DOMContentLoaded', () => {
    new ThemeSwitcher();
}); 