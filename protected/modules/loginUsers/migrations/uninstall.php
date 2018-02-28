<?php

use yii\db\Migration;

class uninstall extends Migration
{

    public function up()
    {
        $this->dropTable('user_invite_group');
    }

    public function down()
    {
        echo "m131023_165956_initial does not support migration down.\n";
        return false;
    }

}
