<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "products_cat".
 *
 * @property int $id
 * @property string $name
 * @property string $url_alias
 * @property int $active
 * @property int $sort
 */
class Productscat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_cat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'url_alias'], 'string'],
            [['active', 'sort'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование категории',
            'url_alias' => 'Alias',
            'active' => 'Показывать на сайте',
            'sort' => 'Сортировка',
        ];
    }



}
