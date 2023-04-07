<?php

/** @var yii\web\View $this */

use app\models\Groups;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'User';
?>
    <div class="site-login row mt-4 pt-4">
    <div class="col-2 border border-1 rounded-1 p-3" style="margin-right: 10px">
        <ul class="nav nav-pills">
            <li><?php echo html::a('Моя страница', 'profile', ['class' => 'nav-link']).'<br>'; ?></li>
            <li><?php echo html::a('Друзья', 'friends', ['class' => 'nav-link']).'<br>'; ?></li>
            <li><?php echo html::a('Сообщения', '', ['class' => 'nav-link']).'<br>'; ?></li>
            <li><?php echo html::a('Мои посты', '', ['class' => 'nav-link']).'<br>'; ?></li>
            <li><?php echo html::a('Разделы', '', ['class' => 'nav-link']).'<br>'; ?></li>
        </ul>
    </div>
        <div class="col-8">
<?php
foreach ($query as $key => $item) {
    ?>
            <div class="row border border-1 rounded-1 p-3">
                <div class="col-3">
                    <img src="<?php echo '/img/avatar/' . $item['users'][0]['avatar']; ?>"
                         class="rounded-3 img-thumbnail"
                         style="width: 150px;"
                         alt="Avatar"/>
                </div>
                <div class="col-3">
                    <h5><?php echo $item['users'][0]['username']; ?></h5>
                </div>
            </div>
    <?php
}
?>
        </div>

        <div class="col-2"></div>
    </div>
