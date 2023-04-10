<?php

namespace app\controllers;

use app\models\Comments;
use app\models\Friends;
use app\models\PostForm;
use app\models\LoginForm;
use app\models\Posts;
use app\models\Sections;
use app\models\RegisterForm;
use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\data\Sort;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Sections::find();
        $model = $query
            ->all();
        return $this->render('index', ['model' => $model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->login()) {
                return $this->goHome();
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->register()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        return $this->render('profile', [

        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSearch()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $q = Yii::$app->request->get('q');
        $query = User::find()->joinWith('friends')
            ->andwhere(['like', 'username', $q]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 4]);
        $sort = new Sort([
            'attributes' => [
                'username' => [
                    'label' => 'Имя'
                ]
            ]
        ]);
        $model = $query
            ->orderBy($sort->orders)
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('search', ['pagination' => $pagination, 'model' => $model, 'sort' => $sort]);
    }

    public function actionPostcreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new PostForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->create()) {
                return $this->redirect(['numbers']);
            }
        }
        return $this->render('post/create', [
            'model' => $model,
        ]);
    }

    public function actionSectionview($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $query_posts = Posts::find()->joinWith(['sections', 'users'])->where(['posts.sectionId' => $id]);
        $count = $query_posts->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $sort = new Sort([
            'attributes' => [
                'header' => [
                    'label' => 'Имя'
                ],
                'created_at' => [
                    'label' => 'Дата',
                ]
            ],
            'defaultOrder' => [
                'created_at' => SORT_DESC
            ]
        ]);
        $model = $query_posts
            ->orderBy($sort->orders)
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
        return $this->render('section/view', [
            'query_posts' => $model, 'pagination' => $pagination, 'model' => $model, 'sort' => $sort
        ]);
    }

    public function actionPostview($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $query_post_comments_users = Posts::find()->joinWith(['usercomments', 'users'])->where(['comments.postId' => $id])->asArray()->all();
        if (empty($query_post_comments_users)) {
            $query_post_users = Posts::find()->joinWith(['users'])->where(['posts.id' => $id])->asArray()->all();
            return $this->render('section/posts/view', [
                'query' => $query_post_users,
            ]);
        } else {
            return $this->render('section/posts/view', [
                'query' => $query_post_comments_users,
            ]);
        }
    }

    public function actionFriends()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $query_friends = Friends::find()->joinWith(['userone', 'usertwo'])->where(['friends.friend_one' => Yii::$app->user->identity->id])
            ->orWhere(['friends.friend_two' => Yii::$app->user->identity->id])->asArray()->all();
            return $this->render('users/friends', [
                'query' => $query_friends,
            ]);
    }

    public function actionFriendsdelete($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        Friends::find()->where(['friend_one' => $id])->orWhere(['friend_two' => $id])
            ->andWhere(['friend_two' => Yii::$app->user->identity->id])->orWhere(['friend_one' => Yii::$app->user->identity->id])->one()->delete();
        return $this->redirect(['site/friends']);
    }

    public function actionFriendsadd($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new Friends();
        if ($id == Yii::$app->user->identity->id) {
            Yii::$app->response->redirect(['site/friends']);
        } else {
            $model->create($id);
            Yii::$app->response->redirect(['site/friends']);
        }
    }

    public function actionFriendsverificate($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new Friends();
        if ($id == Yii::$app->user->identity->id) {
            Yii::$app->response->redirect(['site/friends']);
        } else {
            $model->friendUpdate($id);
            Yii::$app->response->redirect(['site/friends']);
        }
    }

    public function actionProfileview($id)
    {
        $query_user = User::find()
            ->where(['users.id' => $id])
            ->asArray()->one();
        $query_oof = Friends::find($query_user)->where(['friend_one' => $id])->orWhere(['friend_two' => $id])
            ->andWhere(['friend_two' => Yii::$app->user->identity->id])->orWhere(['friend_one' => Yii::$app->user->identity->id])->asArray()->one();
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        return $this->render('users/view', [
            'query' => $query_user,
            'query_friend' => $query_oof
        ]);
    }
}
