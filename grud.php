<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Object;

class ObjectController extends Controller
{
    public function actionIndex()
    {
        // Получение всех сохраненных объектов
        $objects = Object::find()->all();
        
        // Формирование массива данных для отображения
        $data = [];
        foreach ($objects as $object) {
            $data[] = [
                'id' => $object->id,
                'name' => $object->name,
                'type' => $object->type,
                'value' => $object->value,
            ];
        }
        
        // Отправка данных в формате JSON
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }
    
    public function actionView($id)
    {
        // Получение объекта по идентификатору
        $object = Object::findOne($id);
        
        // Проверка наличия объекта
        if ($object === null) {
            throw new \yii\web\NotFoundHttpException('Объект не найден.');
        }
        
        // Формирование данных для отображения
        $data = [
            'id' => $object->id,
            'name' => $object->name,
            'type' => $object->type,
            'value' => $object->value,
        ];
        
        // Отправка данных в формате JSON
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }
    
    public function actionUpdate($id)
    {
        // Получение объекта по идентификатору
        $object = Object::findOne($id);
        
        // Проверка наличия объекта
        if ($object === null) {
            throw new \yii\web\NotFoundHttpException('Объект не найден.');
        }
        
        // Обработка запроса на обновление объекта
        
        // Сохранение объекта в базе данных
        if ($object->load(Yii::$app->request->post()) && $object->save()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => $object->errors];
        }
    }
    
    public function actionDelete($id)
    {
        // Получение объекта по идентификатору
        $object = Object::findOne($id);
        
        // Проверка наличия объекта
        if ($object === null) {
            throw new \yii\web\NotFoundHttpException('Объект не найден.');
        }
        
        // Удаление объекта из базы данных
        $object->delete();
        
        return ['success' => true];
    }
}
