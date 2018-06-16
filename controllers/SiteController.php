<?php

namespace app\controllers;

use app\modules\admin\controllers\PagesController;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;
use rico\yii2images;



class SiteController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
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
        $pages = $this->makeMainMenu();
        return $this->render('index', compact('pages'));
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
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionFranch()
    {
        return $this->render('franch');
    }

    public function actionPerson()
    {
        return $this->render('person');
    }

    public function actionSupervision()
    {
        return $this->render('supervision');
    }

    // формирует главное меню
    public function makeMainMenu()
    {
        $arr = [];

        $pages = PagesController::mapTree(PagesController::getAllPages());

        foreach($pages as $page){

            if($page['childs']){

                $i = 0;
                $arr_ch = [];

                foreach($page['childs'] as $child){

                    if($child['active']) {
                        $i++;
                        $arr_ch[] =  [
                            'label' => $child['title'],
                            'url' => [$child['url']],
                            'options' => $i == 1 ? ['class' => 'first-item'] : []
                        ];
                    }

                }

                $arr[] = ['label' => $page['title'], 'items' => $arr_ch, 'options' => ['class' => 'submenu'],];

            }
            else
                $arr[] = ['label' => $page['title'], 'url' => [$page['url']]];
        }

        return $arr;
    }
}

