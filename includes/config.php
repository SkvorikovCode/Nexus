<?php
session_start();

// Определяем ROOT_PATH только если она еще не определена
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

// Загрузка переменных окружения из .env файла
function load_env() {
    $env_file = ROOT_PATH . '/.env';
    if (file_exists($env_file)) {
        $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                if (!empty($key)) {
                    putenv("$key=$value");
                    $_ENV[$key] = $value;
                }
            }
        }
    }
}

// Загружаем переменные окружения
load_env();

// Конфигурация базы данных
$db_config = [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'dbname' => getenv('DB_NAME') ?: 'nexus',
    'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
    'user' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASS') ?: ''
];

try {
    $pdo = new PDO(
        "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset={$db_config['charset']}",
        $db_config['user'],
        $db_config['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$db_config['charset']}"
        ]
    );
} catch (PDOException $e) {
    // Более безопасный вывод ошибки
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        die('Ошибка подключения к базе данных: Неверные учетные данные. Проверьте имя пользователя и пароль в файле .env');
    } else {
        die('Ошибка подключения к базе данных. Пожалуйста, проверьте конфигурацию в файле .env');
    }
}

// Функции для работы с путями
function asset($path) {
    return '/assets/' . ltrim($path, '/');
}

function url($path) {
    return '/' . ltrim($path, '/');
}

// Функция для безопасного вывода
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Функция для генерации CSRF токена
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Функция для проверки CSRF токена
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Функция для редиректа
function redirect($path) {
    header('Location: ' . url($path));
    exit;
}

// Функция для проверки авторизации
function is_authenticated() {
    return isset($_SESSION['user_id']);
}

// Функция для получения текущего пользователя
function current_user() {
    if (!is_authenticated()) {
        return null;
    }
    
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

// Функция для форматирования даты
function format_date($date, $format = 'd.m.Y') {
    return date($format, strtotime($date));
}

// Функция для обработки загрузки изображений
function handle_image_upload($file, $destination_path) {
    if (!isset($file['error']) || is_array($file['error'])) {
        throw new RuntimeException('Invalid parameters.');
    }

    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    if ($file['size'] > 5242880) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file['tmp_name']);

    $allowed_types = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif'
    ];

    if (!array_key_exists($mime_type, $allowed_types)) {
        throw new RuntimeException('Invalid file format.');
    }

    $extension = $allowed_types[$mime_type];
    $filename = sprintf('%s.%s', sha1_file($file['tmp_name']), $extension);
    $filepath = sprintf('%s/%s', $destination_path, $filename);

    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    return $filename;
} 