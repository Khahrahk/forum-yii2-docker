<?php

/** @var yii\web\View $this */

use app\models\Groups;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Profile';
?>
<div class="site-login row mt-4 pt-4">
    <div class="col-2 border border-1 rounded-1 p-3" style="margin-right: 10px">
        <ul class="nav nav-pills">
            <li><?php echo html::a('Моя страница', '', ['class' => 'nav-link']).'<br>'; ?></li>
            <li><?php echo html::a('Друзья', 'friends', ['class' => 'nav-link']).'<br>'; ?></li>
            <li><?php echo html::a('Сообщения', '', ['class' => 'nav-link']).'<br>'; ?></li>
            <li><?php echo html::a('Мои посты', '', ['class' => 'nav-link']).'<br>'; ?></li>
            <li><?php echo html::a('Разделы', '', ['class' => 'nav-link']).'<br>'; ?></li>
        </ul>

    </div>
    <div class="col-8">
        <div class="row border border-1 rounded-1 p-3">
            <div class="col-3">
                <img src="<?php echo '/img/avatar/' . Yii::$app->user->identity->avatar; ?>"
                     class="rounded-3 img-thumbnail"
                     style="width: 150px;"
                     alt="Avatar"/>
                <div class="btn btn-light btn-rounded" style="width: 80%">
                    <label class="form-label text-black" for="customFile2">Выберите файл</label>
                    <input type="file" class="form-control d-none" id="customFile2" onchange="submit()"/>
                </div>
            </div>
            <div class="col-3">
                <h5><?= Yii::$app->user->identity->username;?></h5>
            </div>
        </div>
    </div>
    <div class="col-2"></div>
</div>

