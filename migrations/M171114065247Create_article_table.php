<?php

namespace yuncms\article\migrations;

use yii\db\Migration;

class M171114065247Create_article_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey()->unsigned()->comment('Id'),
            'uuid' => $this->string()->comment('UUID'),
            'user_id' => $this->integer()->notNull()->unsigned()->comment('User ID'),
            'category_id' => $this->string()->comment('Category Id'),
            'title' => $this->string()->notNull()->comment('Title'),
            'sub_title'=>$this->string(80)->notNull()->comment('Sub Title'),
            'description' => $this->string()->comment('Description'),
            'status' => $this->boolean()->defaultValue(false)->comment('Status'),
            'cover' => $this->string()->comment('Cover'),
            'comments' => $this->integer()->notNull()->defaultValue(0)->comment('Comments'),
            'supports' => $this->integer()->notNull()->defaultValue(0)->comment('Supports'),
            'collections' => $this->integer()->notNull()->defaultValue(0)->comment('Collections'),
            'views' => $this->integer()->notNull()->defaultValue(0)->comment('Views'),
            'is_top' => $this->boolean()->notNull()->defaultValue(false)->comment('Is Top'),
            'is_best' => $this->boolean()->notNull()->defaultValue(false)->comment('Is Best'),
            'content' => $this->text()->notNull()->comment('content'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('Created At'),
            'updated_at' => $this->integer()->notNull()->defaultValue(0)->comment('Updated At'),
            'published_at' => $this->integer()->notNull()->defaultValue(0)->comment('Published At'),
        ], $tableOptions);
        $this->createIndex('index_published_at', '{{%article}}', 'published_at');

        $this->alterColumn('{{%article}}','uuid','varchar(50) BINARY');
        $this->createIndex('index_uuid', '{{%article}}', 'uuid');
    }

    public function safeDown()
    {
        $this->dropTable('{{%article}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171114065247Create_article_table cannot be reverted.\n";

        return false;
    }
    */
}
