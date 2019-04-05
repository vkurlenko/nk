<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "markets".
 *
 * @property int $id
 * @property int $name
 * @property int $url_alias
 * @property int $city
 * @property int $is_region
 * @property string $text
 * @property string $latitude
 * @property string $longitude
 * @property int $scale
 * @property int $active
 * @property int $sort
 */
class Markets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'markets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city', 'name'], 'required'],
            [['scale', 'active', 'sort'], 'integer'],
            [['city', 'short_addr',  'name', 'url_alias', 'text', 'latitude', 'longitude'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название торговой точки',
            'url_alias' => 'ЧПУ',
            'city' => 'Город',
            'short_addr' => 'Адрес краткий',
            'text' => 'Описание',
            'latitude' => 'Координаты',
            //'longitude' => 'Долгота',
            'scale' => 'Масштаб',
            'active' => 'Показывать на сайте',
            'sort' => 'Sort',
        ];
    }
}
