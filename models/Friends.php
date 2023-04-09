<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string friend_one
 * @property string friend_two
 */

class Friends extends ActiveRecord
{

    public static function tableName()
    {
        return 'friends';
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'friend_two', 'id' => 'friend_one']);
    }


    public function create($id){
        if(!$this->validate()){
            return null;
        }
        $post = new Friends();
        $post->friend_one = $id;
        $post->friend_two = Yii::$app->user->identity->id;

        return $post->save()  ? true : null;
    }
}