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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brands';
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
            [['name', 'logo', 'city', 'text', 'active'], 'required'],
            [['name', 'logo', 'text', 'active'], 'string'],
            [['city'], 'integer'],
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
            'active' => 'Активен',
        ];
    }
}
