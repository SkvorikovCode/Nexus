<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
require_once ROOT_PATH . '/includes/config.php';
include ROOT_PATH . '/templates/header.php';
?>

<main class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <h1>Добро пожаловать</h1>
            <p class="lead">Это базовый PHP шаблон для вашего проекта.</p>
            
            <?php
            // Пример работы с базой данных
            try {
                $db = getDB();
                // Здесь можно добавить код для работы с БД
            } catch(PDOException $e) {
                echo '<div class="alert alert-danger">Ошибка подключения к базе данных</div>';
            }
            ?>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Боковая панель</h5>
                    <p class="card-text">Здесь может быть дополнительная информация.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include ROOT_PATH . '/templates/footer.php'; ?> 