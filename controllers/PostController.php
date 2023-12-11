<?php
    namespace app\controllers;
    use yii\web\Controller;
    use app\models\Post;
    use app\models\User;
    use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;

    class PostController extends Controller
    {
        public function beforeAction($action)
        {
            $this->enableCsrfValidation = false;
            return parent::beforeAction($action);
        }

        public function behaviors()
        {
            return [
                'verbs'=> [
                    'class'=> VerbFilter::class,
                    'actions'=> [
                        'create-post'=> ['post'],
                        'update-post'=> ['put']
                    ]
                ]
            ];
        }
        

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

        public function actionGetPost($id)
        {
            $post = Post::findOne($id);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'id' => $post->id,
                'content'=> $post->content,
                'user' => User::findOne($post->user_id)
            ];
        }

        public function actionCreatePost()
        {
            $requestJson = file_get_contents('php://input');
            $body = json_decode($requestJson);
            $post = new Post();
            $post->content = $body->content;
            $post->user_id = $body->user;
            $post->save();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'message' => 'post criado',
                'post' => $post
            ];      
        }

        public function actionUpdatePost($id)
        {
            $post = Post::findOne($id);
            $requestBodyJson = file_get_contents('php://input');
            $requestBody = json_decode($requestBodyJson);
            if(isset($requestBody->content))
            {
                $post->content = $requestBody->content;
                $post->save();
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'message'=> 'post atualizado com sucesso!',
                'post' => $post
            ];
        }

        public function actionDeletePost($id)
        {
            $post = Post::findOne($id);
            $post->delete();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'message' => 'post deletado com sucesso!',
                'post' => $post
            ];
        }
        
    }