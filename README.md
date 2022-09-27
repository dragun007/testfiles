<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <br>
</p>


Запустить
composer install

php yii init

Настроить в common/config/main-local.php бд

запустить 
php yii migrate
php yii migrate --migrationPath=@yii/rbac/migrations

После создания юзера дернуть ручку с его айди, чтобы он стал админом:
php yii rbac/init -id=1
