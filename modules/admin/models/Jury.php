<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "jury".
 *
 * @property int $id
 * @property string $name
 * @property string $descr
 * @property int $sort
 * @property int $active
 */
class Jury extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jury';
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
            [['name'], 'required'],
            [['name', 'descr'], 'string'],
            [['active'], 'integer'],
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
            'name' => 'Имя',
            'descr' => 'Описание',
            'image' => 'Фото',
            'sort' => 'Сортировка',
            'active' => 'Показывать',
        ];
    }
}
