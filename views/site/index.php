<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

use yii\bootstrap5\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\CheckboxColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Главная';
?>
<h3 style="padding-left: 40%">Разделы</h3>
<br>
<div class="row">
    <div class='col-3'>
<?php
foreach ($model as $item) {
    echo Html::a($item->name, ['sectionview', 'id' => $item->id]);
    echo "<br>";
}
?>
    </div>
</div>