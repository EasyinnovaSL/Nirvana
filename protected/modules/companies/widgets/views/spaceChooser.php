<?php
use yii\helpers\Html;
use yii\helpers\Url;

humhub\modules\companies\Assets::register($this);

$this->registerJsFile("@web/resources/space/spacechooser.js");
$this->registerJsVar('scSpaceListUrl', Url::to(['/space/list', 'ajax' => 1]));

?>
<style>

</style>
<?php
$colors = ['fc4a64', '77e88e', 'ad8bd4', '40b1d0', 'ff987e', '8c91a9'];
?>
<?php
if($canCreateSpace && !in_array(4, $groups)):
    ?>
    <ul class="nav nav-pills nav-stacked nav-space-chooser">
        <li id="create_project_menu_option">
            <?php
            echo Html::a('<i class="fa fa-plus-square"></i> '.Yii::t('CompaniesModule.base', 'Partner Search Room (PSR)'),
                Url::to(['/companies/create-space/create']), array('data-target' => '#globalModal'));

            ?>
        </li>
    </ul>
    <?php
endif;
?>

<ul class="nav nav-pills nav-stacked nav-space-chooser" id="space-menu-dropdown">

    <li class="search">
        <form action="" class="dropdown-controls"><input type="text" id="space-menu-search"
                                                         class="form-control form-search"
                                                         autocomplete="off"
                                                         placeholder="<?php echo Yii::t('SpaceModule.widgets_views_spaceChooser', 'Filter'); ?>">

            <div class="search-reset" id="space-search-reset"><i
                    class="fa fa-times-circle"></i></div>
        </form>
    </li>

    <?php foreach ($typeMembershipMap as $entry) : ?>
        <li class="title <?php echo (isset($currentSpace->space_type_id) && $currentSpace->space_type_id == $entry['spaceType']->id) ? 'open' : ''; ?>">
          <span class="titlespacetype">
            <?php print_r($entry['spaceType']->title); ?>
              <?php if ($entry['memberships']) : ?>
                  <span class="title-link">
                <?php
                echo Html::a('<i class="fa fa-angle-down"></i>', Url::to(['#']));
                ?> </span>
              <?php endif; ?>
          </span>

            <ul class="space-entries">
                <?php foreach ($entry['memberships'] as $membership): ?>
                    <?php $newItems = $membership->countNewItems(); ?>
                    <li role="presentation" class="<?php if ($currentSpace) {
                        if ($currentSpace->id == $membership->space->id) {
                            echo "active";
                        }
                    } ?>">
                        <a href="<?php echo $membership->space->getUrl(); ?>">
                            <div class="media">
                                <div class="media-left">
                                    <!-- Show space image -->
                                    <?php echo \humhub\modules\space\widgets\Image::widget([
                                        'space' => $membership->space,
                                        'width' => 24,
                                        'htmlOptions' => [
                                            'class' => 'pull-left',
                                            'style' => 'border: 2px solid ' . $membership->space->color . ';',
                                        ]
                                    ]); ?>
                                </div>
                                <div class="media-body">
                                    <?php echo Html::encode(\humhub\libs\Helpers::trimText($membership->space->name, 18)); ?>
                                    <?php if ($newItems != 0): ?>
                                        <div class="badge badge-space pull-right"><?php echo $newItems; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>

    <?php endforeach; ?>
</ul>

<script type="text/javascript">

    // set niceScroll to space chooser
    /*
     $(".nav-space-chooser").niceScroll({
     cursorwidth: "7",
     cursorborder: "",
     cursorcolor: "#555",
     cursoropacitymax: "0.4",
     railpadding: {top: 0, right: 3, left: 0, bottom: 0}
     });
     */
    $('.badge-space').fadeIn('slow');

    $('.title span a').on('click', function(event) {
        event.preventDefault();
       // $(this).parents('li').find('ul').toggle();

        var element=$(this).parents('li').find('ul');
        ( $(element).is(':visible'))? $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up') : $(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
        element.toggle();

    });

</script>