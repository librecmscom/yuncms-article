<?php

namespace yuncms\article\migrations;

use yii\db\Migration;

class M171114065543Create_article_tag_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%article_tag}}', [
            'article_id' => $this->integer()->unsigned()->comment('Article ID'),
            'tag_id' => $this->integer()->unsigned()->comment('Tag ID'),
        ], $tableOptions);
        $this->createIndex('article_id', '{{%article_tag}}', 'article_id');
        $this->createIndex('tag_id', '{{%article_tag}}', 'tag_id');

    }

    public function safeDown()
    {
        $this->dropTable('{{%article_tag}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171114065543Create_article_tag_table cannot be reverted.\n";

        return false;
    }
    */
}
