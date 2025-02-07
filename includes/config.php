<?php
session_start();

// Конфигурация базы данных
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'myproject');

// Настройки сайта
define('SITE_NAME', 'Мой проект');
define('BASE_URL', '/');

// Обработка ошибок
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Функция автозагрузки классов
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.php';
});

// Функция для подключения к базе данных
function getDB() {
    try {
        $db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch(PDOException $e) {
        echo "Ошибка подключения к БД: " . $e->getMessage();
        exit;
    }
} 