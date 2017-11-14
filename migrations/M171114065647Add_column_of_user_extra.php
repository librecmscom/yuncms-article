<?php

namespace yuncms\article\migrations;

use yii\db\Migration;

class M171114065647Add_column_of_user_extra extends Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%user_extra}}', 'articles', $this->integer()->unsigned()->defaultValue(0)->comment('Articles'));

    }

    public function safeDown()
    {
        $this->dropColumn('{{%user_extra}}', 'articles');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171114065647Add_column_of_user_extra cannot be reverted.\n";

        return false;
    }
    */
}
