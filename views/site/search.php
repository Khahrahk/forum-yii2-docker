<?php

/** @var yii\web\View $this */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'User';
?>
<div class="site-login row mt-4 pt-4">
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
        foreach ($model as $key => $item) {
            if($item['id'] == Yii::$app->user->identity->id){
                continue;
            }
            ?>
            <div class="row border border-1 rounded-1 p-3">
                <div class="col-3">
                    <img src="<?php echo '/img/avatar/' . $item['avatar']; ?>"
                         class="rounded-3 img-thumbnail"
                         style="width: 150px;"
                         alt="Avatar"/>
                </div>
                <div class="col-3">
                    <?php
                    echo Html::a($item['username'], ['profileview', 'id' => $item['id']]);
                    ?>
                </div>
            </div>
            <br>
            <?php
        }
        ?>
    </div>

    <div class="col-2"></div>
</div>
