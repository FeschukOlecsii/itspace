## Для того щоб запустити проект потрібно:
# 1. cd your/project/path
# 2. docker-compose up -d --build
# 3.docker-compose exec app composer install
# 4.docker-compose exec app php artisan migrate
# (Якщо пише що немає файлів для міграції то: docker-compose exec app php artisan migrate:refresh )   
# 5.npm i
# 6.npm run dev
# Викликати work
# 7.docker exec -it project_app bash
# 8.php artisan queue:work
