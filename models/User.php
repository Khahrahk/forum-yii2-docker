<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string username
 * @property string email
 * @property string number
 * @property string password
 * @property string authKey
 * @property string isAdmin
 * @property string avatar
 * @property string accessToken
 */

class User extends ActiveRecord implements \yii\web\IdentityInterface
{

    public static function tableName(){
        return 'users';
    }

    public function getPosts()
    {
        return $this->hasOne(Posts::className(), ['id' => 'userId']);
    }

    public function getComments()
    {
        return $this->hasOne(Comments::className(), ['id' => 'userId']);
    }

    private static $users;

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function HashPassword($password){
        $this->password=Yii::$app->security->generatePasswordHash($password);
    }
}
