<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "markets".
 *
 * @property int $id
 * @property int $city
 * @property string $brands
 * @property string $anons
 * @property int $text
 * @property string $active
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
            [['city', 'brands', 'anons', 'text', 'active'], 'required'],
            [['city'], 'integer'],
            [['brands', 'anons', 'text', 'active'], 'string'],
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
            'brands' => 'Торговые сети',
            'anons' => 'Краткий текст',
            'text' => 'Полный текст',
            'active' => 'Показывать',
        ];
    }
}
