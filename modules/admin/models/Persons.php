<?php

namespace app\modules\admin\models;

use Yii;
use yii\web\UploadedFile;
use app\modules\admin\models\Svision;

/**
 * This is the model class for table "persons".
 *
 * @property int $id
 * @property string $name
 * @property int $city_id
 * @property int $year
 * @property int $winner
 * @property string $winner_text
 * @property string $text
 * @property string $photo_big
 * @property string $photo_small
 * @property string $photo_cake
 * @property string $photo_on_main
 * @property int $on_main
 * @property int $on_main_sort
 * @property int $sort
 * @property int $active
 */
class Persons extends \yii\db\ActiveRecord
{

    public $person_images;
    public $person_video;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persons';
    }

    public function behaviors()
    {
        return [
            'photo_big' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ],
            'photo_small' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    public function getSvision()
    {
        return $this->hasMany(Svision::className(), ['person_id' => 'id']);
    }


    public function uploadImages()
    {
        if ($this->validate()) {
            foreach($this->person_images as $file){
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

    public function uploadVideo()
    {
        if ($this->validate()) {
            foreach($this->person_video as $file){
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'city_id', 'year'], 'required'],
            [['city_id', 'year', 'winner', 'on_main', 'on_main_sort', 'sort', 'active'], 'integer'],
            [['text',  'photo_cake', 'photo_on_main'], 'string'],
            [['name', 'winner_text'], 'string', 'max' => 255],
            [['photo_big'], 'file', 'extensions' => 'png, jpg'],
            [['photo_small'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя участника',
            'city_id' => 'Город',
            'year' => 'Год',
            'winner' => 'Победитель',
            'winner_text' => 'Текст победителя',
            'text' => 'Биография',
            /*'photo_big' => 'Фото крупное',
            'photo_small' => 'Фото мелкое',
            'photo_cake' => 'Фото торта',
            'photo_on_main' => 'Фото для главной (составное)',*/
            'person_images' => 'Фотографии участника',
            'on_main' => 'Разместить на главной',
            'on_main_sort' => 'Порядок на главной',
            'sort' => 'Сортировка на сайте',
            'active' => 'Показывать на сайте',
        ];
    }
}
