<?php
    namespace app\controllers;
    use yii\web\Controller;
    use app\models\Post;
    use app\models\User;
    use Yii;
    use yii\web\Response;

    class PostController extends Controller
    {
        public function actionIndex()
        {
            $posts = Post::find()->with('user')->orderBy('id')->all();
            
            $result = [];
            foreach($posts as $post)
            {
                $user = User::findOne($post->user_id);
                $item = [
                    'id'=> $post->id,
                    'content'=> $post->content,
                    'user'=>[
                        'id'=> $user->id,
                        'name'=> $user->name
                    ]
                    ];
                array_push($result, $item);
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        }
    }