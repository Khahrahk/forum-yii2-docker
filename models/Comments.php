<?php

namespace app\models;

use yii\db\ActiveRecord;

class Comments extends ActiveRecord
{

    public static function tableName()
    {
        return 'comments';
    }

    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    public function getUsercomments()
    {
        return $this->hasMany(User::className(), ['id' => 'userId'])->via('comments');
    }

    public function getPosts()
    {
        return $this->hasOne(Posts::className(), ['id' => 'postId']);
    }

}