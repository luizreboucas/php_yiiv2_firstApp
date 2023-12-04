<?php
    namespace app\controllers;
    use yii\web\Controller;

    class HelloController extends Controller
    {
        function actionIndex()
        {
            echo json_encode(array(
                'message' => 'hello World'
            ));
        }
    }