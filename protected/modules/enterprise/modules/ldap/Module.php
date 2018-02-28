<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\ldap;

use Yii;
use yii\helpers\Url;
use humhub\models\Setting;

/**
 * Space Types
 *
 * @author Luke
 */
class Module extends \humhub\components\Module
{

    /**
     * @deprecated since version 1.1
     * @var \humhub\modules\enterprise\modules\ldap\models\Space[] Map
     */
    private static $_spaceMappings = null;

    /**
     * @deprecated since version 1.1
     * @var \humhub\modules\enterprise\modules\ldap\models\Group[] Map
     */
    private static $_groupMappings = null;

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'humhub\modules\enterprise\modules\ldap\controllers';

    /**
     * @var array cached list of parent groups
     */
    protected static $_ldapParentGroups = [];

    /**
     * Replace LDAP AuthClient with Enterprise 
     * 
     * @since 1.1
     * @param \yii\base\Event $event
     */
    public static function onAuthClientCollectionInit($event)
    {
        foreach ($event->sender->getClients(false) as $id => $config) {
            if (is_array($config) && isset($config['class']) && $config['class'] == 'humhub\modules\user\authclient\ZendLdapClient') {
                $config['class'] = 'humhub\modules\enterprise\modules\ldap\authclient\ZendLdapClientEnterprise';
                $event->sender->setClient($id, $config);
            }
        }
    }

    public static function onSpaceMemberMenuInit($event)
    {
        if (!Yii::$app->user->isAdmin()) {
            return;
        }

        if (!Setting::Get('enabled', 'authentication_ldap')) {
            return;
        }

        $event->sender->addItem(array(
            'label' => Yii::t('EnterpriseModule.ldap', 'LDAP'),
            'sortOrder' => 1000,
            'isActive' => (Yii::$app->controller->id == 'space' && Yii::$app->controller->module->id == 'ldap'),
            'url' => $event->sender->space->createUrl('/enterprise/ldap/space/index'),
        ));
    }

    public static function onAdminGroupMenuInit($event)
    {
        if (!Setting::Get('enabled', 'authentication_ldap')) {
            return;
        }

        $event->sender->addItem(array(
            'label' => Yii::t('EnterpriseModule.ldap', 'LDAP Mapping'),
            'sortOrder' => 1000,
            'isActive' => (Yii::$app->controller->id == 'group' && Yii::$app->controller->module->id == 'ldap'),
            'url' => Url::to(['/enterprise/ldap/group/index', 'groupId' => $event->sender->group->id]),
        ));
    }

    public static function onGroupDelete($event)
    {
        models\Group::deleteAll(['group_id' => $event->sender->id]);
    }

    public static function onSpaceDelete($event)
    {
        models\Space::deleteAll(['space_id' => $event->sender->id]);
    }

    /**
     * @deprecated since version 1.1
     * @param type $event
     */
    public static function onUpdateUser($event)
    {
        $node = $event->parameters['node'];
        $user = $event->parameters['user'];
        $ldap = $event->sender->ldap;

        // Load space mappings
        if (self::$_spaceMappings === null) {
            self::$_spaceMappings = models\Space::find()->with(['space'])->all();
        }

        // Load group mappings
        if (self::$_groupMappings === null) {
            self::$_groupMappings = models\Group::find()->all();
        }

        // Build group array, including inherited groups
        $memberOf = [];
        foreach ($node->getAttribute('memberOf') as $groupDn) {
            $memberOf[] = $groupDn;
            if (Yii::$app->getModule('enterprise')->enableLdapParentMembershipLookup) {
                $memberOf = array_merge(self::getLdapParentGroups($groupDn, $ldap), $memberOf);
            }
        }
        $memberOf = array_unique($memberOf);

        // Update user's space memberships
        foreach (self::$_spaceMappings as $spaceMapping) {
            if (in_array($spaceMapping->dn, $memberOf) || strpos($node->getDn(), $spaceMapping->dn) !== false) {
                $spaceMapping->space->addMember($user->id);
            }
        }

        // Update user groups
        foreach (self::$_groupMappings as $groupMapping) {
            if (in_array($groupMapping->dn, $memberOf) || strpos($node->getDn(), $groupMapping->dn) !== false) {
                if ($groupMapping->group_id != $user->group_id) {
                    $user->group_id = $groupMapping->group_id;
                    $user->save();
                }
                break;
            }
        }
    }

    /**
     * Returns parent groups of an given group dn
     * 
     * @param string $groupDn
     * @param \Zend\Ldap\Ldap $ldap
     * @return array list of dns
     */
    public static function getLdapParentGroups($groupDn, $ldap)
    {

        if (!isset(self::$_ldapParentGroups[$groupDn])) {
            self::$_ldapParentGroups[$groupDn] = [];

            try {
                foreach ($ldap->getNode($groupDn)->getAttribute('memberOf') as $parentGroupDn) {
                    self::$_ldapParentGroups[$groupDn][] = $parentGroupDn;
                    self::$_ldapParentGroups[$groupDn] = array_merge(self::getLdapParentGroups($parentGroupDn, $ldap), self::$_ldapParentGroups[$groupDn]);
                }
            } catch (\Exception $ex) {
                Yii::error('Could not get memberOf node: ' . $groupDn . " - Error: " . $ex->getMessage());
            }
        }

        return self::$_ldapParentGroups[$groupDn];
    }

}
