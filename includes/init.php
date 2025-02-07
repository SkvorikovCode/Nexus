<?php
// Определение корневого пути
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
}

// Подключение конфигурации
require_once ROOT_PATH . '/includes/config.php'; 