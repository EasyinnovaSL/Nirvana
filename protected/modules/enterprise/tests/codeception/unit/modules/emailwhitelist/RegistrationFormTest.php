<?php

namespace tests\codeception\unit\modules\emailwhitelist;

use Yii;
use yii\codeception\DbTestCase;
use Codeception\Specify;
use tests\codeception\fixtures\UserFixture;
use tests\codeception\fixtures\GroupFixture;
use tests\codeception\fixtures\InviteFixture;
use humhub\modules\enterprise\modules\emailwhitelist\models\forms\WhitelistSettingsForm;

class RegistrationFormTest extends DbTestCase
{

    use Specify;

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
            ],
            'invite' => [
                'class' => InviteFixture::className(),
            ],
            'group' => [
                'class' => GroupFixture::className(),
            ],
        ];
    }

    protected function setUp()
    {
        parent::setUp();
        Yii::$app->cache->flush();
        Yii::$app->getModule('user')->settings->set('auth.anonymousRegistration', true);
        
        Yii::$app->settings->set('mailer.transportType', 'file');
        Yii::$app->settings->set('mailer.systemEmailAddress', 'test@humhub.org');
        Yii::$app->settings->set('mailer.systemEmailName', 'HumHub-test');
        Yii::$app->getModule('enterprise')->settings->set('email.whitelist', '@humhub.org'.PHP_EOL.'@humhub.com'.PHP_EOL.'test@test.com');
    }
    
    /**
     * Test registration with empty whitelist and no approval process -> all new users should be enabled
     */
    public function testNoWhitelistNoApproval()
    {
        Yii::$app->getModule('user')->settings->set('auth.needApproval', false);
        
        $form = new WhitelistSettingsForm();
        $form->whitelist = '';
        $form->save();
        
        $registration = new \humhub\modules\user\models\forms\Registration();
        $registration->submitted('submit');
        $registration->models['User']->email = 'invalid@host.de';
        $registration->models['User']->username = 'test';
        $registration->validate();
        $registration->register();
        $this->assertEquals(\humhub\modules\user\models\User::STATUS_ENABLED, $registration->models['User']->status);
    }
    
    /**
     * Test registration with empty whitelist and approval process -> all new users should be in state need approval
     */
    public function testNoWhitelistWithApproval()
    {
        Yii::$app->getModule('user')->settings->set('auth.needApproval', true);
        
        $form = new WhitelistSettingsForm();
        $form->whitelist = '';
        $form->save();
        
        $registration = new \humhub\modules\user\models\forms\Registration();
        $registration->submitted('submit');
        $registration->models['User']->email = 'invalid@host.de';
        $registration->models['User']->username = 'test';
        $registration->validate();
        $registration->register();
        $this->assertEquals(\humhub\modules\user\models\User::STATUS_NEED_APPROVAL, $registration->models['User']->status);
    }
    
    /**
     * Test registration with empty whitelist and approval process -> all new users should be in state need approval
     */
    public function testTrimWhitelist()
    {
        Yii::$app->getModule('user')->settings->set('auth.needApproval', true);
        
        $form = new WhitelistSettingsForm();
        $form->whitelist = '   ';
        $form->save();
        
        $registration = new \humhub\modules\user\models\forms\Registration();
        $registration->submitted('submit');
        $registration->models['User']->email = 'invalid@host.de';
        $registration->models['User']->username = 'test';
        $registration->validate();
        $registration->register();
        $this->assertEquals(\humhub\modules\user\models\User::STATUS_NEED_APPROVAL, $registration->models['User']->status);
    }
    
    
    /**
     * Test registration with whitelist and invalid email (no approval process) -> user should be disabled.
     * This can only occure if the invite email is somehow different from the registration email.
     */
    public function testInvalidEmailNoApproval()
    {
        Yii::$app->getModule('user')->settings->set('auth.needApproval', false);
        $registration = new \humhub\modules\user\models\forms\Registration();
        $registration->submitted('submit');
        $registration->models['User']->email = 'invalid@host.de';
        $registration->models['User']->username = 'test';
        $registration->validate();
        $this->assertEquals(\humhub\modules\user\models\User::STATUS_DISABLED, $registration->models['User']->status);
    }
    
    /**
     * Test registration with whitelist and valid email (with approval process) -> user should be enabled.
     */
    public function testInvalidEmailWithApproval()
    {
        Yii::$app->getModule('user')->settings->set('auth.needApproval', true);
        $registration = new \humhub\modules\user\models\forms\Registration();
        $registration->submitted('submit');
        $registration->models['User']->email = 'invalid@host.de';
        $registration->models['User']->username = 'test';
        $registration->validate();
        $registration->register();
        $this->assertEquals(\humhub\modules\user\models\User::STATUS_NEED_APPROVAL, $registration->models['User']->status);
    }
    
    /**
     * Test registration with whitelist and valid email (no approval process) -> user should be enabled.
     */
    public function testValidEmailWithNoApproval()
    {
        Yii::$app->getModule('user')->settings->set('auth.needApproval', false);
        $registration = new \humhub\modules\user\models\forms\Registration();
        $registration->submitted('submit');
        $registration->models['User']->email = 'invalid@humhub.org';
        $registration->models['User']->username = 'test';
        $registration->validate();
        $registration->register();
        $this->assertEquals(\humhub\modules\user\models\User::STATUS_ENABLED, $registration->models['User']->status);
    }
    
    /**
     * Test registration with whitelist and valid email (with approval process) -> user should be enabled.
     */
    public function testValidEmailWithApproval()
    {
        Yii::$app->getModule('user')->settings->set('auth.needApproval', true);
        $registration = new \humhub\modules\user\models\forms\Registration();
        $registration->submitted('submit');
        $registration->models['User']->email = 'invalid@humhub.org';
        $registration->models['User']->username = 'test';
        $registration->validate();
        $registration->register();
        $this->assertEquals(\humhub\modules\user\models\User::STATUS_ENABLED, $registration->models['User']->status);
    }
}
