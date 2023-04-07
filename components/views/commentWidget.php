<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

?>

<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')) { ?>

    <?php
    $this->registerJs(
        "$('#myModalSendOk').modal('show');",
        yii\web\View::POS_READY
    );
    ?>

<?php } ?>

<div class="modal fade" id="myComment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Создание поста</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?= $form->field($model, 'header') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <?= Html::submitButton('Создать', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>