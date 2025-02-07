class ThemeSwitcher {
    constructor() {
        console.log('ThemeSwitcher: Initializing...');
        this.themeSwitch = document.querySelector('.theme-switch');
        if (!this.themeSwitch) {
            console.error('ThemeSwitcher: Could not find .theme-switch element');
            return;
        }
        console.log('ThemeSwitcher: Found switch element');
        this.init();
    }

    // Получение предпочтительной системной темы
    getPreferredTheme() {
        const isDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        console.log('ThemeSwitcher: System prefers dark theme:', isDark);
        return isDark ? 'dark' : 'light';
    }

    // Установка темы
    setTheme(theme) {
        console.log('ThemeSwitcher: Setting theme to:', theme);
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        
        if (this.themeSwitch) {
            this.themeSwitch.classList.toggle('active', theme === 'dark');
            console.log('ThemeSwitcher: Switch active state:', theme === 'dark');
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
        console.log('ThemeSwitcher: Animating icons, found:', icons.length);
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
        console.log('ThemeSwitcher: Current theme:', currentTheme);
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        console.log('ThemeSwitcher: Switching to:', newTheme);
        this.setTheme(newTheme);
        this.animateIcons();
    }

    // Инициализация
    init() {
        console.log('ThemeSwitcher: Starting initialization');
        // Установка начальной темы
        const savedTheme = localStorage.getItem('theme') || this.getPreferredTheme();
        console.log('ThemeSwitcher: Saved/default theme:', savedTheme);
        this.setTheme(savedTheme);

        if (this.themeSwitch) {
            // Установка начального состояния переключателя
            this.themeSwitch.classList.toggle('active', savedTheme === 'dark');
            
            // Обработчик клика
            this.themeSwitch.addEventListener('click', () => {
                console.log('ThemeSwitcher: Switch clicked');
                this.handleThemeSwitch();
            });

            // Доступность с клавиатуры
            this.themeSwitch.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    console.log('ThemeSwitcher: Switch activated by keyboard');
                    e.preventDefault();
                    this.handleThemeSwitch();
                }
            });
        }

        // Следим за системными настройками
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            console.log('ThemeSwitcher: System theme changed:', e.matches ? 'dark' : 'light');
            if (!localStorage.getItem('theme')) {
                this.setTheme(e.matches ? 'dark' : 'light');
            }
        });
        
        console.log('ThemeSwitcher: Initialization complete');
    }
}

// Инициализация после загрузки DOM
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing ThemeSwitcher');
    new ThemeSwitcher();
}); 