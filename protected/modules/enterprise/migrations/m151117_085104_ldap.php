<?php

use yii\db\Schema;
use yii\db\Migration;

class m151117_085104_ldap extends Migration
{

    public function up()
    {
        $this->createTable('enterprise_ldap_space', array(
            'id' => Schema::TYPE_PK,
            'space_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'dn' => Schema::TYPE_STRING . ' NOT NULL',
                ), '');

        $this->createTable('enterprise_ldap_group', array(
            'id' => Schema::TYPE_PK,
            'group_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'dn' => Schema::TYPE_STRING . ' NOT NULL',
                ), '');
    }

    public function down()
    {
        echo "m151117_085104_ldap cannot be reverted.\n";

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
