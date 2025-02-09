# Nexus - Социальная сеть для творческих людей

![Nexus Logo](public/assets/images/logo.svg)

Nexus - это современная социальная платформа, разработанная для объединения творческих людей. Проект создан с использованием PHP, MySQL и современных веб-технологий.

## 🚀 Возможности

- 👤 Система аутентификации и авторизации
- 📝 Создание и редактирование профиля
- 📱 Адаптивный дизайн (mobile-first)
- 📸 Публикация постов с изображениями
- 💬 Комментарии и лайки
- 🔍 Поиск пользователей и контента
- 📊 Статистика активности
- 🌙 Темная/светлая тема

## 🛠 Технологии

- PHP 8.2+
- MySQL 8.0+
- HTML5/CSS3
- Bootstrap 5
- JavaScript
- SVG для изображений-заглушек

## 📋 Требования

- PHP >= 8.2
- MySQL >= 8.0
- Apache/Nginx
- Composer
- mod_rewrite включен (для Apache)

## 🔧 Установка

1. Клонируйте репозиторий:
```bash
git clone https://github.com/yourusername/nexus.git
cd nexus
```

2. Создайте базу данных и импортируйте структуру:
```bash
mysql -u root -p
CREATE DATABASE nexus;
exit;
mysql -u root -p nexus < database/nexus.sql
```

3. Скопируйте файл конфигурации:
```bash
cp .env.example .env
```

4. Настройте файл `.env`:
```env
DB_HOST=localhost
DB_NAME=nexus
DB_USER=your_username
DB_PASS=your_password
DB_CHARSET=utf8mb4
```

5. Запустите локальный сервер:
```bash
cd public
php -S localhost:8000
```

## 📁 Структура проекта

```
nexus/
├── database/           # SQL файлы и миграции
├── includes/           # PHP включения
│   ├── auth.php       # Аутентификация
│   ├── config.php     # Конфигурация
│   └── init.php       # Инициализация
├── public/            # Публичная директория
│   ├── assets/        # Статические файлы
│   │   ├── css/      # Стили
│   │   ├── js/       # JavaScript
│   │   └── images/   # Изображения
│   └── index.php     # Точка входа
└── templates/         # Шаблоны
```

## 🔐 Безопасность

- Защита от SQL-инъекций через PDO
- XSS защита
- CSRF токены
- Безопасное хранение паролей
- Валидация данных

## 🤝 Вклад в проект

1. Форкните репозиторий
2. Создайте ветку для фичи (`git checkout -b feature/amazing`)
3. Зафиксируйте изменения (`git commit -m 'Add amazing feature'`)
4. Отправьте изменения (`git push origin feature/amazing`)
5. Создайте Pull Request

## 📝 Лицензия

MIT License. См. файл [LICENSE](LICENSE) для деталей.

## 👥 Авторы

- [Ваше Имя](https://github.com/yourusername)

## 📞 Поддержка

Если у вас возникли вопросы или проблемы, создайте [issue](https://github.com/yourusername/nexus/issues) в репозитории.
