$(function() {
    /**
     * Когда юзер засабмиттил форму
     */
    $('#article-helper').on('submit', function() {
        // прячем кнопку, чтобы не отправлять миллион одинаковых запросов
        $('.submit-button').hide();
        // шлём запрос на контроллер ApiGateway
        $.get('/api/keywords', {text: $('#article').val()}, function(data) {
            // Если всё ОК
            if (data.result == 'OK') {
                // формируем html-список тегов
                var tags = [];
                data.keywords.tags.forEach(function(item) {
                    tags.push(
                        '<li class="list-group-item">'
                        + '<div class="checkbox">'
                        + '<label><input type="checkbox"> '
                        + item
                        + '</label>'
                        + '</div>'
                        + '</li>'
                    );
                });
                $('#tags').html(tags.join(''));
                // если в ответе есть информация о фото (а она есть, иначе data.result не будет OK)
                if (data.photo.result == 'OK') {
                    // показываем картинку и сохраняем её ключевое слово
                    showPhoto(data.photo.path, data.keywords.keyword);
                }
            }
            // вне зависимости от ответа показываем кнопку отправки формы
            $('.submit-button').show();
        }, 'json');
        // на самом деле не отправляем форму никуда
        return false;
    });
});

/**
 * Функция отображения картинки
 * @param path
 * @param keyword
 */
function showPhoto(path, keyword) {
    $('#photo').html(
        '<li class="list-group-item">'
        + '<img src="'
        + path
        + '" class="img-responsive img-rounded photo" data-keyword="'
        + keyword
        + '">'
        + '<p class="help-block">Чтобы изменить изображение - кликните по нему</p>'
        + '</li>'
    );
    // после того как фотка показана, вешаем на нее слушатель события click
    photoEvent();
}

/**
 * Функция, которая вешает обработчик события click на фотку
 */
function photoEvent() {
    // на всякий случай снимаем все предыдущие обработчики, чтобы не сработал каскад вызовов
    $('.photo').off('click').on('click', function() {
        // прячем картинку, чтобы с "эффектом эпилептика" не отправить миллион одинаковых запросов
        $(this).hide();
        var keyword = $(this).data('keyword');
        // шлём запрос на ApiGateway, чтобы по ключевому слову получить рандомную картинку
        $.get('/api/photos', {keyword: keyword}, function(data) {
             if (data.result == 'OK') {
                 // показываем новую фотку
                showPhoto(data.response.path, keyword);
            }
        }, 'json');
    });
}