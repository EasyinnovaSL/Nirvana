<?php
/* @var $this \humhub\components\WebView */
/* @var $currentSpace \humhub\modules\space\models\Space */

use yii\helpers\Url;
use yii\helpers\Html;
use humhub\libs\Helpers;

$this->registerJsFile("@web/resources/space/spacechooser.js");
$this->registerJsVar('scSpaceListUrl', Url::to(['/space/list', 'ajax' => 1]));
?>

<li class="dropdown">
    <a href="#" id="space-menu" class="dropdown-toggle" data-toggle="dropdown">
        <!-- start: Show space image and name if chosen -->
        <?php if ($currentSpace) { ?>
            <?php echo \humhub\modules\space\widgets\Image::widget([
                'space' => $currentSpace,
                'width' => 32,
                'htmlOptions' => [
                    'class' => 'current-space-image',
                ]
            ]); ?>
        <?php } ?>

        <?php
        if (!$currentSpace) {
            echo '<i class="fa fa-dot-circle-o"></i><br>' . Yii::t('SpaceModule.widgets_views_spaceChooser', 'My spaces');
        }
        ?>
        <!-- end: Show space image and name if chosen -->
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" id="space-menu-dropdown">
        <li>
            <form action="" class="dropdown-controls"><input type="text" id="space-menu-search"
                                                             class="form-control"
                                                             autocomplete="off"
                                                             placeholder="<?php echo Yii::t('SpaceModule.spacetype', 'Search'); ?>">

                <div class="search-reset" id="space-search-reset"><i
                        class="fa fa-times-circle"></i></div>
            </form>
        </li>

        <li class="divider"></li>
        <li>
            <ul class="media-list notLoaded" id="space-menu-spaces">
                <?php foreach ($memberships as $membership): ?>
                    <?php
                    $newItems = $membership->countNewItems();
                    $typeTitle = $this->context->getTypeTitle($membership->space);
                    ?>
                    <li>
                        <a href="<?php echo $membership->space->getUrl(); ?>">
                            <div class="media">
                                <!-- Show space image -->
                                <?php echo \humhub\modules\space\widgets\Image::widget([
                                    'space' => $membership->space,
                                    'width' => 24,
                                    'htmlOptions' => [
                                        'class' => 'pull-left',
                                    ]
                                ]); ?>
                                <div class="media-body">
                                    <strong><?php echo Html::encode($membership->space->name); ?></strong>

                                    <?php if ($typeTitle !== "") : ?>
                                        <div class="badge badge-space-type"><?php echo $typeTitle; ?></div>
                                    <?php endif; ?>
                                    <?php if ($newItems != 0): ?>
                                        <div class="badge badge-space pull-right" style="display:none"><?php echo $newItems; ?></div>
                                    <?php endif; ?>
                                    <br>
                                    <p><?php echo Html::encode(Helpers::truncateText($membership->space->description, 60)); ?></p>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>

            </ul>
        </li>
        <?php if (count($createSpaceTypes) !== 0): ?>
            <li>
                <div class="dropdown-footer">
                    <?php foreach ($createSpaceTypes as $type): ?>
                        <?= Html::a(Yii::t('EnterpriseModule.spacetype', '<i class="fa fa-plus"></i> %itemTitle%', ['%itemTitle%' => $type->item_title]), Url::to(['/enterprise/spacetype/create-space/create', 'type_id' => $type->id]), array('class' => 'btn btn-info btn-sm', 'data-target' => '#globalModal')); ?>
                    <?php endforeach; ?>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</li>

<script type="text/javascript">

    // set niceScroll to SpaceChooser menu
    $("#space-menu-spaces").niceScroll({
        cursorwidth: "7",
        cursorborder: "",
        cursorcolor: "#555",
        cursoropacitymax: "0.2",
        railpadding: {top: 0, right: 3, left: 0, bottom: 0}
    });
    jQuery('.badge-space').fadeIn('slow');
</script>
