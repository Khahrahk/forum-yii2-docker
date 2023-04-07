<?php

namespace app\controllers;

use app\models\Comments;
use app\models\Friends;
use app\models\GroupForm;
use app\models\Groups;
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

    public function actionAdmin()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin == 1) {

            $query = Groups::find();
            $count = $query->count();
            $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 4]);
            $sort = new Sort([
                'attributes' => [
                    'id' => [
                        'label' => 'id'
                    ],
                    'name' => [
                        'label' => 'Группа'
                    ],
                ]
            ]);
            $model = $query
                ->orderBy($sort->orders)
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
            return $this->render('admin', ['pagination' => $pagination, 'model' => $model, 'sort' => $sort]);
        } else {
            return $this->goHome();
        }
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

    public function actionNumbers()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $query = Person::find()->joinWith('number')->joinWith('groups');
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 4]);
        $sort = new Sort([
            'attributes' => [
                'fullName' => [
                    'label' => 'Имя'
                ],
                'date' => [
                    'label' => 'Дата рождения'
                ],
                'location' => [
                    'label' => 'Местонахождение'
                ],
                'number'
            ]
        ]);
        $model = $query
            ->orderBy($sort->orders)
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('numbers', ['pagination' => $pagination, 'model' => $model, 'sort' => $sort]);
    }

    public function actionSearch()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $q = Yii::$app->request->get('q');
        $query = Person::find()
            ->where(['like', 'fullName', $q])
            ->joinWith('number');
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 4]);
        $sort = new Sort([
            'attributes' => [
                'fullName' => [
                    'label' => 'Имя'
                ],
                'date' => [
                    'label' => 'Дата рождения'
                ],
                'location' => [
                    'label' => 'Местонахождение'
                ],
                'number'
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
        $query_friends = Friends::find()->joinWith(['users'])->where(['friends.friend_one' => Yii::$app->user->identity->id])
            ->orWhere(['friends.friend_two' => Yii::$app->user->identity->id])->asArray()->all();
            return $this->render('users/friends', [
                'query' => $query_friends,
            ]);
    }

    public function actionProfileview($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $query_user = User::find()->where(['id' => $id])->one();
        return $this->render('users/view', [
            'query' => $query_user,
        ]);
    }

    public function actionPostdelete($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (!empty(Person::findOne($id))) {
            if (!empty(Number::findOne($id))) {
                Number::findOne($id)->delete();
            }
            Person::findOne($id)->delete();
            return $this->redirect(['numbers']);
        } else {
            return $this->goHome();
        }
    }

    public function actionPostedit($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $query_person = Person::findOne($id);
        $query_number = Number::findOne($id);
        if ($query_person->load(Yii::$app->request->post())) {
            //не совсем понял как связанные массивы в yii сохранять, но так вроде получается
            $query_person->fullName = Yii::$app->request->post()['Person']['fullName'];
            $query_person->date = Yii::$app->request->post()['Person']['date'];
            $query_person->location = Yii::$app->request->post()['Person']['location'];
            $query_person->personGroup = Yii::$app->request->post()['Person']['personGroup'];
            $query_number->number = Yii::$app->request->post()['Number']['number'];


            if ($query_person->save() && $query_number->save()) {
                return $this->redirect(['numbers']);
            }
        } else {
            return $this->render('post/edit', [
                'model' => $query_person,
            ]);
        }
    }


    public function actionGroupcreate()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin == 1) {
            $model = new GroupForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->create()) {
                    return $this->redirect(['admin']);
                }
            }
            return $this->render('admin/create', [
                'model' => $model,
            ]);
        } else {
            return $this->goHome();
        }
    }

    public function actionGroupdelete($id)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin == 1) {
            $query = Groups::findOne($id)->delete();
            if ($query) {
                return $this->redirect(['admin']);
            }
        } else {
            return $this->goHome();
        }
    }

    public function actionGroupedit($id)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin == 1) {
            $query = Groups::findOne($id);
            if ($query->load(Yii::$app->request->post())) {
                $query->id = $id;
                $query->name = Yii::$app->request->post()['Groups']['name'];

                if ($query->save()) {
                    return $this->redirect(['admin']);
                }
            } else {
                return $this->render('admin/edit', [
                    'model' => $query,
                ]);
            }
        } else {
            return $this->goHome();
        }
    }
}
