<?php

namespace tests\codeception\unit\modules\emailwhitelist;

use Yii;
use tests\codeception\_support\HumHubDbTestCase;
use Codeception\Specify;
use tests\codeception\fixtures\UserFixture;
use tests\codeception\fixtures\GroupFixture;
use tests\codeception\fixtures\InviteFixture;
use humhub\modules\enterprise\modules\emailwhitelist\models\forms\WhitelistSettingsForm;

class InviteModelTest extends HumHubDbTestCase
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
        
        $form = new WhitelistSettingsForm();
        $form->whitelist = '@humhub.org'.PHP_EOL.'@humhub.com'.PHP_EOL.'test@test.com';
        $form->save();
    }
    
    /**
     * Tests accidental space in one email rule
     */
    public function testSpacedEmailRule()
    {
       $form = new WhitelistSettingsForm();
       $form->whitelist = '@humhub.org'.PHP_EOL.'@humhub.com '.PHP_EOL.'test@test.com';
       $form->save();
        
       Yii::$app->getModule('user')->settings->set('auth.needApproval', false);
       $invite = new \humhub\modules\user\models\Invite();
       $invite->email = 'valid@humhub.com';
       $this->assertTrue($invite->validate());
    }
    
    /**
     * Tests accidental space in one email rule
     */
    public function testEmptyEmail()
    {
       $form = new WhitelistSettingsForm();
       $form->whitelist = '@humhub.org'.PHP_EOL.'@humhub.com '.PHP_EOL.'test@test.com';
       $form->save();
        
       Yii::$app->getModule('user')->settings->set('auth.needApproval', false);
       $invite = new \humhub\modules\user\models\Invite();
       $invite->email = '';
       $this->tester->assertNotContainsError($invite, 'The given email address is not allowed for registration!');
    }
    
    /**
     * Tests exact email rule
     */
    public function testExactlRule()
    {
        $form = new WhitelistSettingsForm();
        $form->whitelist = '@humhub.org'.PHP_EOL.'@humhub.com '.PHP_EOL.'test@test.com';
        $form->save();
        
       Yii::$app->getModule('user')->settings->set('auth.needApproval', false);
       $invite = new \humhub\modules\user\models\Invite();
       $invite->email = 'test@test.com';
       $this->assertTrue($invite->validate());
       
    }

    /**
     * Tests model validation with invalid email
     */
    public function testModelInviteWithInvalidEmailNoApproval()
    {
       Yii::$app->getModule('user')->settings->set('auth.needApproval', false);
       $invite = new \humhub\modules\user\models\Invite();
       $invite->email = 'invalid@host.de';
       $this->assertFalse($invite->validate());
       $this->tester->assertContainsError($invite, 'The given email address is not allowed for registration!');
    }
    
    /**
     * Tests model validation with invalid email
     */
    public function testModelInviteWithValidEmailNoApproval()
    {
       Yii::$app->getModule('user')->settings->set('auth.needApproval', false);
       $invite = new \humhub\modules\user\models\Invite();
       $invite->email = 'test@humhub.org';
       $this->assertTrue($invite->validate());
    }
    
}
