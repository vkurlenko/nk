<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tpl".
 *
 * @property int $id
 * @property string $controller
 * @property string $name
 */
class Tpl extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tpl';
    }

    public function getPages()
    {
        return $this->hasMany(Pages::className(), ['tpl' => 'template_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['template_id', 'name'], 'required'],
            [['template_id', 'name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_id' => 'ID шаблона',
            'name' => 'Название шаблона',
        ];
    }
}
