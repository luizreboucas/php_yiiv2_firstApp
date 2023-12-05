<?php

    namespace app\models;
    use yii\db\ActiveRecord;

    class Post extends ActiveRecord
    {
        public function getUser()
        {
            return $this->hasOne(User::class, ['id'=> 'user_id']);
        }
    }