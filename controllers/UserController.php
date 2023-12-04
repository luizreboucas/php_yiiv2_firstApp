<?php

    namespace app\controllers;

    use yii\web\Controller;
    use app\models\User;
    use Yii;
    use yii\web\Response;

    class UserController extends Controller
    {
        function actionIndex()
        {
            $users = User::find()->orderBy('id')->all();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $users;

        }
    }