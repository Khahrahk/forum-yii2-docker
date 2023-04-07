<?php

namespace app\models;

use yii\db\ActiveRecord;


class Messages extends ActiveRecord
{

    /**
     * @var mixed|null
     */

    public static function tableName()
    {
        return 'messages';
    }

    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => ['friend_one', 'friend_two']]);
    }
}