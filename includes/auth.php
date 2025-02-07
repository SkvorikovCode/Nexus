<?php
// Функция для проверки авторизации
function require_auth() {
    if (!is_authenticated()) {
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
        redirect('/auth/login.php');
    }
}

// Функция для выхода
function logout() {
    session_destroy();
    redirect('/auth/login.php');
}

// Функция для проверки прав доступа
function check_permission($permission) {
    if (!is_authenticated()) {
        return false;
    }
    
    $user = current_user();
    return isset($user['permissions']) && in_array($permission, explode(',', $user['permissions']));
}

// Функция для обновления профиля
function update_profile($user_id, $data) {
    global $pdo;
    
    $allowed_fields = ['name', 'family', 'phone', 'email'];
    $updates = [];
    $values = [];
    
    foreach ($data as $field => $value) {
        if (in_array($field, $allowed_fields)) {
            $updates[] = "$field = ?";
            $values[] = $value;
        }
    }
    
    if (empty($updates)) {
        return false;
    }
    
    $values[] = $user_id;
    $sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($values);
}

// Функция для смены пароля
function change_password($user_id, $current_password, $new_password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT pass FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    
    if (!$user || !password_verify($current_password, $user['pass'])) {
        return false;
    }
    
    $stmt = $pdo->prepare("UPDATE users SET pass = ? WHERE id = ?");
    return $stmt->execute([password_hash($new_password, PASSWORD_DEFAULT), $user_id]);
}

// Функция для обновления аватара
function update_avatar($user_id, $file) {
    global $pdo;
    
    try {
        $filename = handle_image_upload($file, ROOT_PATH . '/public/uploads/avatars');
        
        $stmt = $pdo->prepare("UPDATE users SET profilePic = ? WHERE id = ?");
        if ($stmt->execute([$filename, $user_id])) {
            return $filename;
        }
        return false;
    } catch (RuntimeException $e) {
        return false;
    }
}

// Функция для получения информации о пользователе
function get_user($user_id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}

// Функция для проверки уникальности email
function is_email_unique($email, $exclude_user_id = null) {
    global $pdo;
    
    $sql = "SELECT id FROM users WHERE email = ?";
    $params = [$email];
    
    if ($exclude_user_id) {
        $sql .= " AND id != ?";
        $params[] = $exclude_user_id;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->rowCount() === 0;
}

// Функция для создания сессии пользователя
function create_user_session($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['last_activity'] = time();
}

// Функция для проверки активности сессии
function check_session_activity() {
    $timeout = 30 * 60; // 30 минут
    
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
        session_destroy();
        redirect('/auth/login.php');
    }
    
    $_SESSION['last_activity'] = time();
}

// Функция для получения URL аватарки пользователя
function get_avatar_url($user) {
    if (!$user) {
        return asset('images/default-avatar.svg');
    }
    
    if (empty($user['profilePic'])) {
        return asset('images/default-avatar.svg');
    }
    
    $avatar_path = '/uploads/avatars/' . $user['profilePic'];
    if (file_exists(ROOT_PATH . '/public' . $avatar_path)) {
        return $avatar_path;
    }
    
    return asset('images/default-avatar.svg');
} 