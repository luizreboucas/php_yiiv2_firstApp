<?php

    namespace app\controllers;
    use Yii;
    use yii\web\Controller;
    use app\models\Pais;

    class PaisesController extends Controller
    {
        public function actionIndex()
        {
            $query = Pais::find();

            $paises = $query->orderBy('nome')->all();
            Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
            return $paises;
        }
    }