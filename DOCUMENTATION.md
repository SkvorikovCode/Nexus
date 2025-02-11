# Документация проекта Nexus

## Оглавление
1. [Общая информация](#общая-информация)
2. [Структура проекта](#структура-проекта)
3. [База данных](#база-данных)
4. [Аутентификация](#аутентификация)
5. [Интерфейс](#интерфейс)
6. [Темы оформления](#темы-оформления)
7. [Инструкции по установке](#инструкции-по-установке)

## Общая информация

Nexus - это социальная сеть, разработанная на PHP с использованием современных технологий и практик веб-разработки.

### Технологический стек
- PHP 7.4+
- MySQL/MariaDB
- HTML5/CSS3
- Bootstrap 5.3.0
- JavaScript (vanilla)

## Структура проекта

```
project/
├── assets/
│   ├── css/
│   │   ├── styles.css
│   │   └── nexus.sql
│   └── js/
├── includes/
│   ├── config.php
│   └── init.php
├── public/
│   ├── index.php
│   ├── profile.php
│   ├── login.php
│   ├── register.php
│   └── auth/
│       ├── login.php
│       └── register.php
└── templates/
    ├── header.php
    └── footer.php
```

## База данных

### Таблица users
```sql
CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(110) NOT NULL,
  family varchar(110) NOT NULL,
  age date NOT NULL,
  phone varchar(20) NOT NULL,
  email varchar(150) NOT NULL,
  pass varchar(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY email (email)
)
```

## Аутентификация

### Регистрация
- Валидация email
- Хеширование паролей
- Проверка уникальности email
- Маска для телефона
- Обработка ошибок

### Авторизация
- Сессии
- Remember me функционал
- Защита от SQL-инъекций
- PDO подключение

## Интерфейс

### Основные компоненты
1. **Навигация**
   - Профиль
   - Новости
   - Сообщения
   - Друзья
   - Поиск
   - Переключатель темы

2. **Лента новостей**
   - Stories
   - Создание постов
   - Лайки и комментарии
   - Рекомендации

3. **Профиль**
   - Основная информация
   - Статистика
   - Достижения
   - Редактирование

## Темы оформления

### Система тем
- Автоопределение системной темы
- Сохранение выбора в localStorage
- Плавные переходы

### Цветовые схемы

#### Светлая тема
```css
:root {
    --primary-color: #4f46e5;
    --background-color: #f1f5f9;
    --card-background: #ffffff;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
}
```

#### Темная тема
```css
[data-theme="dark"] {
    --primary-color: #818cf8;
    --background-color: #1e1e2d;
    --card-background: #2a2a3c;
    --text-primary: #e2e8f0;
    --text-secondary: #94a3b8;
}
```

### Компоненты тем
- Адаптивные цвета фона
- Настраиваемые тени
- Кастомный скроллбар
- Анимированный переключатель

## Инструкции по установке

1. **Клонирование репозитория**
   ```bash
   git clone [repository-url]
   cd nexus
   ```

2. **Настройка базы данных**
   - Создать базу данных MySQL
   - Импортировать `assets/css/nexus.sql`
   - Настроить параметры в `includes/config.php`

3. **Конфигурация сервера**
   - PHP 7.4+
   - MySQL/MariaDB
   - Apache/Nginx
   - mod_rewrite включен

4. **Настройка окружения**
   ```php
   // includes/config.php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'nexus');
   ```

## Заметки по разработке

### Безопасность
- Все пароли хешируются
- Подготовленные запросы PDO
- Валидация входных данных
- XSS защита
- CSRF токены

### Оптимизация
- Кэширование тем
- Ленивая загрузка изображений
- Минимизация запросов к БД
- Оптимизация изображений

### TODO
- [ ] Реализация системы сообщений
- [ ] Добавление уведомлений
- [ ] Улучшение мобильной версии
- [ ] Добавление поиска
- [ ] Система хештегов

### Известные проблемы
1. Необходимо добавить обработку ошибок загрузки изображений
2. Улучшить валидацию форм на клиентской стороне
3. Добавить прогрессивную загрузку ленты

## Поддержка

По вопросам поддержки обращаться:
- Email: support@nexus.com
- GitHub Issues
- Telegram: @nexus_support 