<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "svision".
 *
 * @property int $id
 * @property int $person_id
 * @property string $date
 * @property string $title
 * @property string $descr
 * @property string $video
 * @property int $size
 * @property int $active
 */
class Svision extends \yii\db\ActiveRecord
{

    public $image;
    public $year;
    public $city;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'svision';
    }

    public function getPerson()
    {
        return $this->hasOne(Persons::className(), ['id' => 'person_id']);
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
            [['person_id', 'date', 'title',   'size', 'active'], 'required'],
            [['person_id',  'active'], 'integer'],
            [['date'], 'safe'],
            [['descr', 'size', 'video', 'type'], 'string'],
            [['title'], 'string', 'max' => 255],
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
            'person_id' => 'Участник',
            'date' => 'Дата',
            'title' => 'Заголовок',
            'descr' => 'Описание',
            'video' => 'Код видео',
            'image' => 'Обложка видео',
            'size' => 'Размер блока',
            'type' => 'Тип записи',
            'active' => 'Показывать на сайте',
        ];
    }
}
