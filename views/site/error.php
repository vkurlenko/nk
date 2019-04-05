<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

//use Yii;

use yii\helpers\Html;
use yii\helpers\Url;
Yii::$app->response->setStatusCode(404);

/* auto redirect to mainpage */
//Yii::$app->response->redirect(Url::to('/'));


//$this->redirect(['user/index']);


$this->title = 'Not Found (#404)';
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p style="text-align:center; padding:20px"> 
        Ошибка 404. Страница не существует        
    </p>
    <!-- <p>
        Please contact us if you think this is a server error. Thank you.
    </p> -->

</div>
