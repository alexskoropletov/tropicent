<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var array списки тегов для ключевых слов
     * С развитием проекта этот массив можно заменить на данные из БД
     */
    private $tags = [
        "cat" => [
            "кошка",
            "кот",
            "котик",
            "котэ",
            "котенок",
            "коты",
            "котейка",
            "котики",
            "котята",
            "кошки",
            "киса",
            "котя",
            "мимими",
            "котяра",
            "милота",
        ],
        "dog" => [
            "собака",
            "щенок",
            "собаки",
            "пес",
            "собакадругчеловека",
            "другчеловека",
            "собачка",
            "собакаулыбака",
            "моясобака",
            "песик",
            "щенки",
            "любимец",
            "собачки",
            "питомец",
            "милый",
            "домашниеживотные",
        ],
    ];

    /**
     * Обработчик обращения к микросервису
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $result = [
            'tags'    => [],
            'keyword' => '',
        ];
        // если запрос не пустой
        if ($text = mb_strtolower($request->query('text'))) {
            // проверяем наличие в тексте слов, для которых в системе есть теги
            // С развитием системы простой поиск по подстроке можно заменить более сложной системой, вплоть до ИИ,
            // которая будет сравнивать не сами слова, а значения слов и контекст
            if (strstr($text, 'кошк') != false) {
                $result['tags'] = $this->tags['cat'];
                $result['keyword'] = 'cat';
            }
            if (strstr($text, 'собак') != false) {
                $result['tags'] = $this->tags['dog'];
                $result['keyword'] = 'dog';
            }
        }

        return response()->json($result);
    }
}
