<?php

namespace app\models;

use Yii;
use rico\yii2images;
use yii\web\UploadedFile;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property int $pid
 * @property string $url url
 * @property string $h1
 * @property string $title
 * @property string $anons
 * @property string $content
 * @property string $images
 * @property string $thumbnail
 * @property string $kwd
 * @property string $dscr
 * @property string $tpl
 * @property string $params
 * @property int $order_by
 * @property string $active
 */
class Pages extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'order_by'], 'integer'],
            [['url', 'h1', 'title', 'anons', 'content', 'images', 'thumbnail', 'kwd', 'dscr', 'tpl', 'params', 'order_by'], 'required'],
            [['url', 'h1', 'title', 'anons', 'content', 'images', 'thumbnail', 'kwd', 'dscr', 'params', 'active'], 'string'],
            [['tpl'], 'string', 'max' => 255],
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
            'url' => 'Url',
            'h1' => 'H1',
            'title' => 'Title',
            'anons' => 'Anons',
            'content' => 'Content',
            'images' => 'Images',
            'thumbnail' => 'Thumbnail',
            'kwd' => 'Kwd',
            'dscr' => 'Dscr',
            'tpl' => 'Tpl',
            'params' => 'Params',
            'order_by' => 'Order By',
            'active' => 'Active',
        ];
    }
}
