<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "options".
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $value
 * @property string $comment
 * @property int $sort
 */
class Options extends \yii\db\ActiveRecord
{
    public $file_img;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['value'], 'string'],
            //[['sort'], 'integer'],
            [['name', 'comment', 'type'], 'string', 'max' => 255],
            [['file_img'], 'file', 'extensions' => 'png, jpg',]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Ключ опции',
            'value' => 'Значение',
            'type' => 'Тип',
            'comment' => 'Опция',
            'sort' => 'Sort',
            'file_img' => 'File'
        ];
    }


    public function uploadImages()
    {
        if ($this->validate()) {
            //echo 'up'; die;
            foreach($this->value as $file){
                $path = 'upload/store/' . $file->baseName . '.' . $file->extension;
                $file->saveAs($path);
                $this->attachImage($path);
                unlink($path);
            }
            return true;
        }
        else {
            return false;
        }

    }
}
