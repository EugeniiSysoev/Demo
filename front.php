<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Object;

class ApiController extends Controller
{
    public function actionProcessJson()
    {
        // Получение данных в формате JSON из тела запроса
        $jsonData = Yii::$app->request->getRawBody();
        
        // Декодирование JSON-данных в ассоциативный массив
        $data = json_decode($jsonData, true);
        
        // Проверка наличия токена в заголовке запроса
        $token = Yii::$app->request->headers->get('Authorization');
        
        // Проверка токена на валидность
        if (!$this->validateToken($token)) {
          return ['error' => 'Неверный токен'];
        }
        
        // Сохранение данных в базу данных
        $object = new Object();
        $object->load($data);
        $object->save();
        
        // Получение идентификатора сохраненного объекта
        $objectId = $object->id;
        
        // Замер времени выполнения и использования памяти
        $executionTime = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
        $memoryUsage = memory_get_peak_usage(true);
        
        // Формирование ответа в формате JSON
        $response = [
            'objectId' => $objectId,
            'executionTime' => $executionTime,
            'memoryUsage' => $memoryUsage,
        ];
        
        // Отправка ответа в формате JSON
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $response;
    }
}
