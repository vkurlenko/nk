<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "seasons".
 *
 * @property int $id
 * @property string $name
 * @property string $descr
 * @property int $sort
 * @property int $active
 */
class Seasons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seasons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['descr'], 'string'],
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
            'name' => 'Наименование',
            'descr' => 'Описание',
            'sort' => 'Сортировка',
            'active' => 'Показывать на сайте',
        ];
    }
}
