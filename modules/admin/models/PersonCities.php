<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "person_cities".
 *
 * @property int $id
 * @property string $name
 * @property int $sort
 * @property int $active
 */
class PersonCities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person_cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'active'], 'required'],
            [['sort', 'active'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Город',
            'sort' => 'Сортировка',
            'active' => 'Показывать',
        ];
    }

    public function getPerson()
    {
        return $this->hasMany(Persons::className(), ['city_id' => 'name']);
    }
}
