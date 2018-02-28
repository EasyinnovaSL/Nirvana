<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user_invite_group`.
 */
class m161129_124641_create_user_invite_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (!in_array('user_invite_group', $this->getDb()->schema->tableNames)) {
            $this->createTable('user_invite_group', [
                'id' => $this->primaryKey(),
                'group_id' =>  'int(11) NULL DEFAULT NULL',
                'user_invite_id' =>  'int(11) NULL DEFAULT NULL',
                'space_role_id' =>  'int(11) NULL DEFAULT NULL'
            ]);


            // add foreign key for table `user_invite_group`
            $this->addForeignKey(
                'fk-user-invite',
                'user_invite_group',
                'user_invite_id',
                'user_invite',
                'id',
                'NO ACTION'
            );


            // add foreign key for table `group`
            $this->addForeignKey(
                'fk-group',
                'user_invite_group',
                'group_id',
                'group',
                'id',
                'NO ACTION'
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {

        // drops foreign key for table `group`
        $this->dropForeignKey(
            'fk-user-invite',
            'user_invite'
        );

        // drops foreign key for table `group`
        $this->dropForeignKey(
            'fk-group',
            'user_invite_group'
        );

        $this->dropTable('user_invite_group');

    }
}
