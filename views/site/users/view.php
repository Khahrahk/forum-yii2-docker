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

            if($query['username'] == Yii::$app->user->identity->username){

            } else {
                if (!empty($query_friend['friend_two'])) {
                    if ($query_friend['friend_two'] == Yii::$app->user->identity->id) {
                        $query_friend_ver_one = $query_friend['verification_one'];
                        $query_friend_ver_two = $query_friend['verification_two'];
                    } else {
                        $query_friend_ver_one = $query_friend['verification_two'];
                        $query_friend_ver_two = $query_friend['verification_one'];
                    }
                    if ($query_friend_ver_one == 1 and $query_friend_ver_two == 1) {
                        echo Html::a('Удалить', ['friendsdelete', 'id' => $query['id']]);
                    } elseif ($query_friend_ver_two == 0 and $query_friend_ver_one == 1) {
                        echo Html::a('Принять заявку', ['friendsverificate', 'id' => $query['id']]);
                    } else {
                        echo Html::a('Удалить заявку', ['friendsdelete', 'id' => $query['id']]);
                    }
                } elseif (!empty($query['friendone'])) {
                    $query_friend = $query['friendone'];
                    if ($query_friend['friend_one'] == Yii::$app->user->identity->id) {
                        $query_friend_ver_one = $query_friend['verification_two'];
                        $query_friend_ver_two = $query_friend['verification_one'];
                    } else {
                        $query_friend_ver_one = $query_friend['verification_one'];
                        $query_friend_ver_two = $query_friend['verification_two'];
                    }
                    if ($query_friend['verification_one'] == 1 and $query_friend_ver_two == 1) {
                        echo Html::a('Удалить', ['friendsdelete', 'id' => $query['id']]);
                    } elseif ($query_friend_ver_two == 0 and $query_friend_ver_one == 1) {
                        echo Html::a('Принять заявку', ['friendsverificate', 'id' => $query['id']]);
                    } else {
                        echo Html::a('Удалить заявку', ['friendsdelete', 'id' => $query['id']]);
                    }
                } else {
                    echo Html::a('Добавить', ['friendsadd', 'id' => $query['id']]);
                }
            }
            ?>
        </div>
    </div>
    <div class="col-2"></div>
</div>

<!--if (!empty($query['friends'])){-->
<!--$query_friend = $query['friends'];-->
<!--if($query_friend['friend_one'] == Yii::$app->user->identity->id){-->
<!--$query_friend_ver_one = $query_friend['verification_two'];-->
<!--$query_friend_ver_two = $query_friend['verification_one'];-->
<!--} else {-->
<!--$query_friend_ver_one = $query_friend['verification_one'];-->
<!--$query_friend_ver_two = $query_friend['verification_two'];-->
<!--}-->
<!--if($query_friend['verification_one'] == 1 and $query_friend_ver_two == 1) {-->
<!--echo Html::a('Удалить', ['friendsdelete', 'id' => $query['id']]);-->
<!--}-->
<!--elseif ($query_friend_ver_two == 0 and $query_friend_ver_one == 1) {-->
<!--echo Html::a('Принять заявку', ['friendsverificate', 'id' => $query['id']]);-->
<!--print_r($query_friend);-->
<!--}-->
<!--else {-->
<!--echo Html::a('Удалить заявку', ['friendsdelete', 'id' => $query['id']]);-->
<!--}-->
<!--} else {-->
<!--echo Html::a('Добавить', ['friendsadd', 'id' => $query['id']]);-->
<!--}-->