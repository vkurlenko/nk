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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city', 'logo', 'sort', 'active'], 'required'],
            [['city', 'logo', 'active'], 'string'],
            [['sort'], 'integer'],
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
            'logo' => 'Логотип',
            'sort' => 'Сортировка',
            'active' => 'Показывать',
        ];
    }
}
