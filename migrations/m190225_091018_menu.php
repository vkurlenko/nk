<?php

use yii\db\Migration;

/**
 * Class m190225_091018_menu
 */
class m190225_091018_menu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190225_091018_menu cannot be reverted.\n";

        return false;
    }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
		$this->createTable('{{%menu_tree}}', [
			'id' 	=> $this->primaryKey(),
			'tree' 	=> $this->integer()->notNull(),
			'lft' 	=> $this->integer()->notNull(),
			'rgt' 	=> $this->integer()->notNull(),
			'depth' => $this->integer()->notNull(),
			'name' 	=> $this->string()->notNull(),
			'url' 	=> $this->string()->notNull(),
			'text' 	=> $this->string(),
		]);
    }
/*
    public function down()
    {
        echo "m190225_091018_menu cannot be reverted.\n";

        return false;
    }
    */
}
