<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read Posts|null $post
 *
 */

class PostForm extends Model
{
    public $header;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['header', 'body'], 'required'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'header' => 'Заголовок',
            'body' => 'Текст',
            'verifyCode' => 'Капча',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function create(){
        if(!$this->validate()){
            return null;
        }
        $post = new Posts();
        $post->userId = Yii::$app->user->identity->id;
        $post->sectionId = Yii::$app->request->get('id');;
        $post->header = $this->header;
        $post->body = $this->body;
        $post->created_at = date('Y-m-d H:i:s');

        return $post->save()  ? true : null;
    }
}