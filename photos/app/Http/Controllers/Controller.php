<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Laravel\Lumen\Routing\UrlGenerator;

class Controller extends BaseController
{
    /**
     * Встроенный в Laravel генератор URL
     * @var UrlGenerator
     */
    protected $url;

    /**
     * Список доступных ключевых слов
     * Как и в остальных контроллерах массив, в случае развития проекта, можнго заменить чтением из БД или других источников
     * @var array allowed keywords
     */
    private $allowed = ['cat', 'dog'];

    /**
     * Инжектим доступ к генератору путей в конструкторе класса
     * @param UrlGenerator $url
     */
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    /**
     * Обработчик обращения к микросервису
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $result = [
            'result' => 'error',
        ];
        // Если ключевое слово присутствует в списке доступных
        if ($keyword = $this->isAllowed($request->query('keyword'))) {
            // формируем ответ
            $result = [
                'result'  => 'OK',
                'path'    => $this->url->to(sprintf('/%s/%s', $keyword, $this->getImage()))
            ];
        }

        return response()->json($result);
    }

    /**
     * Проверяет наличие ключевого слова в списке доступных
     * Если слово найдено, возвращается оно же
     * Если слово не найдено, возвращается false
     * @param $keyword
     *
     * @return string|bool
     */
    private function isAllowed($keyword)
    {
        return in_array($keyword, $this->allowed) ? $keyword : false;
    }

    /**
     * Метод возвращаем случайный файл
     * С развитием проекта может читать из файловой системы, из памяти или из БД
     * @return string
     */
    private function getImage()
    {
        return sprintf('00%d.jpg', rand(1, 8));
    }
}
