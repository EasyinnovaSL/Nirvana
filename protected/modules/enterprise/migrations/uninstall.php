<?php

use yii\db\Migration;

class uninstall extends Migration
{

    public function up()
    {
        $this->dropTable('space_type');
        $this->dropColumn('space', 'space_type_id');
        $this->dropTable('enterprise_ldap_space');
        $this->dropTable('enterprise_ldap_group');
        $this->dropColumn('group', 'enterprise_email_map');
    }

    public function down()
    {
        echo "uninstall does not support migration down.\n";
        return false;
    }

}
