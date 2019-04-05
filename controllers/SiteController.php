<?php

namespace app\controllers;


use app\models\CastingForm;
use app\modules\admin\controllers\MenuController;
use app\modules\admin\controllers\SeasonsController;
use app\modules\admin\models\Brands;
use app\modules\admin\models\Cities;
use app\modules\admin\models\Jury;
use app\modules\admin\models\Markets;
use app\modules\admin\models\Productscat;
use Yii;
use app\modules\admin\controllers\PagesController;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\FranchForm;
use app\models\Pages;
use rico\yii2images\models\Image;
use yii\helpers\Url;
use app\modules\admin\models\Persons;
use app\controllers\PersonController;
use app\modules\admin\controllers\SvisionController;
use app\modules\admin\models\Svision;
use yii\web\UploadedFile;
use yii\web\Request;
use app\modules\admin\models\Options;




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

        $random = AppController::getOption('persons_on_main_random') ?  true :  false;

        // в случайном порядке Лица выбираются за последний сезон
        if($random){
            $seasons = SeasonsController::getSeasons(true);

            foreach($seasons as $s){
                $year = $s['id'];
                $persons = Persons::find()->where(['active' => 1, 'year' => $year])->orderBy('RAND()')->limit(4)->all();

                if($persons)
                    break;
            }            //$year =  Persons::find()->max('year');

        }
        else
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
        $page_data = $this->getPageDataByUrl();

        //debug($page_data);
        if($page_data){
            // найдем главную картинку и галерею картинок, если они прикреплены к странице
            $page = Pages::findOne($page_data['id']);
            $img = $page->getImage();
            $gallery = $page->getImages();

            if($page->active)
                return $this->render('text', compact('page_data', 'img', 'gallery'));
            else
                return $this->redirect(['site/index']);

        }
        else
            return $this->render('error');
    }

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

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

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

    public function actionFranch()
    {
        // определим данные главной страницы по ее url
        $page_data = $this->getPageDataByUrl();

        if(!$page_data['active'])
            return $this->redirect(['site/index']);

        if($page_data){
            // найдем главную картинку и галерею картинок, если они прикреплены к странице
            $page = Pages::findOne($page_data['id']);
            $img = $page->getImage();
            $gallery = $page->getImages();
        }


        $model = new FranchForm();
        /*if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post()) && $model->franch(Yii::$app->params['adminEmail'])){
                return 'Запрос принят';
            }
        }*/
        return $this->render('franch', compact('model', 'page_data', 'img', 'gallery'));
    }

    public function actionFranchform()
    {
        $model = new FranchForm();
        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post()) && $model->franch(Yii::$app->params['adminEmail'])){
                return 'Запрос принят';
            }
        }
    }


    public function actionCasting()
    {
        // определим данные главной страницы по ее url
        $page_data = $this->getPageDataByUrl();

        if(!$page_data['active'])
            return $this->redirect(['site/index']);

        if($page_data){
            // найдем главную картинку и галерею картинок, если они прикреплены к странице
            $page = Pages::findOne($page_data['id']);
            $img = $page->getImage();
            $gallery = $page->getImages();
        }

        $model = new CastingForm();

        $model->arr_path = [];

        if (Yii::$app->request->isPost) {

            $arr_f = ['file1', 'file2', 'file3'];

            foreach($arr_f as $f){
                $model->$f = UploadedFile::getInstance($model, $f);
                if($model->$f){
                    $model->$f->saveAs('upload/' . $model->$f->baseName . '.' . $model->$f->extension);
                    $model->path = 'upload/' . $model->$f->baseName . '.' . $model->$f->extension;
                    $model->arr_path[] = $model->path;
                }
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->casting(Yii::$app->params['adminEmail'], $model->arr_path)){
            Yii::$app->session->setFlash('success', 'Ваше сообщение отправлено');
            return $this->refresh();
        }
        return $this->render('casting', compact('model', 'page_data', 'img', 'gallery'));
    }

    public function actionSupervision()
    {
        $page_data = $this->getPageDataByUrl();

        if(!$page_data['active'])
            return $this->redirect(['site/index']);

        $svision = $this->getSvision(100);
        return $this->render('supervision', compact('svision', 'page_data'));
    }

    public function actionJury()
    {
        $page_data = $this->getPageDataByUrl();

        if(!$page_data['active'])
            return $this->redirect(['site/index']);

        $jury = Jury::find()->where(['active' => 1])->orderBy(['sort' => SORT_ASC])->indexBy('id')->asArray()->all();

        foreach($jury as $m){
            $p = Jury::findOne($m['id']);
            $photo = $p->getImage();
            $jury[$m['id']]['photo'] = $photo->getPath('460x360');
        }
        return $this->render('jury', compact('jury', 'page_data'));
    }

    public function actionMarkets(){
        $page_data = $this->getPageDataByUrl();

        if(!$page_data['active'])
            return $this->redirect(['site/index']);

        $city = [];

        if(Yii::$app->request->get('id')){
            $id = Yii::$app->request->get('id');
            $city = Cities::find()->where(['url_alias' => $id, 'active' => 1])->one();
            if(!$city)
                return $this->render('error');
        }
        else{
            $cities = Cities::find()->where(['active' => 1])->orderBy(['sort' => SORT_ASC])->indexBy('id')->asArray()->limit(1)->one();
            if($cities)
                $id = $cities['url_alias'];//$id = $cities['id'];
        }

        if($id){
            //$model = Cities::findOne($id);
            $model = Cities::find()->where(['url_alias' => $id, 'active' => 1])->one();
            $herb = $model->getImage();
            $city = [
                'id'        => $model->id,
                'name'      => $model->city,
                'herb'      => $herb->getUrl('x200'),
                'text'      => $model->text,
                'content'   => $model->content,
                'title'     => $model->title,
                'kwd'       => $model->kwd,
                'dscr'      => $model->dscr
            ];

            $logos = Brands::find()->where(['active' => 1])->orderBy(['sort' => SORT_ASC])->indexBy('id')->asArray()->all();

            if($logos){
                foreach($logos as $logo){
                    $model = Brands::findOne($logo['id']);
                    $img = $model->getImage();

                    //if($model->city == $id){
                    if($model->city == $city['id']){
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

        return $this->render('markets', compact('city', 'page_data'));
    }

    public static function getPageDataByUrl($url = null){

        if(!$url)
            $url = Url::to();

        if(stripos($url,'/' ) !== false){
            $arr = explode('/', $url);
            $url = $arr[1];
        }
            //$url = substr($url, 1);

        $page_data = Pages::find()->where(['url' => $url])->asArray()->one();

        return $page_data;
    }

    // формирует главное меню
    public static function makeMainMenu()
    {
        $arr = [];

        if( \app\controllers\AppController::getOption('nav-phone')){
            $phone = \app\controllers\AppController::getOption('nav-phone');

            $clean = str_replace(array('(', ')', ' ', '-', '+'), '', $phone);

            $arr[] = [
                'label' => $phone,
                'url'   => 'tel:+'.$clean,
                'options' => [
                    'id' => 'navbar-phone'
                ]
            ];
        }



        $pages = SiteController::getMenu(1);

        //debug($pages);die;

        foreach($pages as $page){

            if($page['url'] == '' || !$page['active'])
                continue;

            // подменю Где купить
            if($page['url'] == 'markets' || $page['url'] == '/markets'){

                //$cities = Cities::find()->where(['active' => 1])->orderBy(['sort' => SORT_ASC])->indexBy('id')->asArray()->all();
                $cities = Cities::find()->where(['active' => 1])->orderBy(['sort' => SORT_ASC])->asArray()->all();
                //debug($cities); die;

                if(count($cities) == 1)
                {
                    $page['url'] = '/markets/'.$cities[0]['url_alias'];
                }
                else{
                    foreach($cities as $city){

                        $page['childs'][] = [
                            'active' => $city['active'],
                            'title' => $city['city'],
                            'url' => '/markets/'.$city['url_alias'],
                        ];
                    }
                }
            }

            // подменю Продукция
            if($page['url'] == 'products' || $page['url'] == '/products'){

                $pcats = Productscat::find()->where(['active' => 1])->orderBy(['sort' => SORT_ASC])->asArray()->all();
                //debug($pcats); die;

                if(count($pcats) == 1)
                {
                    $page['url'] = '/products/'.$pcats[0]['url_alias'];
                }
                else{
                    foreach($pcats as $pcat){

                        $page['childs'][] = [
                            'active' => $pcat['active'],
                            'title' => $pcat['name'],
                            'url' => '/products/'.$pcat['url_alias'],
                        ];
                    }
                }
            }

            if($page['childs']){

                $i = 0;
                $arr_ch = [];

                foreach($page['childs'] as $child){

                    if($child['active']) {
                        $i++;

                        if(stripos($child['url'], 'http') === false && stripos($child['url'], '/') !== 0)
                            $child['url'] = '/'.$child['url'];

                        $arr_ch[] =  [
                            'label' => $child['title'],
                            'url' => [$child['url']],
                            'options' => $i == 1 ? ['class' => 'first-item'] : []
                        ];
                    }
                }
                $arr[] = ['label' => $page['title'], 'items' => $arr_ch, 'options' => ['class' => 'submenu'],];
            }
            else{
                if(stripos($page['url'], 'http') === false && stripos($page['url'], '/') !== 0)
                    $page['url'] = '/'.$page['url'];

                $arr[] = ['label' => $page['title'], 'url' => $page['url']];
            }
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
        $arr = Image::find()->asArray()->where(['itemId' => $id, 'active' => 1])->orderBy(['sort' => SORT_ASC])->all();

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
                    /*$sl = strrpos($v, '/');
                    if($sl){
                        $arr_video[$i]['video'] = substr($v, $sl+1);
                        if($arr_video[$i]['video'] == ''){
                            $arr = explode('/', $v);
                            debug($arr);
                            $arr_video[$i]['video'] = $arr[count($arr) - 2];
                        }
                        $arr_video[$i]['cover'] = $this->getPhoto($arr_video[$i]['id']);
                    }*/

                    if($v != ''){
                        $arr = explode('/', $v);

                        foreach($arr as $el){
                            if($el != ''){

                                if(stripos($el, 'rutube') !== false)
                                   $arr_video[$i]['source'] = 'rutube';
                                elseif(stripos($el, 'you') !== false)
                                    $arr_video[$i]['source'] = 'youtube';

                                $arr_video[$i]['video'] = $el;
                            }
                        }

                        $arr_video[$i]['cover'] = $this->getPhoto($arr_video[$i]['id']);
                        $arr_video[$i]['date'] = AppController::formatDate($arr_video[$i]['date']);
                    }
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
                    //$photos[$pfx.'_on_main'] = [$img->getUrl('338x235'), $img->name]; break;
                    $photos[$pfx.'_on_main'] = [$img->getPath('338x235'), $img->name]; break;
                    //$photos[$pfx.'_big'] = [$img->getPath('360x549'), $img->name]; break;

                default : break;
            }
        }
        return $photos;
    }

    // получим email-адреса в виде массива из опции $option_name
    public static function getEmails($option_name = null){
        if($option_name){
            $option = Options::find()->where(['name' => $option_name])->asArray()->one();
            $emails = $option['value'];
            $users = explode(',', $emails);
            $users[] = Yii::$app->params['adminEmail'];
            return $users;
        }

        return false;
    }

   /* public static function mapTree($dataset, $pid)
    {
        $tree = array();

        foreach ($dataset as $id=>&$node) {

            if (!$node['pid']){
                $tree[$id] = &$node;
            }else{
                $dataset[$node['pid']]['childs'][$id] = &$node;
            }
        }

        return $tree;
    }*/

   public static function getUrlFromId($url = null, $pages){

       if(intval($url) && array_key_exists(intval($url), $pages))
           $u = $pages[intval($url)]['url'];
       else
           $u = $url;

       if(stripos($u, 'http') === false && stripos($u, '/') === false)
           $u = '/'.$u;

       return $u;
   }


    public static function getMenu($pid = null){

        $menus = MenuController::getAllMenu();

        $pages = PagesController::getAllPages();

        $tree = MenuController::mapTree($menus);

        $arr = [];
        foreach($tree as $node){
            if($node['id'] != $pid || !$node['active'])
                continue;


            if($node['childs']){

                foreach ($node['childs'] as $child){

                    if($child['active']){

                        if(intval($child['url']) && !$pages[$child['url']]['active'])
                            continue;


                        $child['url'] = self::getUrlFromId($child['url'], $pages);
                        $arr[$child['id']] = $child;

                        if($child['childs']){
                            $arr[$child['id']]['childs'] = [];

                            foreach($child['childs'] as $child2){

                                if($child2['active'] ){

                                    if(intval($child2['url']) && !$pages[$child2['url']]['active'])
                                        continue;

                                    $child2['url'] = self::getUrlFromId($child2['url'], $pages);

                                    $arr[$child['id']]['childs'][] = $child2;
                                }
                            }
                        }
                    }
                }
            }
        }
        //debug($arr);
        return $arr;
    }
}

