<?php
require_once __DIR__ . '/../includes/init.php';
include ROOT_PATH . '/templates/header.php';
?>

<main class="container my-4">
    <div class="row">
        <!-- Левая колонка - информация о пользователе -->
        <div class="col-md-3">
            <div class="card mb-3">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Фото профиля">
                <div class="card-body">
                    <h5 class="card-title">Егарка Помидарка</h5>
                    <p class="card-text text-muted">Online</p>
                    <a href="/edit-profile.php" class="btn btn-primary btn-sm w-100">Редактировать профиль</a>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Друзья</span>
                        <span class="badge bg-primary rounded-pill">42</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Фотографии</span>
                        <span class="badge bg-primary rounded-pill">128</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Видео</span>
                        <span class="badge bg-primary rounded-pill">16</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Центральная колонка - лента новостей -->
        <div class="col-md-6">
            <!-- Форма создания поста -->
            <div class="card mb-4">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <textarea class="form-control" rows="3" placeholder="Что у вас нового?"></textarea>
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
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="">
                        <div>
                            <h6 class="card-title mb-0">Денис Огромно-Членович</h6>
                            <small class="text-muted">2 часа назад</small>
                        </div>
                    </div>
                    <p class="card-text">Отличный день для программирования! Работаю над новым проектом.</p>
                    <img src="https://via.placeholder.com/600x400" class="img-fluid rounded mb-3" alt="">
                    <div class="d-flex justify-content-between">
                        <div>
                            <button class="btn btn-link text-primary p-0 me-3">
                                <i class="bi bi-heart"></i> Нравится
                            </button>
                            <button class="btn btn-link text-primary p-0">
                                <i class="bi bi-chat"></i> Комментировать
                            </button>
                        </div>
                        <small class="text-muted">42 лайка</small>
                    </div>
                </div>
            </div>
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
                                <h6 class="mb-0">Пидрелио Сидорова</h6>
                                <small class="text-muted">3 общих друга</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="">
                            <div>
                                <h6 class="mb-0">Максим Нефорович</h6>
                                <small class="text-muted">5 общих друзей</small>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="bi bi-calendar-event"></i> Upcoming Events
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

<?php include ROOT_PATH . '/templates/footer.php'; ?> 