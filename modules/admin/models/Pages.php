<?php

namespace app\modules\admin\models;

use Yii;
use yii\web\UploadedFile;


/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property int $pid
 * @property string $url
 * @property string $h1
 * @property string $title
 * @property string $anons
 * @property string $content
 * @property string $images
 * @property string $thumbnail
 * @property string $kwd
 * @property string $dscr
 * @property int $tpl
 * @property string $params
 * @property int order_by
 * @property string $active
 */
class Pages extends \yii\db\ActiveRecord
{
    public $image;
    public $gallery;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }


    public function getTemplate()
    {
        return $this->hasOne(Tpl::className(), ['template_id' => 'tpl']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'h1', 'title', 'tpl', 'order_by'], 'required'],
            [['pid',  'order_by'], 'integer'],
            [['url', 'h1', 'tpl', 'title', 'anons', 'content', 'images',  'kwd', 'dscr', 'params', 'active'], 'string'],
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['gallery'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $path = 'upload/store/' . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs($path);
            $this->attachImage($path, true);
            unlink($path);
            return true;
        } else {
            return false;
        }
    }

    public function uploadGallery()
    {
        if ($this->validate()) {
            foreach($this->gallery as $file){
                $path = 'upload/store/' . $file->baseName . '.' . $file->extension;
                $file->saveAs($path);
                $this->attachImage($path);
                unlink($path);
            }
            return true;
        }
        else {
            return false;
        }

    }

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Родительская страница',
            'url' => 'Url',
            'h1' => 'H1',
            'title' => 'Заголовок (Title)',
            'anons' => 'Краткий текст (превью)',
            'content' => 'Полный текст (контент)',
            'gallery' => 'Галерея',
            'image' => 'Картинка',
            'kwd' => 'Meta keywords',
            'dscr' => 'Meta description',
            'tpl' => 'Шаблон',
            'params' => 'Параметры',
            'order_by' => 'Сортировка',
            'active' => 'Показывать на сайте',
        ];
    }
}