<?php

namespace app\models;

use yii\db\ActiveRecord;


class Friends extends ActiveRecord
{

    /**
     * @var mixed|null
     */

    public static function tableName()
    {
        return 'friends';
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'friend_two', 'id' => 'friend_one']);
    }
}