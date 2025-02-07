<?php
require_once __DIR__ . '/../includes/init.php';

// Проверяем авторизацию
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

try {
    $db = getDB();
    
    // Получаем данные пользователя
    $stmt = $db->prepare("
        SELECT id, name, family, email, phone, age 
        FROM users 
        WHERE id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    if (!$user) {
        session_destroy();
        header('Location: /login.php');
        exit;
    }
    
    // Получаем последние посты (пока заглушка)
    $posts = [
        [
            'author' => 'Петр Петров',
            'time' => '2 часа назад',
            'content' => 'Отличный день для программирования! Работаю над новым проектом.',
            'likes' => 42
        ]
    ];
    
    include ROOT_PATH . '/templates/header.php';
?>

<main class="container my-4">
    <div class="row">
        <!-- Левая колонка - информация о пользователе -->
        <div class="col-md-3">
            <div class="card mb-3">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Фото профиля">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($user['name'] . ' ' . $user['family']); ?></h5>
                    <p class="card-text text-muted">Online</p>
                    <a href="/edit-profile.php" class="btn btn-primary btn-sm w-100">Редактировать профиль</a>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <small class="text-muted d-block">Email:</small>
                        <?php echo htmlspecialchars($user['email']); ?>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">Телефон:</small>
                        <?php echo htmlspecialchars($user['phone']); ?>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">Дата рождения:</small>
                        <?php echo date('d.m.Y', strtotime($user['age'])); ?>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Центральная колонка - лента новостей -->
        <div class="col-md-6">
            <!-- Форма создания поста -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="/posts/create.php" method="POST" class="post-form">
                        <div class="mb-3">
                            <textarea class="form-control" rows="3" 
                                    name="content" placeholder="Что у вас нового?"></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="bi bi-image"></i> Фото
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-camera-video"></i> Видео
                                </button>
                            </div>
                            <button type="submit" class="btn btn-primary">Опубликовать</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Лента постов -->
            <?php foreach ($posts as $post): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="">
                        <div>
                            <h6 class="card-title mb-0"><?php echo htmlspecialchars($post['author']); ?></h6>
                            <small class="text-muted"><?php echo htmlspecialchars($post['time']); ?></small>
                        </div>
                    </div>
                    <p class="card-text"><?php echo htmlspecialchars($post['content']); ?></p>
                    <div class="d-flex justify-content-between">
                        <div>
                            <button class="btn btn-link text-primary p-0 me-3">
                                <i class="bi bi-heart"></i> Нравится
                            </button>
                            <button class="btn btn-link text-primary p-0">
                                <i class="bi bi-chat"></i> Комментировать
                            </button>
                        </div>
                        <small class="text-muted"><?php echo $post['likes']; ?> лайков</small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Правая колонка - рекомендации и реклама -->
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-people-fill"></i> Возможные друзья
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="">
                            <div>
                                <h6 class="mb-0">Анна Сидорова</h6>
                                <small class="text-muted">3 общих друга</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="">
                            <div>
                                <h6 class="mb-0">Максим Максимов</h6>
                                <small class="text-muted">5 общих друзей</small>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="bi bi-calendar-event"></i> Предстоящие события
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h6 class="mb-1">Встреча разработчиков</h6>
                        <small class="text-muted">
                            <i class="bi bi-clock"></i> Завтра в 19:00
                        </small>
                    </li>
                    <li class="list-group-item">
                        <h6 class="mb-1">День рождения друга</h6>
                        <small class="text-muted">
                            <i class="bi bi-clock"></i> 3 дня осталось
                        </small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</main>

<?php 
} catch(PDOException $e) {
    die("Ошибка базы данных: " . $e->getMessage());
}

include ROOT_PATH . '/templates/footer.php'; 
?> 