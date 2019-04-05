<?php

namespace app\modules\admin\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
//use app\modules\admin\models\MenuQuery;

/**
 * This is the model class for table "menu_tree".
 *
 * @property int $id
 * @property int $tree
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property string $name
 * @property string $url
 * @property string $text
 */
class MenuTree extends \yii\db\ActiveRecord
{
	public $sub;
	

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_tree';
    }
	
	public function behaviors(){
		return [
			'tree' => [
				'class' => NestedSetsBehavior::className(),
			],
			
			'htmlTree'=>[
				'class' => \wokster\treebehavior\NestedSetsTreeBehavior::className()
			]
		];
	}
	
	

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [['tree', 'lft', 'rgt', 'depth', 'sub'], 'integer'],
            [['name', 'url', 'text'], 'string', 'max' => 255],
			[['tree', 'lft', 'rgt', 'depth'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => 'Tree',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'name' => 'Name',
            'url' => 'Url',
            'text' => 'Text',
        ];
    }
	
	public function transactions(){
		return [
			self::SCENARIO_DEFAULT => self::OP_ALL,
		];
	}
	
	public static function find(){
		return new MenuQuery(get_called_class());
	}
	
	/*public function beforeSave($insert){
		if(parent::beforeSave($insert)){
			if($this->sub == null){
				$this->makeRoot();
			}
			else{
				$parent = self::find()->andWhere(['id' => $this->sub])->one();
				$this->prependTo($parent);			
			}			
			return true;
		}
		else{
			return false;
		}
	}*/
}
