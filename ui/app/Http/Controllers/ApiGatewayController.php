<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;

class ApiGatewayController extends Controller
{
    /**
     * Список доступных микросервисов и их адреса
     * @var array microservices urls
     */
    private $routes = [];

    /**
     * В конструкторе заполняем список доступных микросервисов из данных окружения
     * При развитии проекта можно переменные заменить чтением из базы
     */
    public function __construct()
    {
        $this->routes['keywords'] = env('API_URL_KEYWORDS');
        $this->routes['photos'] = env('API_URL_PHOTOS');
    }

    /**
     * Обработчик обращения к api по поиску тегов и ключевого слова
     * Напрямую обращается к микросервису подбора фото по ключевому слову,
     * чтобы сократить время ответа, по сравнению с временем когда ключевое слово возвращалось бы
     * на фронт, а потом с фронта запрос уходил бы в микросервис
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse|string
     */
    public function keywords(Request $request)
    {
        // по-умолчанию - всё плохо
        $response = [
            'result' => 'error'
        ];
        // получаем ключевое слово и теги
        $keywords = $this->getApiResponse('keywords', $request->query());
        // если ответ ОК и ключевое слово получено
        if($keywords['result'] == 'OK' && !empty($keywords['response']['keyword'])) {
            $response['keywords'] = $keywords['response'];
            // пытаемся получить фото для ключевого слова
            $photo = $this->photos(new Request(['keyword' => $keywords['response']['keyword']]));
            // если ответ ОК и путь к фото получен
            if($photo['result'] == 'OK' && !empty($photo['response']['path'])) {
                // говорим что в общем всё отработало нормально
                $response['result'] = 'OK';
                $response['photo'] = $photo['response'];
            }
        }
        // независимо от результата возвращаем JSON
        return response()->json($response);
    }

    /**
     * Обработчик обращения к api по подбору случайного фото
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse|string
     */
    public function photos(Request $request)
    {
        return $this->getApiResponse('photos', $request->query());
    }

    /**
     * Универсальный метод отправки запроса на микросервис
     * @param string $route
     * @param array $data
     *
     * @return array|\Illuminate\Http\JsonResponse|string
     */
    private function getApiResponse($route, $data)
    {
        // по-умолчанию - всё плохо
        $response = ['result' => 'error'];
        // если роута нет в списке доступных, сразу возвращаем ответ
        if (empty($this->routes[$route])) {
            return $response;
        }
        // так как микросервисы могут работать или не работать, оборачиваем обращение к внешнему серваку в try / catch
        try {
            // отправляем GET запрос
            $remote = file_get_contents($this->getQuery(
                $this->routes[$route],
                $data
            ));
            // формируем ответ
            $response['result'] = 'OK';
            $response['response'] = json_decode($remote, true);
        } catch (\Exception $e) {
            Log::error('Whoops!');
        }

        return $response;
    }

    /**
     * Метод, формирующий URL для GET-запроса к микросервису
     * Наверное можно было бы найти аналог в компонентах Laravel, но можно и самому написать
     * @param string $url
     * @param array $data
     *
     * @return string
     */
    private function getQuery($url, $data)
    {
        $query = [];
        foreach ($data as $key => $value) {
            $query[] = sprintf('%s=%s', $key, urlencode($value));
        }

        return $url . (empty($query) ? '' : '?' . implode('&', $query));
    }
}
