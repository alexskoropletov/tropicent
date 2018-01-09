## Цель проекта:
По тексту статьи находить ключевое слово. По ключевому слову предлагать список тегов и фотографию.
Иллюстраций для каждого ключевого слова несколько, их можно листать.

### Структура проекта

#### 1) UI - интерфейс пользователя и ApiGateway
Интерфейс пользователя состоит из поля для ввода текста, списка тегов и списка иллюстраций
Содержит контроллер ApiGateway, который управляет запросами к микросервисам

###### Всё самое интересное (с комментариями) тут:
- /ui/routes/web.php
- /ui/app/Http/Controllers/Controller.php
- /ui/resources/views/index.blade.php
- /ui/public/js/app.js
- /ui/app/Http/Controllers/ApiGatewayController.php

#### 2) Keywords - определение ключевого слова и списка тегов по тексту
Микросервис возвращающий ключевое слово и список тегов для текста

###### Всё самое интересное (с комментариями) тут:
- /keywords/app/Http/Controllers/Controller.php

#### 3) Photos - случайное фото по ключевому слову
Микросервис предлагающий случайную иллюстрацию для ключевого слова  

###### Всё самое интересное (с комментариями) тут:
- /photos/app/Http/Controllers/Controller.php