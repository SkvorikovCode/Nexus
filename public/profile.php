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
    
    include ROOT_PATH . '/templates/header.php';
?>

<div class="container my-4">
    <!-- Верхняя часть профиля -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img src="<?php echo asset('images/profile-placeholder.svg'); ?>" 
                         class="rounded-circle profile-avatar" 
                         alt="<?php echo htmlspecialchars($user['name']); ?>">
                </div>
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h1 class="h3 mb-0">
                            <?php echo htmlspecialchars($user['name'] . ' ' . $user['family']); ?>
                        </h1>
                        <div>
                            <a href="/edit-profile.php" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil"></i> Редактировать
                            </a>
                            <button class="btn btn-link text-dark btn-sm ms-2">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-muted mb-3">
                        <?php echo htmlspecialchars($user['email']); ?> • 500+ Connections
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Основная информация -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 mb-4">Headline</h2>
                    <p class="text-muted mb-0">
                        UX Designer | Crafting Intuitive Experiences for Seamless User Journeys | 
                        Bridging Design and Functionality for Digital Excellence ✨
                    </p>
                </div>
            </div>

            <!-- О себе -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 mb-4">About</h2>
                    <p class="text-muted mb-0">
                        Passionate and results-driven Professional with a keen eye for brand development 
                        and a penchant for blending creativity with strategic thinking. Experienced in 
                        delivering impactful solutions that drive engagement and business growth.
                    </p>
                </div>
            </div>

            <!-- Опыт работы -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 mb-4">Works as</h2>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="<?php echo asset('images/company-placeholder.svg'); ?>" class="rounded" alt="Company Logo">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="h6 mb-1">Product Designer</h3>
                            <p class="text-muted small mb-0">@ Apple</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Местоположение -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-geo-alt text-muted me-2"></i>
                        <span><?php echo htmlspecialchars($user['phone']); ?></span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar text-muted me-2"></i>
                        <span>Joined <?php echo date('F Y', strtotime($user['age'])); ?></span>
                    </div>
                </div>
            </div>

            <!-- Достижения -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 mb-4">Spaces Joined</h2>
                    
                    <!-- Достижение -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="achievement-badge">
                                <img src="<?php echo asset('images/badge-placeholder.svg'); ?>" class="rounded" alt="Badge">
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="h6 mb-1">Writer of the Month</h3>
                            <p class="text-muted small mb-0">UX Rescues • Member since July '22</p>
                        </div>
                        <button class="btn btn-link text-dark btn-sm">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                    <!-- Достижение -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="achievement-badge">
                                <img src="<?php echo asset('images/badge-placeholder.svg'); ?>" class="rounded" alt="Badge">
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="h6 mb-1">Top Contributor</h3>
                            <p class="text-muted small mb-0">Fitness Folks • Member since July '22</p>
                        </div>
                        <button class="btn btn-link text-dark btn-sm">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                    <!-- Достижение -->
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="achievement-badge">
                                <img src="<?php echo asset('images/badge-placeholder.svg'); ?>" class="rounded" alt="Badge">
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="h6 mb-1">Active Member</h3>
                            <p class="text-muted small mb-0">Wanderlust • Member since Oct '23</p>
                        </div>
                        <button class="btn btn-link text-dark btn-sm">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
} catch(PDOException $e) {
    die("Ошибка базы данных: " . $e->getMessage());
}

include ROOT_PATH . '/templates/footer.php'; 
?> 