<?php

namespace app\components;

use app\models\CommentForm;
use Yii;
use yii\base\Widget;
use app\models\PostForm;

class COMMENTWidget extends Widget
{

    public function run()
    {
        $model = new CommentForm();
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            Yii::$app->response->redirect(['site/postview', 'id' => $_GET['id']]);
        }
        return $this->render('commentWidget', [
            'model' => $model,
        ]);
    }

}

