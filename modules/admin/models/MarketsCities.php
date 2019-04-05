<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "markets_cities".
 *
 * @property int $id
 * @property string $city
 * @property int $is_region
 * @property string $url_alias
 * @property int $sort
 * @property int $active
 */
class MarketsCities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'markets_cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city'], 'required'],
            [['city', 'coords'],  'string'],
            [['is_region', 'sort', 'scale', 'first', 'active'], 'integer'],
            [['url_alias'], 'string', 'max' => 255],
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
            //'is_region' => 'Московская область',
            'scale' => 'Масштаб',
            'coords' => 'Координаты центра',
            'url_alias' => 'ЧПУ',
			'first' => 'Показывать первым в списке',
            'sort' => 'Sort',
            'active' => 'Показывать на сайте',
        ];
    }
}
