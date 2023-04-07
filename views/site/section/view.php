<?php
/**
 * @var \yii\data\Pagination $pagination
 */
use app\models\Posts;
use yii\bootstrap5\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\CheckboxColumn;
use yii\grid\GridView;
use yii\helpers\Html;

?>
<div class="container my-2 py-2">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body p-4">
                    <h4 class="text-center mb-2 pb-1">
                        <?php
                        foreach ($query_posts as $item) {
                            echo $item['sections']['name'];
                            break;
                        }
                        ?>
                    </h4>
                    <h4 class="text-center mb-3 pb-1">
                        <button type="button" class="btn btn-link text-nowrap" style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#myModal">
                            Создать пост
                        </button>
                    </h4>
                    <hr>
                    <div class="row">
                        <div>
                            Сгруппировать по: <?php echo $sort->link('header') . ' | ' . $sort->link('created_at'); ?>
                        </div>
                    </div>
                    <br>
                    <?php foreach ($query_posts as $item) {
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
                                                    <?php echo Html::a('Ответ', ['postview', 'id' => $item['id']]); ?>
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
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
            <?php
            echo \yii\widgets\LinkPager::widget([
                'pagination' => $pagination,
                'hideOnSinglePage' => true,
                'prevPageLabel' => '&laquo; назад',
                'nextPageLabel' => 'далее &raquo;',
                'maxButtonCount' => 3,

                // Настройки контейнера пагинации
                'options' => [
                    'tag' => 'nav',
                    'class' => 'pagination',
                    'id' => 'pager-container',
                ],

                // Настройки классов css для ссылок
                'linkOptions' => ['class' => 'page-link'],
                'activePageCssClass' => 'active',
                'disabledPageCssClass' => 'page-link',
            ])
            ?>
        </div>
        <div class="col-4"></div>
    </div>
</div>