<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\PostForm;

class POSTWidget extends Widget
{

    public function run()
    {
        $model = new PostForm();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($model->load(Yii::$app->request->post()) && $model->create()) {
                Yii::$app->session->setFlash('contactFormSubmitted');
                $transaction->commit();
                Yii::$app->response->redirect(['site/sectionview', 'id' => $_GET['id']]);
            }
        } catch (\Exception $e) {
            $transaction->rollback();
            Yii::$app->response->redirect(['site/sectionview', 'id' => $_GET['id']]);
        }
        return $this->render('postWidget', [
            'model' => $model,
        ]);
    }

}

