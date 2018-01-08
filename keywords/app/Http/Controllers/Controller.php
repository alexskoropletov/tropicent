<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

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
            "милота"
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
            "домашниеживотные"
        ]
    ];

    public function index(Request $request)
    {
        $result = [
            'tags' => [],
            'keyword' => ''
        ];
        if ($text = $request->query('text')) {
            $result['text'] = $text;
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
