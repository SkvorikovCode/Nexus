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
            'author' => 'Анна Сидорова',
            'avatar' => 'https://via.placeholder.com/150',
            'time' => '2 часа назад',
            'image' => 'https://via.placeholder.com/600x800',
            'content' => 'Прекрасный закат сегодня! 🌅 #природа #закат #фотография',
            'likes' => 142,
            'comments' => 23
        ],
        [
            'author' => 'Максим Петров',
            'avatar' => 'https://via.placeholder.com/150',
            'time' => '5 часов назад',
            'image' => 'https://via.placeholder.com/600x600',
            'content' => 'Новый проект почти завершен! 💻 Скоро покажу результаты. #разработка #coding #webdev',
            'likes' => 89,
            'comments' => 12
        ],
        [
            'author' => 'Елена Волкова',
            'avatar' => 'https://via.placeholder.com/150',
            'time' => '8 часов назад',
            'image' => 'https://via.placeholder.com/600x900',
            'content' => 'Утренняя йога - лучшее начало дня 🧘‍♀️ #йога #здоровье #спорт',
            'likes' => 256,
            'comments' => 34
        ]
    ];
    
    include ROOT_PATH . '/templates/header.php';
?>

<main class="container py-4">
    <div class="row">
        <!-- Левая колонка - информация о пользователе -->
        <div class="col-lg-3 d-none d-lg-block">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <img src="https://via.placeholder.com/150" class="rounded-circle profile-avatar mb-3" alt="Фото профиля">
                    <h5 class="card-title"><?php echo htmlspecialchars($user['name'] . ' ' . $user['family']); ?></h5>
                    <p class="text-muted mb-3">@<?php echo strtolower(str_replace(' ', '', $user['name'])); ?></p>
                    <div class="d-flex justify-content-around mb-3">
                        <div class="text-center">
                            <h6 class="mb-0">256</h6>
                            <small class="text-muted">Постов</small>
                        </div>
                        <div class="text-center">
                            <h6 class="mb-0">1.2K</h6>
                            <small class="text-muted">Подписчиков</small>
                        </div>
                        <div class="text-center">
                            <h6 class="mb-0">890</h6>
                            <small class="text-muted">Подписок</small>
                        </div>
                    </div>
                    <a href="/profile.php" class="btn btn-outline-primary btn-sm w-100">Редактировать профиль</a>
                </div>
            </div>
        </div>

        <!-- Центральная колонка - лента новостей -->
        <div class="col-lg-6">
            <!-- Форма создания поста -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="/posts/create.php" method="POST" class="post-form">
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="">
                            <textarea class="form-control" rows="2" name="content" 
                                    placeholder="Что у вас нового?"></textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-image"></i> Фото
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-camera-video"></i> Видео
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-geo-alt"></i> Место
                                </button>
                            </div>
                            <button type="submit" class="btn btn-primary">Опубликовать</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Stories -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex overflow-auto pb-2">
                        <?php for($i = 0; $i < 6; $i++): ?>
                        <div class="text-center me-3" style="min-width: 80px;">
                            <div class="position-relative d-inline-block mb-2">
                                <img src="https://via.placeholder.com/60" 
                                     class="rounded-circle border border-3 border-primary" alt="">
                                <div class="position-absolute bottom-0 end-0">
                                    <span class="badge rounded-circle bg-primary p-1">
                                        <i class="bi bi-plus-lg"></i>
                                    </span>
                                </div>
                            </div>
                            <small class="d-block text-muted">История <?php echo $i + 1; ?></small>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <!-- Лента постов -->
            <?php foreach ($posts as $post): ?>
            <div class="card mb-4">
                <!-- Шапка поста -->
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="<?php echo $post['avatar']; ?>" 
                                 class="rounded-circle me-2" 
                                 style="width: 40px; height: 40px;" alt="">
                            <div>
                                <h6 class="mb-0"><?php echo htmlspecialchars($post['author']); ?></h6>
                                <small class="text-muted"><?php echo htmlspecialchars($post['time']); ?></small>
                            </div>
                        </div>
                        <button class="btn btn-link text-dark">
                            <i class="bi bi-three-dots"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Изображение поста -->
                <img src="<?php echo $post['image']; ?>" class="card-img-top" alt="Post image">
                
                <!-- Действия с постом -->
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <button class="btn btn-link text-dark me-3 p-0">
                                <i class="bi bi-heart"></i>
                            </button>
                            <button class="btn btn-link text-dark me-3 p-0">
                                <i class="bi bi-chat"></i>
                            </button>
                            <button class="btn btn-link text-dark p-0">
                                <i class="bi bi-share"></i>
                            </button>
                        </div>
                        <button class="btn btn-link text-dark p-0">
                            <i class="bi bi-bookmark"></i>
                        </button>
                    </div>
                    
                    <!-- Лайки и комментарии -->
                    <div class="mb-2">
                        <strong><?php echo number_format($post['likes']); ?> отметок "Нравится"</strong>
                    </div>
                    
                    <!-- Текст поста -->
                    <p class="card-text">
                        <strong class="me-2"><?php echo htmlspecialchars($post['author']); ?></strong>
                        <?php echo htmlspecialchars($post['content']); ?>
                    </p>
                    
                    <!-- Комментарии -->
                    <small class="text-muted">
                        Посмотреть все комментарии (<?php echo $post['comments']; ?>)
                    </small>
                    
                    <!-- Форма комментария -->
                    <form class="mt-3">
                        <div class="input-group">
                            <input type="text" class="form-control border-0" 
                                   placeholder="Добавить комментарий...">
                            <button class="btn btn-link text-primary" type="submit">Отправить</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Правая колонка - рекомендации -->
        <div class="col-lg-3 d-none d-lg-block">
            <!-- Рекомендации пользователей -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="mb-3">Рекомендации для вас</h6>
                    <?php for($i = 0; $i < 5; $i++): ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/40" 
                                 class="rounded-circle me-2" alt="">
                            <div>
                                <h6 class="mb-0 small">Пользователь <?php echo $i + 1; ?></h6>
                                <small class="text-muted">Рекомендовано для вас</small>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm">Подписаться</button>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Актуальные темы -->
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Актуальные темы</h6>
                    <?php 
                    $trends = ['#photography', '#webdev', '#nature', '#coding', '#travel'];
                    foreach($trends as $trend): 
                    ?>
                    <div class="mb-3">
                        <h6 class="mb-1 small"><?php echo $trend; ?></h6>
                        <small class="text-muted">1.2K постов</small>
                    </div>
                    <?php endforeach; ?>
                </div>
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