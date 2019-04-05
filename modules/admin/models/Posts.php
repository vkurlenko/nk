<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property int $pid
 * @property string $title
 * @property string $slug
 * @property string $url
 * @property string $anons
 * @property string $content
 * @property int $thumbnail
 * @property string $kwd
 * @property string $dscr
 * @property int $order_by
 * @property string $active
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'thumbnail', 'order_by'], 'integer'],
            [['title', 'slug', 'url', 'anons', 'content', 'thumbnail', 'kwd', 'dscr', 'order_by'], 'required'],
            [['title', 'slug', 'url', 'anons', 'content', 'kwd', 'dscr', 'active'], 'string'],
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
            'title' => 'Title',
            'slug' => 'Slug',
            'url' => 'Url',
            'anons' => 'Anons',
            'content' => 'Content',
            'thumbnail' => 'Thumbnail',
            'kwd' => 'Kwd',
            'dscr' => 'Dscr',
            'order_by' => 'Order By',
            'active' => 'Active',
        ];
    }
}
