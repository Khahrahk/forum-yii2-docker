<?php

/** @var yii\web\View $this */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'User';
?>
<div class="site-login row mt-4 pt-4">
    <div class="col-8">
        <div class="row border border-1 rounded-1 p-3">
            <div class="col-3">
                <img src="<?php echo '/img/avatar/' . $query['avatar']; ?>"
                     class="rounded-3 img-thumbnail"
                     style="width: 150px;"
                     alt="Avatar"/>
            </div>
            <div class="col-3">
                <h5><?php echo $query['username']; ?></h5>
            </div>
            <?php
            if(!empty($query['friends']) and $query['friends']['friend_one'] == $query['id']) {
                echo Html::a('Удалить', ['friendsdelete', 'id' => $query['id']]);
            } elseif($query['id'] == Yii::$app->user->identity->id) {

            }
            else {
                echo Html::a('Добавить', ['friendsadd', 'id' => $query['id']]);
            }
            ?>
        </div>
    </div>
    <div class="col-2"></div>
</div>

