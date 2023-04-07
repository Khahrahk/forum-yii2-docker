<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\CommentForm;

class COMMENTWidget extends Widget
{

    public function run()
    {
        $model = new CommentForm();
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            Yii::$app->response->redirect(['site/sectionview', 'id' => $_GET['id']]);
        }
        return $this->render('commentWidget', [
            'model' => $model,
        ]);
    }

}