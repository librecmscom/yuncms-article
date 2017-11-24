<?php

namespace yuncms\article\migrations;

use yii\db\Migration;

class M171114065018Create_categories_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%article_categories}}', [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'parent' => $this->integer()->unsigned()->comment('Parent Id'),
            'name' => $this->string()->notNull()->comment('Name'),
            'slug' => $this->string(50)->comment('Slug'),
            'keywords' => $this->string()->comment('Keywords'),
            'description' => $this->string(1000)->defaultValue('')->comment('Description'),
            'letter' => $this->string(1)->comment('Letter'),
            'frequency' => $this->integer()->notNull()->defaultValue(0)->comment('Frequency'),
            'sort' => $this->smallInteger(5)->notNull()->defaultValue(0)->comment('Sort'),
            'allow_publish' => $this->boolean()->defaultValue(true)->comment('Allow Publish'),
            'created_at' => $this->integer()->notNull()->unsigned()->comment('Created At'),
            'updated_at' => $this->integer()->notNull()->unsigned()->comment('Updated At'),
        ], $tableOptions);

        $this->addForeignKey('{{%article_categories_fk}}', '{{%article_categories}}', 'parent', '{{%article_categories}}', 'id', 'SET NULL', 'CASCADE');

    }

    public function safeDown()
    {
        $this->dropTable('{{%article_categories}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171114065018Create_categories_table cannot be reverted.\n";

        return false;
    }
    */
}
