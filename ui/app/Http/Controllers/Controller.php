<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Рисуем интерфейс из шаблона на Blade
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('index');
    }
}
