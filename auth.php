<?php

namespace app\commands\cron;

use Yii;
use yii\console\Controller;

class AuthController extends Controller
{
    public function actionGetToken($login, $password)
    {
        // Проверка логина и пароля
        if ($login === 'admin' && $password === 'password') {
            // Генерация токена
            $token = Yii::$app->security->generateRandomString();
            
            // Установка времени действия токена на 5 минут
            $expirationTime = time() + 300;
            
            // Сохранение токена в базе данных или другом хранилище
            
            // Возвращение токена
            return $token;
        } else {
            // Обработка ошибки авторизации
            return 'Ошибка авторизации';
        }
    }
}
