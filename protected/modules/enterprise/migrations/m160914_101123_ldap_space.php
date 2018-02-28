<?php

use yii\db\Migration;

class m160914_101123_ldap_space extends Migration
{

    public function up()
    {
        try {
            $this->addColumn('space_membership', 'added_by_ldap', $this->boolean()->defaultValue(false));
        } catch (Exception $ex) {
            
        }
    }

    public function down()
    {
        echo "m160914_101123_ldap_space cannot be reverted.\n";

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
