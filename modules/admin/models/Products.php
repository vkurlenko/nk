<?php

namespace app\modules\admin\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property string $descr
 * @property string $cover
 * @property int $sort
 * @property int $active
 * @property int $size
 */
class Products extends \yii\db\ActiveRecord
{
    public $product_images;
    public $cover_file;
    //public $cover;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    public function behaviors()
    {
        return [
            'product_images' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', ], 'required'],
            [['descr', 'video', 'cover'], 'string'],
            [['sort', 'active', 'size'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['product_images'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 4],
            [['cover_file'], 'file', 'extensions' => 'png, jpg',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'descr' => 'Описание',
            'video' => 'Код вставки видео',
            'cover' => 'Обложка',
            'sort' => 'Сортировка',
            'size' => 'Размер блока',
            'active' => 'Показывать',
            'product_images' => 'Картинки',
            'cover_file' => 'Обложка видео',
            'photo' => 'Фото'
        ];
    }

    public function uploadImages()
    {
        if ($this->validate()) {
            //echo 'up'; die;
            foreach($this->product_images as $file){
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
}
