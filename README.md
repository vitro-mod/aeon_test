# aeon_test
Проект с авторизацией на PHP и JS для тестового задания

- Все взаимодействия с сервером выполняются асинхронно без перезагрузки страницы с использованием Fetch API 
- Одновременная поддержка нескольких сессий реализована через GET-параметр `session`, изменяя его можно переключаться между сессиями
- Для хеширования применён SHA-256, пароли хранятся в базе с использованием "соли"
- Защита от подбора пароля реализована следующим образом: 
  - каждая неверная попытка входа записывается в БД (таблица bruteforce)
  - если за последние 5 минут количество неверных попыток с этого IP-адреса превышает 10, то авторизация останавливается, пользователю показывается ошибка
  - в случае успешной авторизации из базы удаляются записи о предыдущих неудачных попытках
- Для примера в базе есть 3 пользователя: `usertest`, `example`, `another`. Пароль совпадает с логином

Изображения для аватарок получены с помощью скрипта из этой статьи:
https://frontend.horse/articles/generative-grids/
