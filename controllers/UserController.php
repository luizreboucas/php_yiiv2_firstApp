<?php

    namespace app\controllers;

    use yii\web\Controller;
    use app\models\User;
    use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;

    class UserController extends Controller
    {
        function behaviors()
        {

            return [
                'verbs'=>[
                    'class'=> VerbFilter::class,
                    'actions'=>[
                        'update-user'=>['put']
                    ]
                ]
                    ];
        }

        function beforeAction($action)
        {
            if($action->id == 'create-user'){
                $this->enableCsrfValidation = false;
            }

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

        function actionUpdate($id)
        {
            return 'hello';
            $user = User::findOne($id);
            $bodyParamsJson = file_get_contents('php://input');
            $body = json_decode($bodyParamsJson);
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
    }