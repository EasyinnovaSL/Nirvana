<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use humhub\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <!-- start: Meta -->
        <meta charset="utf-8">
        <title><?php echo $this->pageTitle; ?></title>
        <!-- end: Meta -->

        <!-- start: Mobile Specific -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- end: Mobile Specific -->
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>

        <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="<?php echo Yii::getAlias("@web"); ?>/js/html5shiv.js"></script>
        <
        link
        id = "ie-style"
        href = "<?php echo Yii::getAlias("
        @
        web
        "); ?>/css/ie.css"
        rel = "stylesheet" >
        <![endif]-->

        <!--[if IE 9]>
        <link id="ie9style" href="<?php echo Yii::getAlias("@web"); ?>/css/ie9.css" rel="stylesheet">
        <![endif]-->

        <!-- start: render additional head (css and js files) -->
        <?php echo $this->render('head'); ?>
        <!-- end: render additional head -->


        <!-- start: Favicon and Touch Icons -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?= $this->theme->getBaseUrl() ?>/ico/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= $this->theme->getBaseUrl() ?>/ico/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72"
              href="<?= $this->theme->getBaseUrl() ?>/ico/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= $this->theme->getBaseUrl() ?>/ico/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114"
              href="<?= $this->theme->getBaseUrl() ?>/ico/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120"
              href="<?= $this->theme->getBaseUrl() ?>/ico/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144"
              href="<?= $this->theme->getBaseUrl() ?>/ico/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152"
              href="<?= $this->theme->getBaseUrl() ?>/ico/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180"
              href="<?= $this->theme->getBaseUrl() ?>/ico/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"
              href="<?= $this->theme->getBaseUrl() ?>/ico/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32"
              href="<?= $this->theme->getBaseUrl() ?>/ico/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96"
              href="<?= $this->theme->getBaseUrl() ?>/ico/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16"
              href="<?= $this->theme->getBaseUrl() ?>/ico/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <meta charset="<?= Yii::$app->charset ?>">
        <!-- end: Favicon and Touch Icons -->

    </head>

    <body>
    <?php $this->beginBody() ?>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">


            <?php echo \humhub\widgets\SiteLogo::widget(); ?><br>



            <?php echo \humhub\widgets\TopMenu::widget(); ?>
            <div id="hide-sidebar">
                <a href="#menu-toggle" class="menu-toggle"
                   class="dropdown-toggle"><i class="fa fa-times"></i></a>
            </div>


            <?php //echo \humhub\modules\enterprise\widgets\SpaceChooser::widget(); ?>
            <?php echo \humhub\modules\enterprise\modules\spacetype\widgets\Chooser::widget(); ?>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-md">

                        <!-- start: first top navigation bar -->
                        <div id="topbar-first" class="topbar">

                            <div id="rp-nav" class="nav pull-left">
                                <ul class="nav pull-left navigation-bars">

                                    <li class="dropdown">
                                        <a href="#menu-toggle" class="menu-toggle"
                                           class="dropdown-toggle">
                                            <i class="fa fa-bars"></i></a>
                                    </li>
                                </ul>

                                <div class="menu-seperator"></div>
                            </div>

                            <div class="nav pull-left nav-search">
                                <?php echo Html::beginForm(Url::to(['//search/search/index']), 'GET'); ?>
                                <div class="form-group form-group-search">
                                    <?php echo Html::textInput('keyword', '', array('placeholder' => Yii::t('base', 'Search'), 'class' => 'form-control form-search', 'id' => 'search-input-field')); ?>
                                    <?php echo Html::submitButton(Yii::t('base', 'Search'), array('class' => 'btn btn-default btn-sm form-button-search hidden')); ?>
                                </div>
                                <?php echo Html::endForm(); ?>
                            </div>




                            <div class="topbar-actions pull-right">


                                <ul class="nav pull-left" id="search-menu-nav">
                                    <?php echo \humhub\widgets\TopMenuRightStack::widget(); ?>
                                </ul>

                                <div class="menu-seperator"></div>


                                <div class="notifications">
                                    <?php
                                    echo \humhub\widgets\NotificationArea::widget(['widgets' => [
                                        [\humhub\modules\notification\widgets\Overview::className(), [], ['sortOrder' => 10]],
                                    ]]);
                                    ?>
                                </div>

                                <div class="menu-seperator"></div>


                                <?php // echo \humhub\modules\user\widgets\AccountTopMenu::widget(); ?>
                                <?php echo \humhub\modules\loginUsers\widgets\AccountTopMenu::widget(); ?>
                                <?php echo \humhub\modules\loginUsers\widgets\EenForm::widget(); ?>
                                <?php echo \humhub\modules\help\widgets\InteractiveGuidedTourPage::widget(); ?>

                            </div>


                        </div>

                        <div class="content">

                            <?php echo \humhub\modules\tour\widgets\Tour::widget(); ?>

                            <!-- start: show content (and check, if exists a sublayout -->
                            <?php if (isset($this->context->subLayout) && $this->context->subLayout != "") : ?>
                                <?php echo $this->render($this->context->subLayout, array('content' => $content)); ?>
                            <?php else: ?>
                                <?php echo $content; ?>
                            <?php endif; ?>
                            <!-- end: show content -->

                        </div>

                        <!-- start: Modal (every lightbox will/should use this construct to show content)-->
                        <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <?php echo \humhub\widgets\LoaderWidget::widget(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end: Modal -->


                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->


    <!-- Menu Toggle Script -->
    <script type="text/javascript">

        var mq = window.matchMedia( "(max-width: 768px)" );

        if(mq.matches) {
            var navHeight = $('.space-nav:first').height();
            if(navHeight > 38) {
                var dif = navHeight - 38;
                $('.space-layout-container').animate({'margin-top' : '+='+dif}, 0);
            }
        }
        
        
        $(".menu-toggle").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");

            if ($('#wrapper').css('padding-left') == "250px") {
                $('#rp-nav').css('display', 'block');
                $('#topbar-first').css('padding-left', '0');

                if (mq.matches) {
                    $('#topbar-first div').removeClass('hidden');
                    $('.space-nav .nav').removeClass('hidden');
                    $('#rsp-backdrop').remove();
                }

            } else {
                $('#rp-nav').css('display', 'none');
                $('#topbar-first').css('padding-left', '250px');

                if (mq.matches) {
                    $('#topbar-first div').addClass('hidden');
                    $('.space-nav .nav').addClass('hidden');

                    $('#page-content-wrapper').append('<div id="rsp-backdrop" class="modal-backdrop in" style="z-index: 940;"></div>');
                }
            }
        });

    </script>

    <?php echo \humhub\models\Setting::GetText('trackingHtmlCode'); ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>