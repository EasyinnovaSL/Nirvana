<?php

use \yii\helpers\Html;
use \yii\helpers\Url;
use humhub\modules\user\models\User;
?>
<?php $this->registerCssFile("@web/css/custom.css");
if (Yii::$app->user->isGuest): ?>
    <a href="<?php echo Url::toRoute(['/loginUsers/auth/login', 'userType' => INNOVATOR_GROUP_ID]); ?>" class="btn btn-enter" data-target="#globalModal"><?php echo Yii::t("LoginUsersModule.innvators", "Sign in/up Innovators")?></a>
    <a href="<?php echo Url::toRoute(['/loginUsers/auth/login', 'userType' => INNOVATION_ADVISOR_GROUP_ID]); ?>" class="btn btn-enter" data-target="#globalModal"><?php echo Yii::t("LoginUsersModule.innvation_advisors_", "Sign in/up Innovation Advisors")?></a>
<?php else: ?>
    <ul class="nav" id="nameUpperScreenBackground">
        <li class="dropdown account">
            <a href="#" class="dropdown-toggle dropdown-toggle-background-color" data-toggle="dropdown">
                <div class="user-title pull-left hidden-xs">
                    <strong><?php echo Html::encode(Yii::$app->user->getIdentity()->displayName); ?></strong><br/>
                    <span class="truncate" style="font-size: 8px;"><?php
                        $user = User::findOne(['id' => Yii::$app->user->id]);
                        $gs_ = [];
                        foreach ($user->getGroups()->all() as $g_) $gs_[] = $g_->id;
                        $groups=$gs_;
                        if(!in_array(4, $groups)){ echo "Innovation advisor"; } else{ echo "Innovator"; } ?></span><br/>
                    <span class="truncate"><?php echo Html::encode(Yii::$app->user->getIdentity()->profile->title); ?></span>
                </div>

                <img id="user-account-image" class="img-rounded"
                     src="<?php echo Yii::$app->user->getIdentity()->getProfileImage()->getUrl(); ?>"
                     height="32" width="32" alt="32x32" data-src="holder.js/32x32"
                     style="width: 32px; height: 32px;"/>

                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu pull-right">
                <?php foreach ($this->context->getItems() as $item): ?>
                    <?php if ($item['label'] == '---'): ?>
                        <li class="divider"></li>
                        <?php else: ?>
                        <li>
                            <a href="<?php echo $item['url']; ?>">
                                <?php echo $item['icon'] . ' ' .$item['label']; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>
<?php endif; ?>