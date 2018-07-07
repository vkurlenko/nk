<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property int $pid
 * @property string $title
 * @property string $url
 * @property string $class
 * @property int $sort
 * @property int $active
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'title', 'url'], 'required'],
            [['pid', 'active', 'sort'], 'integer'],
            [['title', 'url', 'class'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'title' => 'Заголовок',
            'url' => 'Url',
            'class' => 'Class',
            'sort' => 'Сортировка',
            'active' => 'Active',
        ];
    }
}
