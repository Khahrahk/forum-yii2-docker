<?php

/** @var yii\web\View $this */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'User';
?>
<div class="site-login row mt-4 pt-4">
<!--    <div class="col-2 border border-1 rounded-1 p-3" style="margin-right: 10px">-->
<!--        <ul class="nav nav-pills">-->
<!--            <li>--><?php //echo html::a('Моя страница', 'profile', ['class' => 'nav-link']) . '<br>'; ?><!--</li>-->
<!--            <li>--><?php //echo html::a('Друзья', 'friends', ['class' => 'nav-link']) . '<br>'; ?><!--</li>-->
<!--            <li>--><?php //echo html::a('Сообщения', '', ['class' => 'nav-link']) . '<br>'; ?><!--</li>-->
<!--            <li>--><?php //echo html::a('Мои посты', '', ['class' => 'nav-link']) . '<br>'; ?><!--</li>-->
<!--            <li>--><?php //echo html::a('Разделы', '', ['class' => 'nav-link']) . '<br>'; ?><!--</li>-->
<!--        </ul>-->
<!--    </div>-->
    <div class="col-2"></div>
    <div class="col-8">
        <div class="col-4">
            <form method="get" class="input-group" action="<?= \yii\helpers\Url::to(['site/search']) ?>">
                <input type="search" class="form-control rounded" placeholder="Введите имя" name="q" aria-label="Search"
                       aria-describedby="search-addon" width="auto"/>
                <button type="submit" class="btn btn-outline-primary">Поиск</button>
            </form>
        </div>
        <br>
        <?php
        foreach ($query as $key => $item) {
            if ($item['usertwo']['id'] == Yii::$app->user->identity->id) {
                $item_user = $item['userone'];
                $verification_one = $item['verification_one'];
                $verification_two = $item['verification_two'];

            } else {
                $item_user = $item['usertwo'];
                $verification_one = $item['verification_two'];
                $verification_two = $item['verification_one'];
            }
            ?>
            <div class="row border border-1 rounded-1 p-3">
                <div class="col-3">
                    <img src="<?php echo '/img/avatar/' . $item_user['avatar']; ?>"
                         class="rounded-3 img-thumbnail"
                         style="width: 150px;"
                         alt="Avatar"/>
                </div>
                <div class="col-3">
                    <?php
                    echo Html::a($item_user['username'], ['profileview', 'id' => $item_user['id']]);
                    ?>
                </div>
                <?php
                if ($verification_one == 1 and $verification_two == 1) {
                    echo Html::a('Удалить', ['friendsdelete', 'id' => $item_user['id']]);
                } elseif ($verification_one == 0 and $verification_two == 1) {
                    echo Html::a('Удалить заявку', ['friendsdelete', 'id' => $item_user['id']]);
                } else {
                    echo Html::a('Принять заявку', ['friendsverificate', 'id' => $item_user['id']]);
                }
                ?>
            </div>
            <br>
            <?php
        }
        ?>
    </div>

    <div class="col-2"></div>
</div>
