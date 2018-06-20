<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string $name
 * @property string $logo
 * @property int $city
 * @property string $text
 * @property string $active
 */
class Brands extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brands';
    }

    /* для загрузки картинок */
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
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

    public function getCities(){
        return $this->hasOne(Cities::className(), ['id' => 'city']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'city', 'text', 'active'], 'required'],
            [['name', 'text', 'active'], 'string'],
            [['city'], 'integer'],
            [['image'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название сети',
            'logo' => 'Логотип',
            'city' => 'Город',
            'text' => 'Описание',
            'active' => 'Показывать на сайте',
        ];
    }
}
