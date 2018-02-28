<?php

use humhub\modules\help\Assets;
use humhub\modules\help\widgets\InteractiveGuidedTourPage;

$assetsInteractiveGuidedTourPage = Assets::register($this);
?>

<style>

    @import url('https://fonts.googleapis.com/css?family=Roboto:400,700');

    /* intro */
    .enjoy_hint_label {
        position: absolute;
        color: #fff;
        z-index: 107;
        font-size: 22px;
        font-family:Arial;
        -webkit-transition: opacity .4s cubic-bezier(.42,0,.58,1);
        -moz-transition: opacity .4s cubic-bezier(.42,0,.58,1);
        transition: opacity .4s cubic-bezier(.42,0,.58,1);
        display: inline-block;
        min-width: 200px;
        text-align: left!important;
        max-width: 80%;
    }

    .enjoy_hint_label h1, .enjoy_hint_label h2 {
        font-family: Roboto;
        font-weight: 700;
        color: #00E0A5;
    }

    .enjoy_hint_label h1 {
        font-size:40px;}
    .enjoy_hint_label h2 {
        font-size:25px;
        margin-bottom: 30px;
    }
    .enjoy_hint_label h4 {
        font-size:25px;
    }

    .enjoyhint_next_btn, .enjoyhint_skip_btn, .enjoyhint_gotit_btn {
        margin-top: 30px!important;
        position: absolute!important;
        float: left;
        margin-left: auto!important;
        margin-right: auto!important;
        left: 0;
        right: 0;
    }

    .enjoyhint_next_btn{
        left: 0 !important;
    }
    .enjoyhint_skip_btn{
        left: 250px !important;
    }
    .align_photo {
        text-align: right;
    }


</style>

<script>

    var enjoyhint_instance = null;
    var enjoyhint_script_steps = [];


    function createHtmlForInteractiveTutorial(h1Title, h2SubTitle,h4Text, smallImage, bigImage){
        return "<div class='row'><div class='col-md-3 align_photo'><img class='responsive' src='<?php echo $assetsInteractiveGuidedTourPage->baseUrl;?>"+smallImage+"' srcset='<?php echo $assetsInteractiveGuidedTourPage->baseUrl;?>"+bigImage+" 2x'></div><div class='col-md-9'><h1>"+h1Title+"</h1><h2>"+h2SubTitle+"</h2><h4>"+h4Text+"</h4></div></div>";
    }

    $( document ).ready(function() {

        <?php if(isset($userGroupId) && $userGroupId == INNOVATOR_GROUP_ID){?>

        enjoyhint_script_steps = [
            {
                shape:'circle',
                timeout:100,
                showSkip: false,
                'next ul.nav.nav-pills.nav-stacked.nav-space-chooser' : createHtmlForInteractiveTutorial("<?php echo Yii::t('HelpModule.steps', "Welcome to Nirvana!");?>", "<?php echo Yii::t('HelpModule.steps', "Let's see the different sections you have.");?>", "<?php echo Yii::t('HelpModule.steps', "The Dashboard shows the progress of your activities. In Messages you can contact other users in the platform. In the Directory you can find registered Innovation Advisors");?>", '/img/intro1.png', '/img/intro1@2x.png'),
            },
            {
                'next #space-menu-dropdown': createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "Categories");?>", "<?php echo Yii::t('HelpModule.steps',  "All your rooms are classified into different categories"); ?> <br> <br>", '/img/intro3.png', '/img/intro3@2x.png'),
                shape:'rectangular',
                timeout:300,
                onBeforeStart:function(){
                    //$(".space-entries").toggle();
                    $("#sidebar-wrapper").animate({
                        scrollTop: $("#space-menu-dropdown").offset().top
                    }, 500);
                }
            },
            {
                selector:'#space-menu-dropdown li.title:nth-child(2)',
                showNext: true,
                description: createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "PSR Business Offers");?>", "<?php echo Yii::t('HelpModule.steps',  "Partner Search Rooms (PSR) guide you to find partners by creating Partnership Profiles (Business Offers and Requests, Technology Offers and Requests and R&D Requests).<br/>This category is for Business Offers."); ?>", '/img/intro4.png', '/img/intro4@2x.png'),
            },
            {
                selector:'#space-menu-dropdown li.title:nth-child(7)',
                showNext: true,
                description: createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "NIR Business Offers");?>", "<?php echo Yii::t('HelpModule.steps', "Networking Innovation Rooms (NIR) enable you to interact with partners and reach agreements.<br/>This is of type Business Offer."); ?>", '/img/intro5.png', '/img/intro5@2x.png'),
                onBeforeStart:function(){
                    $("#sidebar-wrapper").animate({
                        scrollTop: $("#space-menu-dropdown li.title:nth-child(7)").offset().top
                    }, 500);
                }
            },
            {
                selector:'#space-menu-dropdown li.title:nth-child(11)',
                showNext: true,
                description: createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "Projects archive");?>", "<?php echo Yii::t('HelpModule.steps', "The Projects Archive section keeps inactive rooms, either PSRs or NIRs"); ?>", '/img/intro6.png', '/img/intro6@2x.png'),
                onBeforeStart:function(){
                    $("#sidebar-wrapper").animate({
                        scrollTop: $("#space-menu-dropdown li.title:nth-child(11)").offset().top
                    }, 500);
                }
            },
            {
                'next .notifications': createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "Notifications");?>", "<?php echo Yii::t('HelpModule.steps', "The bell warns you about incoming notifications. Click on it to see them when you see a number on top of it<br/>The envelope warns you about received messages. Click on it to see them when you see a number on top of it<br/>The information icon enables you to run the overlay help according to the section you are in"); ?>", '/img/intro7.png', '/img/intro7@2x.png'),
                shape:'circle',
                timeout: 100
            },
            {
                'click .dropdown.account': createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "Profile options");?>", "<?php echo Yii::t('HelpModule.steps', "This is your user name and profile. Click on it to see the different profile options."); ?>", '/img/intro8.png', '/img/intro8@2x.png'),
                shape:'circle',
                timeout:100,
                "skipButton" : {text: "<?php echo Yii::t('HelpModule.steps',  "GOT IT!");?>"},
            }
        ];



        <?php }else if(isset($userGroupId) && $userGroupId == INNOVATION_ADVISOR_GROUP_ID){?>

        enjoyhint_script_steps = [
            {
                'next ul.nav.nav-pills.nav-stacked.nav-space-chooser' : createHtmlForInteractiveTutorial("<?php echo Yii::t('HelpModule.steps', "Welcome to Nirvana!");?>", "<?php echo Yii::t('HelpModule.steps', "Let's see the different sections you have.");?>", "<?php echo Yii::t('HelpModule.steps', "The Dashboard shows the progress of your activities. In Messages you can contact other users in the platform. In the Directory you can find registered Innovation Advisors");?>", '/img/intro1.png', '/img/intro1@2x.png'),
                shape:'circle',
                timeout:100,
                showSkip: false
            },
            {
                selector:'#create_project_menu_option',
                showNext: true,
                description: createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "Partner Search Room");?>", "<?php echo Yii::t('HelpModule.steps',  "Click here to create an Partner Search Room that will guide you and your client to create a PP. It will guide you and your client to find partners, e.g. by creating Partnership Profiles (Business Offers and Requests, Technology Offers and Requests and R&D Requests)"); ?>", '/img/intro2.png', '/img/intro2@2x.png'),
                shape: 'rect',
                timeout: 100
            },
            {
                'next #space-menu-dropdown': createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "Categories");?>", "<?php echo Yii::t('HelpModule.steps',  "All your rooms are classified into different categories"); ?> <br> <br>", '/img/intro3.png', '/img/intro3@2x.png'),
                shape:'rect',
                timeout: 100,
                onBeforeStart:function(){
                    //$(".space-entries").toggle();
                    $("#sidebar-wrapper").animate({
                        scrollTop: $("#space-menu-dropdown").offset().top
                    }, 500);
                }
            },
            {
                selector:'#space-menu-dropdown li.title:nth-child(2)',
                showNext: true,
                description: createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "PSR Business Offers");?>", "<?php echo Yii::t('HelpModule.steps',  "Partner Search Rooms (PSR) guide you and your client to find partners by creating Partnership Profiles (Business Offers and Requests, Technology Offers and Requests and R&D Requests).<br/>This category is for Business Offers."); ?>", '/img/intro4.png', '/img/intro4@2x.png'),
            },
            {

                selector:'#space-menu-dropdown li.title:nth-child(7)',
                showNext: true,
                description: createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "NIR Business Offers");?>", "<?php echo Yii::t('HelpModule.steps', "Networking Innovation Rooms (NIR) enable your clients to interact with partners and reach agreements.<br/>This is of type Business Offer."); ?>", '/img/intro5.png', '/img/intro5@2x.png'),
                onBeforeStart:function(){
                    $("#sidebar-wrapper").animate({
                        scrollTop: $("#space-menu-dropdown li.title:nth-child(7)").offset().top
                    }, 500);
                }
            },
            {
                selector:'#space-menu-dropdown li.title:nth-child(11)',
                showNext: true,
                //description: "<?php echo Yii::t('HelpModule.steps', "The Projects Archive section keeps inactive rooms, either ARs or NIRs"); ?>",
                description: createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "Projects archive");?>", "<?php echo Yii::t('HelpModule.steps', "The Projects Archive section keeps inactive rooms, either PSRs or NIRs"); ?>", '/img/intro6.png', '/img/intro6@2x.png'),
                onBeforeStart:function(){
                    $("#sidebar-wrapper").animate({
                        scrollTop: $("#space-menu-dropdown li.title:nth-child(11)").offset().top
                    }, 500);
                }
            },
            {
                //'next .notifications' : "<?php echo Yii::t('HelpModule.steps', "The bell warns you about incoming notifications. Click on it to see them when you see a number on top of it<br/>The envelope warns you about received messages. Click on it to see them when you see a number on top of it<br/>The information icon enables you to run the overlay help according to the section you are in"); ?>",
                'next .notifications': createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "Notifications");?>", "<?php echo Yii::t('HelpModule.steps', "The bell warns you about incoming notifications. Click on it to see them when you see a number on top of it<br/>The envelope warns you about received messages. Click on it to see them when you see a number on top of it<br/>The information icon enables you to run the overlay help according to the section you are in"); ?>", '/img/intro7.png', '/img/intro7@2x.png'),
                shape:'circle',
                timeout: 100
            },
            {
                //'click .dropdown.account' : "<?php echo Yii::t('HelpModule.steps', "This is your user name and profile. Click on it to see the different profile options."); ?>",
                'click .dropdown.account': createHtmlForInteractiveTutorial("","<?php echo Yii::t('HelpModule.steps',  "Profile options");?>", "<?php echo Yii::t('HelpModule.steps', "This is your user name and profile. Click on it to see the different profile options."); ?>", '/img/intro8.png', '/img/intro8@2x.png'),
                shape:'circle',
                timeout: 100,
                "skipButton" : {text: "<?php echo Yii::t('HelpModule.steps',  "GOT IT!");?>"},
            }
        ];

        <?php } ?>


        <?php if(isset($loadAndRunTutorialScript) && $loadAndRunTutorialScript == InteractiveGuidedTourPage::LOAD_AND_RUN){?>
                runInteractiveTutorialAndSaveState();
        <?php }?>
    });


    function runInteractiveTutorialAndSaveState(){
        enjoyhint_instance = new EnjoyHint({});
        enjoyhint_instance.setScript(enjoyhint_script_steps);
        enjoyhint_instance.runScript();

        $.ajax({
            type: "post",
            url: "<?php echo Yii::$app->urlManager->createUrl('/help/interactive-tutorial/save-state-interactive-tutorial'); ?>",
            data: {"tutorial_page_name": "<?php echo InteractiveGuidedTourPage::PAGE_DASHBOARD?>", "page_url": "<?php echo $page_url?>"},
            success: function( data ) {
                /* Nothing to do here yet */
            }
        });
    }

</script>
