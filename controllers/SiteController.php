<?php

namespace app\controllers;


use Yii;
use app\modules\admin\controllers\PagesController;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Pages;
use rico\yii2images\models\Image;
use yii\helpers\Url;
use app\modules\admin\models\Persons;
use app\controllers\PersonController;
use app\modules\admin\controllers\SvisionController;
use app\modules\admin\models\Svision;
use yii\web\UploadedFile;




class SiteController extends AppController
{

    public $defaultAction = 'text';

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
        // определим данные главной страницы по ее шаблону (tpl = 'main')
        $page_data = Pages::find()->where(['tpl' => 'main'])->asArray()->one();

        // создадим набор картинок для галереи
        $gallery = $this->makeSliderGallery($page_data['id']);

        $persons = Persons::find()->where(['active' => 1, 'on_main' => 1])->orderBy('on_main_sort')->limit(4)->all();
        $persons_on_main = [];

        foreach($persons as $person){
            $persons_on_main[] = $this->getPerson($person->id);
        }

        $s_vision = $this->getSvision();

       //debug($s_vision);

        return $this->render('index', compact('page_data', 'gallery', 'persons_on_main', 's_vision'));
    }


    public function getSvision(){

        //$s_vision = [];

        $arr_video = Svision::find()->where(['active' => 1, 'type' => 'svision'])->orderBy(['date' => SORT_DESC])->asArray()->limit(4)->all();
//debug($arr_video);
        $i = 0;
        foreach($arr_video as $video){
            $j = 0;
            foreach($video as $k => $v){
                if($k == 'video'){
                    $sl = strrpos($v, '/');
                    if($sl){
                        //$model = Svision::findOne($arr_video[$i]['id']);
                        $arr_video[$i]['video'] = substr($v, $sl+1);
                        $arr_video[$i]['cover'] = $this->getPhoto($arr_video[$i]['id']);
                    }

                    $arr_video[$i]['date'] = AppController::formatDate($arr_video[$i]['date']);

                }
                $j++;
            }
            $i++;
        }

        return $arr_video;
    }

    public function getPerson($id = null){

        $person = Persons::findOne($id);

        $photos = $this->getPhotos($id);

        foreach($photos as $photo => $url){
            $person[$photo] = $url;
        }

        return $person;
    }

    public function getPhoto($id = null){
        $model = Svision::findOne($id);
        $cover = $model->getImage();

        return $cover->getUrl('660x377');
    }

    public function getPhotos($id = null){

        $photos = [];
        $model = Persons::findOne($id);
        $images = $model->getImages();

        $pfx = 'photo';
        foreach($images as $img){
            switch($img->role){
                case $pfx.'_on_main'   :
                    $photos[$pfx.'_on_main'] = [$img->getUrl('338x235'), $img->name]; break;

                default : break;
            }
        }
        return $photos;
    }

    /* action по умолчанию для типовых (тестовых) страниц */
    public function actionText()
    {

        // определим данные главной страницы по ее url
        $url = Url::to();

        $data = Pages::find()->where(['url' => $url])->asArray()->one();

        if(!$data){
            $url = substr($url, 1);
            //echo $url;
            $data = Pages::find()->where(['url' => $url])->asArray()->one();
        }


        if($data){
            // найдем главную картинку и галерею картинок, если они прикреплены к странице
            $page = Pages::findOne($data['id']);
            $img = $page->getImage();
            $gallery = $page->getImages();

            return $this->render('text', compact('data', 'img', 'gallery'));
        }
        else
            return $this->render('error');
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
   /* public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionFranch()
    {
        return $this->render('franch');
    }*/

    /*public function actionPerson()
    {
        return $this->render('persons');
    }*/

    public function actionSupervision()
    {
        return $this->render('supervision');
    }

    // формирует главное меню
    public function makeMainMenu()
    {
        $arr = [];

        $pages = PagesController::mapTree(PagesController::getAllPages());

        //debug($pages); die;

        foreach($pages as $page){

            if($page['url'] == '')
                continue;

            if($page['childs']){

                $i = 0;
                $arr_ch = [];

                foreach($page['childs'] as $child){

                    if($child['active']) {
                        $i++;
                        $arr_ch[] =  [
                            'label' => $child['title'],
                            'url' => ['/'.$child['url']],
                            'options' => $i == 1 ? ['class' => 'first-item'] : []
                        ];
                    }
                }
                $arr[] = ['label' => $page['title'], 'items' => $arr_ch, 'options' => ['class' => 'submenu'],];
            }
            else
                $arr[] = ['label' => $page['title'], 'url' => ['/'.$page['url']]];
        }

        //debug($arr); die;

        return $arr;
    }

    /* сортировка картинок слайдера для страницы с ID = $id*/
    public function makeSliderGallery($id)
    {
        $page = Pages::findOne($id);
        $gallery = $page->getImages();
        $gallery2 = [];
        $arr = Image::find()->asArray()->where(['itemId' => $id])->orderBy(['sort' => SORT_ASC])->all();

        foreach($arr as $row){
            foreach($gallery as $img){
                if($img->id == $row['id']){
                    $gallery2[] = $img;
                }
            }
        }

        return $gallery2;
    }
}

