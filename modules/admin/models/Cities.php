<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string $city
 * @property string $logo
 * @property int $sort
 * @property string $active
 */
class Cities extends \yii\db\ActiveRecord
{
    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city', 'sort', 'active'], 'required'],
            [['city', 'active'], 'string'],
            [['sort'], 'integer'],
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
            'city' => 'Город',
            'image' => 'Герб города',
            'sort' => 'Сортировка',
            'active' => 'Показывать на сайте',
        ];
    }
    /* /для загрузки картинок */

    public function getPerson()
    {
        return $this->hasMany(Persons::className(), ['city_id' => 'id']);
    }
}
