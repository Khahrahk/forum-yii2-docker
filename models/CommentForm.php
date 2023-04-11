<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read Posts|null $comment
 *
 */

class CommentForm extends Model
{
    public $text;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['text'], 'required'],
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
            'text' => 'Текст',
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
        $comment = new Comments();
        $comment->userId = Yii::$app->user->identity->id;
        $comment->postId = Yii::$app->request->get('id');
        $comment->text = $this->text;

        return $comment->save()  ? true : null;
    }
}