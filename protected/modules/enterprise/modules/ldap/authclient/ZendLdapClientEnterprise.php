<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace humhub\modules\enterprise\modules\ldap\authclient;

use Yii;

/**
 * LDAP Authentication
 * 
 * @todo create base ldap authentication, to bypass ApprovalByPass Interface
 */
class ZendLdapClientEnterprise extends \humhub\modules\user\authclient\ZendLdapClient
{

    /**
     * @var \humhub\modules\enterprise\modules\ldap\models\Space[] Map
     */
    private static $_spaceMappings = null;

    /**
     * @var \humhub\modules\enterprise\modules\ldap\models\Group[] Map
     */
    private static $_groupMappings = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->on(self::EVENT_UPDATE_USER, array($this, 'onUpdateUser'));
        $this->on(self::EVENT_CREATE_USER, array($this, 'onUpdateUser'));
        parent::init();
    }

    /**
     * Ensure group and space mapping
     * 
     * @param \yii\web\UserEvent $event
     */
    public function onUpdateUser($event)
    {
        $user = $event->identity;
        // Load space mappings configured by humhub
        if (self::$_spaceMappings === null) {
            self::$_spaceMappings = \humhub\modules\enterprise\modules\ldap\models\Space::find()->with(['space'])->all();
        }

        // Load group mappings configured by humhub
        if (self::$_groupMappings === null) {
            self::$_groupMappings = \humhub\modules\enterprise\modules\ldap\models\Group::find()->all();
        }

        $attributes = $this->getUserAttributes();
        
        $dn = "";
        if (isset($attributes['dn'])) {
            $dn = $attributes['dn'];
        }
        $memberships = [];
        if (isset($attributes['memberof'])) {
            $memberships = $attributes['memberof'];
        }
        
        $this->updateSpaceMemberships($user, $dn, $memberships);
        $this->updateGroupMemberships($user, $dn, $memberships);
    }

    protected function updateSpaceMemberships(\humhub\modules\user\models\User $user, $dn, $memberships) 
    {
        
        // Update user's space memberships
        $userLdapSpaceIds = [];
        foreach (self::$_spaceMappings as $spaceMapping) {
            if (in_array($spaceMapping->dn, $memberships) || strpos($dn, $spaceMapping->dn) !== false) {
                // add user as member of space.
                $spaceMapping->space->addMember($user->id);
                $membership = $spaceMapping->space->getMembership($user->id);
                $membership->added_by_ldap = 1;
                $membership->save();
                Yii::info('Added user ' . $user->displayName . ' to space ' . $spaceMapping->space->name . '. (LDAP Space Mapping)');
                $userLdapSpaceIds[] = $spaceMapping->space_id;
            }
        }
        
        // Get all current user group memberships handled by LDAP
        $spaceMembershipsLdap = \humhub\modules\space\models\Membership::find()->with('space')->where(['added_by_ldap' => 1, 'user_id' => $user->id])->all();
        // Remove memberships where the ldap mapping no longer exists for the user 
        foreach ($spaceMembershipsLdap as $spaceMembershipLdap) {
            if (!in_array($spaceMembershipLdap->space_id, $userLdapSpaceIds)) {
                $spaceMembershipLdap->delete();
                Yii::info('Removing user ' . $user->displayName . ' from space ' . $spaceMembershipLdap->space->name . '. (No LDAP Space Mapping anymore)');
            }
        }
    }
    
    protected function updateGroupMemberships(\humhub\modules\user\models\User $user, $dn, $memberships)
    {
        // Make sure user is added to all groups
        $userLdapGroupIds = [];
        foreach (self::$_groupMappings as $groupMapping) {
            if (in_array($groupMapping->dn, $memberships) || strpos($dn, $groupMapping->dn) !== false) {
                if (!$groupMapping->group->isMember($user)) {
                    $newGroupUser = new \humhub\modules\user\models\GroupUser();
                    $newGroupUser->user_id = $user->id;
                    $newGroupUser->group_id = $groupMapping->group_id;
                    $newGroupUser->is_group_manager = false;
                    $newGroupUser->added_by_ldap = 1;
                    if ($newGroupUser->save()) {
                        Yii::info('Added user ' . $user->displayName . ' to group ' . $groupMapping->group->name . '. (LDAP Group Mapping)');
                    } else {
                        Yii::error('Could not add user ' . $user->displayName . ' to group ' . $groupMapping->group->name . '. (LDAP Group Mapping)');
                    }
                }
                $userLdapGroupIds[] = $groupMapping->group_id;
            }
        }

        // Get current user group memberships handled by LDAP
        $groupUsersLdap = \humhub\modules\user\models\GroupUser::find()->with('group')->where(['added_by_ldap' => 1, 'user_id' => $user->id])->all();
        foreach ($groupUsersLdap as $groupUserLdap) {
            if (!in_array($groupUserLdap->group_id, $userLdapGroupIds)) {
                $groupUserLdap->group->removeUser($user);
                Yii::info('Removing user ' . $user->displayName . ' from group ' . $groupUserLdap->group->name . '. (No LDAP Group Mapping anymore)');
            }
        }
    }

}
