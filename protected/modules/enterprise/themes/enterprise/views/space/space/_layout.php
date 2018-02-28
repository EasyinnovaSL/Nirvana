<?php
$space = $this->context->contentContainer;

use humhub\modules\content\components\ContentContainerController;
use humhub\modules\space\models\Space;

?>


<div class="space-nav">
    <div class="container-fluid">
        <ul class="nav navbar-nav pull-left space-details">
            <li class="dropdown">
                <?php
                $currentSpace = null;
                if (Yii::$app->controller instanceof ContentContainerController && Yii::$app->controller->contentContainer instanceof Space) {
                    $currentSpace = Yii::$app->controller->contentContainer;
                }

                ?>
                <?php if ($currentSpace) { ?>
<!--                    <img
                        src="<?php /*echo $currentSpace->getProfileImage()->getUrl(); */?>"
                        width="24" height="24" alt="24x24"
                        style="width: 24px; height: 24px;" class="img-rounded"/>-->
                    <?php echo \humhub\modules\space\widgets\Image::widget([
                        'space' => $currentSpace,
                        'width' => 24,
                    ]); ?>

                    <div class="space-title"> <?php echo $currentSpace->name; ?> <space class="seperator"><i class="fa fa-angle-right"></i></space></div>
                <?php } ?>

            </li>

        </ul>

        <ul class="nav navbar-nav">
            <?php echo \humhub\modules\space\widgets\Menu::widget(['space' => $space]); ?>
        </ul>

        <div class="nav navbar-nav pull-right">

            <?php
            echo humhub\modules\space\widgets\HeaderControls::widget(['widgets' => [
                [\humhub\modules\space\widgets\InviteButton::className(), ['space' => $space], ['sortOrder' => 10]],
                [\humhub\modules\space\widgets\MembershipButton::className(), ['space' => $space], ['sortOrder' => 20]],
                [\humhub\modules\space\widgets\FollowButton::className(), ['space' => $space], ['sortOrder' => 30]]
            ]]);
            ?>

            <?php echo humhub\modules\space\modules\manage\widgets\Menu::widget(['space' => $space, 'template' => '@humhub/widgets/views/dropdownNavigation']); ?>

        </div>
    </div>

</div>


<div class="container-fluid space-layout-container">

    <div class="row">

        <?php if (isset($this->context->hideSidebar) && $this->context->hideSidebar) : ?>
            <div class="col-md-12 layout-content-container">
                <?php echo $content; ?>
            </div>
        <?php else: ?>
            <div class="col-md-8 layout-content-container">
                <?php echo $content; ?>
            </div>
            <div class="col-md-4 layout-sidebar-container">
                <?php
                echo \humhub\modules\space\widgets\Sidebar::widget(['space' => $space, 'widgets' => [
                    [\humhub\modules\activity\widgets\Stream::className(), ['streamAction' => '/space/space/stream', 'contentContainer' => $space], ['sortOrder' => 10]],
                    [\humhub\modules\space\modules\manage\widgets\PendingApprovals::className(), ['space' => $space], ['sortOrder' => 20]],
                    [\humhub\modules\space\widgets\Members::className(), ['space' => $space], ['sortOrder' => 30]]
                ]]);
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>