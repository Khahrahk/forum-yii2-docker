<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string friend_one
 * @property string friend_two
 * @property string verification_one
 * @property string verification_two
 */

class Friends extends ActiveRecord
{

    public static function tableName()
    {
        return 'friends';
    }

    public function getUserone()
    {
        return $this->hasOne(User::className(), ['id' => 'friend_one']);
    }

    public function getUsertwo()
    {
        return $this->hasOne(User::className(), ['id' => 'friend_two']);
    }

    public function create($id){
        if(!$this->validate()){
            return null;
        }
        $post = new Friends();
        $post->friend_one = $id;
        $post->friend_two = Yii::$app->user->identity->id;
        $post->verification_one = 0;
        $post->verification_two = 1;
        return $post->save()  ? true : null;
    }

    public function friendUpdate($id){
        if(!$this->validate()){
            return null;
        }
        $post = Friends::find()->where(['friend_one' => $id])->orWhere(['friend_two' => $id])
            ->andWhere(['friend_two' => Yii::$app->user->identity->id])->orWhere(['friend_one' => Yii::$app->user->identity->id])->one();
        $post->friend_one = $id;
        $post->friend_two = Yii::$app->user->identity->id;
        $post->verification_one = 1;
        $post->verification_two = 1;
        return $post->save()  ? true : null;
    }
}