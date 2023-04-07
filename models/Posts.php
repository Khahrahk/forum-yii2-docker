<?php

namespace app\models;

use yii\db\ActiveRecord;


class Posts extends ActiveRecord
{

    /**
     * @var mixed|null
     */

    public static function tableName()
    {
        return 'posts';
    }

    public function getSections()
    {
        return $this->hasOne(Sections::className(), ['id' => 'sectionId']);
    }

    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['postId' => 'id']);
    }

    public function getUsercomments()
    {
        return $this->hasMany(User::className(), ['id' => 'userId'])->via('comments');
    }


    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}