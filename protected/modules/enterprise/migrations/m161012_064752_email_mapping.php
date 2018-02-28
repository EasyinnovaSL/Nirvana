<?php

use yii\db\Migration;

class m161012_064752_email_mapping extends Migration
{
    public function up()
    {
        $this->addColumn('group', 'enterprise_email_map', $this->text()->null());
    }

    public function down()
    {
        echo "m161012_064752_email_mapping cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
