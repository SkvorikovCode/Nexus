<?php
session_start();

// Конфигурация базы данных
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Skvorg115123!');
define('DB_NAME', 'nexus');

// Настройки сайта
define('SITE_NAME', 'Nexus');
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
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch(PDOException $e) {
        die("Ошибка подключения к БД: " . $e->getMessage());
    }
}

// Функция для хеширования паролей
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Функция для проверки пароля
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
} 