<?php

    namespace app\controllers;

    use yii\web\Controller;
    use app\models\User;
    use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;

    class UserController extends Controller
    {

        function beforeAction($action)
        {
            
            $this->enableCsrfValidation = false;
            

            return parent::beforeAction($action);
        }

        function actionIndex()
        {
            $users = User::find()->orderBy('id')->all();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $users;

        }

        function actionCreateUser()
        {
            $user = new User;
            $bodyJson = file_get_contents('php://input');
            $body = json_decode($bodyJson, true);
            $user->name = $body['name'];
            $user->password = $body['password'];
            $user->save();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $user;
        }

        function actionGetUser($id)
        {
            $user = User::findOne($id);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $user;
        }

        function actionUpdateUser($id)
        {
            
            $user = User::findOne($id);
            $bodyParamsJson = file_get_contents('php://input');
            $body = json_decode($bodyParamsJson, true);
            if(isset($body['name'])){
                $user->name = $body['name'];
            }
            if(isset($body['password'])){
                $user->password = $body['password'];
            }
            $user->save();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $user;
        }

        function actionDeleteUser($id)
        {

            $user = User::findOne($id);
            $user->delete();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'message' => 'Usuário deletado',
                'usuário deletado' => $user
            ];
        }
    }