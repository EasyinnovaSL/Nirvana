<?php
namespace enterprise\functional\modules\emailwhitelist;

use Yii;
use tests\codeception\_pages\LoginPage;
use FunctionalTester;

class WhitelistCest
{
    public function _before() {
        Yii::$app->getModule('user')->settings->set('auth.anonymousRegistration', true);
        Yii::$app->getModule('user')->settings->set('auth.needApproval', false);
        Yii::$app->settings->set('mailer.systemEmailAddress', 'test@humhub.org');
        Yii::$app->settings->set('mailer.systemEmailName', 'HumHub-test');
        Yii::$app->getModule('enterprise')->settings->set('email.whitelist', '@humhub.org'.PHP_EOL.'@humhub.com'.PHP_EOL.'test@test.com');
    }
    
    public function _after() {
        Yii::$app->getModule('enterprise')->settings->set('email.whitelist', null);
    }
    
    public function testInvalidSelfInvite(FunctionalTester $I)
    {
        $I->wantTo('ensure that invalid emails are not allowed for registration without approval process');
        $loginPage = LoginPage::openBy($I);
        
        $I->amGoingTo('try to invite myself with an invalid email');
        $loginPage->selfInvite('wrong@host.com');
        $I->expectTo('see validations errors');
        $I->see('The given email address is not allowed for registration!');
    }
    
    public function testValidSelfInvite(FunctionalTester $I)
    {
        $I->wantTo('ensure that valid emails are allowed for registration without approval process');
        $loginPage = LoginPage::openBy($I);
        
        $I->amGoingTo('try to invite myself with an valid email');
        $loginPage->selfInvite('user@humhub.com');
        $I->expectTo('see success message');
        $I->see('Registration successful!');
    }
    
    /*
    public function testInvalidDashboardInvite(FunctionalTester $I)
    {
        $I->wantTo('ensure that valid emails are allowed for user invitation without approval process');
        $I->amUser();
        
        $I->amGoingTo('try to invite another user with an invalid email');
        //$I->getModule('Yii2')->_loadPage('POST', '/user/invite', ['Invite[emails]' => $email]);
        $I->inviteUserByEmail('invalid@mail.de');
        $I->expectTo('see validations errors');
        $I->see('The follwing emails do not match the whitelist settings: invalid@mail.de!');
    }*/
}