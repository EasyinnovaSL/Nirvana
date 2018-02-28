<?php

use yii\db\Migration;

class m160712_091704_fks extends Migration
{

    public function up()
    {
        $this->addForeignKey('fk-ldapgroup-group', 'enterprise_ldap_group', 'group_id', 'group', 'id', 'CASCADE');
        $this->addForeignKey('fk-ldapspace-space', 'enterprise_ldap_space', 'space_id', '`space`', 'id', 'CASCADE');
    }

    public function down()
    {
        echo "m160712_091704_fks cannot be reverted.\n";

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
