<?php

use app\models\Posts;
use yii\bootstrap5\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\CheckboxColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use app\components\COMMENTWidget;

?>
<div class="container my-2 py-2">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body p-4">
                    <h4 class="text-center mb-2 pb-1">
                        <?php
                        foreach ($query as $item) {
                            echo $item['header'];
                            break;
                        }
                        ?>
                    </h4>
                    <h4 class="text-center mb-3 pb-1">
                        <button type="button" class="btn btn-link text-nowrap" style="text-decoration: none"
                                data-bs-toggle="modal" data-bs-target="#myComment">
                            Ответить в пост
                        </button>
                    </h4>
                    <hr>
                    <?php
                    if (!empty($item['usercomments'])){
                        ?>
                        <div class="row">
                            <div class="col">
                                <div class="d-flex flex-start">
                                    <img src="<?php echo '/img/avatar/' . $item['users']['avatar'];?>" class="rounded-3" width="65" height="65"
                                         alt="Avatar"  style="margin-right: 10px;"/>
                                    <div class="flex-grow-1 flex-shrink-1">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-1">
                                                    <?php
                                                    echo $item['header'].' ';
                                                    echo Html::a($item['users']['username'], ['profileview', 'id' => $item['users']['id']]);
                                                    ?><span class="small"><?php
                                                        echo ' '.$item['created_at'].' ';?></span>
                                                </p>
                                            </div>
                                            <p class="small mb-0">
                                                <?php
                                                echo $item['body'];
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <?php
                    foreach ($item['usercomments'] as $item1 => $oof) {
                        ?>
                        <div class="row">
                            <div class="col card-header border-light" style="padding-left: 40px">
                                <div class="d-flex flex-start">
                                    <img src="<?php echo '/img/avatar/' . $oof['avatar']; ?>" class="rounded-3"
                                         width="65" height="65"
                                         alt="Avatar" style="margin-right: 10px;"/>
                                    <div class="flex-grow-1 flex-shrink-1">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-1">
                                                    <?php
                                                    echo Html::a($oof['username'], ['profileview', 'id' => $oof['id']]);
                                                    ?><span class="small"><?php
                                                        echo ' ' . $oof['created_at'] . ' '; ?></span>
                                                </p>
                                            </div>
                                            <p class="small mb-0">
                                                <?php
                                                echo $item['comments'][$item1]['text'];
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    <?php }
                    } else {
                        ?>
                        <div class="row">
                            <div class="col">
                                <div class="d-flex flex-start">
                                    <img src="<?php echo '/img/avatar/' . $item['users']['avatar'];?>" class="rounded-3" width="65" height="65"
                                         alt="Avatar"  style="margin-right: 10px;"/>
                                    <div class="flex-grow-1 flex-shrink-1">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-1">
                                                    <?php
                                                    echo $item['header'].' ';
                                                    echo Html::a($item['users']['username'], ['profileview', 'id' => $item['users']['id']]);
                                                    ?><span class="small"><?php
                                                        echo ' '.$item['created_at'].' ';?></span>
                                                </p>
                                            </div>
                                            <p class="small mb-0">
                                                <?php
                                                echo $item['body'];
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= COMMENTWidget::widget([]) ?>

