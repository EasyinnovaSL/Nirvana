<?php

use yii\db\Migration;

class m160712_080910_ldap_group extends Migration
{

    public function up()
    {
        try {
            $this->addColumn('group_user', 'added_by_ldap', $this->boolean()->defaultValue(false));
        } catch (Exception $ex) {
            
        }
    }

    public function down()
    {
        echo "m160712_080910_ldap_group cannot be reverted.\n";

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
