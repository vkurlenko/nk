<?php

namespace app\controllers;


use app\modules\admin\models\Brands;
use app\modules\admin\models\Cities;
use app\modules\admin\models\Jury;
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
        $this->layout = '@app/modules/admin/views/layouts/main-login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('@app/modules/admin/views/site/login', [
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



    public function actionSupervision()
    {
        $svision = $this->getSvision(100);
        return $this->render('supervision', compact('svision'));
    }

    public function actionJury()
    {
        $jury = Jury::find()->where(['active' => 1])->orderBy(['sort' => SORT_ASC])->indexBy('id')->asArray()->all();

        foreach($jury as $m){
            $p = Jury::findOne($m['id']);
            $photo = $p->getImage();
            $jury[$m['id']]['photo'] = $photo->getUrl('460x360');
        }
        return $this->render('jury', compact('jury'));
    }

    public function actionMarkets(){

        $city = [];
        if(Yii::$app->request->get('id')){
            $id = Yii::$app->request->get('id');

            $model = Cities::findOne($id);
            $herb = $model->getImage();
            $city = [
                'id' => $model->id,
                'name' => $model->city,
                'herb' => $herb->getUrl('x200'),
                'text' => $model->text,
            ];

            $logos = Brands::find()->where(['active' => 1])->orderBy(['sort' => SORT_ASC])->indexBy('id')->asArray()->all();

            if($logos){
                foreach($logos as $logo){
                    $model = Brands::findOne($logo['id']);
                    $img = $model->getImage();

                    if($model->city == $id){
                        $city['logos'][] =
                            [
                                'brand' => $model->name,
                                'img' => '/'.$img->getPath('170x70'),
                                'url' => $model->url,
                            ];
                    }
                }
            }
        }

        //debug($city); die;

        return $this->render('markets', compact('city'));
    }

    // формирует главное меню
    public static function makeMainMenu()
    {
        $arr = [];

        $pages = PagesController::mapTree(PagesController::getAllPages());

        foreach($pages as $page){

            if($page['url'] == '' || !$page['active'])
                continue;

            // подменю Где купить
            if($page['url'] == 'markets'){

                $cities = Cities::find()->where(['active' => 1])->orderBy(['sort' => SORT_ASC])->indexBy('id')->asArray()->all();

                foreach($cities as $city){

                    $page['childs'][] = [
                        'active' => $city['active'],
                        'title' => $city['city'],
                        'url' => '/markets/'.$city['id'],
                    ];
                }
            }



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

    public function getSvision($limit = 4){

        $arr_video = Svision::find()->where(['active' => 1, 'type' => 'svision'])->orderBy(['date' => SORT_DESC])->asArray()->limit($limit)->all();

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
}

