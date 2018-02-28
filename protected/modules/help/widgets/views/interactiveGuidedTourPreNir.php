<?php

use humhub\modules\help\Assets;
use humhub\modules\help\widgets\InteractiveGuidedTourPage;

$assetsInteractiveGuidedTourPreNirPage = Assets::register($this);

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
        margin-right: auto!important;
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

</style>


<script>
    var enjoyhint_instance = null;
    var enjoyhint_script_steps = [];
    var enjoyhint_script_steps_accept_invitation = [];
    var enjoyhint_script_steps_start_button = [];
    var enjoyhint_script_steps_without_cards = [];
    var enjoyhint_script_steps_with_cards = [];

    var tutorial_page_name = "<?php echo InteractiveGuidedTourPage::PAGE_PRENIR?>";

    <?php
            $js_array = json_encode($lastInteractiveTutorialShowed);
            echo "var lastInteractiveTutorialShowed = ". $js_array . ";\n";
    ?>


    function createHtmlForInteractiveTutorial(h1Title, h2SubTitle,h4Text, smallImage, bigImage){
        if(smallImage != ''){
            return "<div class='row'><div class='col-md-3'><img class='responsive' src='<?php echo $assetsInteractiveGuidedTourPreNirPage->baseUrl;?>"+smallImage+"' srcset='<?php echo $assetsInteractiveGuidedTourPreNirPage->baseUrl;?>"+bigImage+" 2x'></div><div class='col-md-9'><h1>"+h1Title+"</h1><h2>"+h2SubTitle+"</h2><h4>"+h4Text+"</h4></div></div>";
        }else{
            return "<div class='row'><div class='col-md-12'><h1>"+h1Title+"</h1><h2>"+h2SubTitle+"</h2><h4>"+h4Text+"</h4></div></div>";
        }
    }



    <?php if(isset($userGroupId) && $userGroupId == INNOVATOR_GROUP_ID){?>

    enjoyhint_script_steps_accept_invitation = [
        {
            selector: '#text-for-user',
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Partner Search Room");?>","<?php echo Yii::t('HelpModule.steps',  "This explains how the room works<br/>Please read it first"); ?>", '', ''),
            showNext: true,
            shape: 'rect',
            timeout: 100,
        },
        {
            selector: '#invite-options-button',
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Choose an option");?>","<?php echo Yii::t('HelpModule.steps',  "You need to accept or decline the invite"); ?>", '', ''),
            showNext: false,
            event: 'click',
            shape: 'rect',
            timeout: 100,
        }
    ];

    enjoyhint_script_steps_start_button = [
        {
            selector: '#start-button',
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Start Process");?>","<?php echo Yii::t('HelpModule.steps',  "And finally click the Start button"); ?>", '', ''),
            showNext: true,
            event: 'click',
            shape: 'rect',
            timeout: 100
        }
    ];

    enjoyhint_script_steps_without_cards = [
        {
            'next a.active': createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "What's next");?>", "<?php echo Yii::t('HelpModule.steps', " This option, guides you through the process<br/>If you ever get lost, just click here");?>", '', ''),
            shape: 'circle',
            timeout: 100,
            showSkip: false
        },
        {
            selector: '.nav.navbar-nav:nth-child(2)',
            showNext: true,
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Space Options");?>", "<?php echo Yii::t('HelpModule.steps',  "<strong>Tasks:</strong> can be used to create assignments<br/><strong>Polls:</strong> can be used to ask other participants about specific things<br/><strong>Files:</strong> contains any document shared in the room<br/><strong>Calendar:</strong> shows you the calendar events for the room<br/><strong>Links:</strong> contains any link shared in the room"); ?>", '', ''),
            shape: 'rect',
            timeout: 100
        },
        {
            'next #step_container': createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "List steps");?>", "<?php echo Yii::t('HelpModule.steps', "Here you see the different steps you need to go through and your fulfilment (green line and dots). Each step is composed of several cards. You can go back to any step that has been already fulfilled by clicking on it."); ?>", '', ''),
            shape: 'rect',
            timeout: 100,
        },
        {
            selector: '#wallStream',
            showNext: false,
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Cards");?>", "<?php echo Yii::t('HelpModule.steps', "Cards contain tasks that need to be completed to move the process forward"); ?>", '', '')
        }
    ];

    enjoyhint_script_steps_with_cards = [
        {
            selector: '.wall-entry:first',
            showNext: true,
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Cards");?>", "<?php echo Yii::t('HelpModule.steps', "Cards contain tasks that need to be completed to move the process forward"); ?>", '', '')
            //description: "<?php echo Yii::t('HelpModule.steps', "Cards contain tasks that need to be completed to move the process forward"); ?>"
        },
        {
            selector: '.card-heading h1.title',
            showNext: true,
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Title");?>", "<?php echo Yii::t('HelpModule.steps', "Each Card has a title"); ?>", '', '')
        },
        {
            selector: '.card-heading p.description',
            showNext: true,
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Description");?>", "<?php echo Yii::t('HelpModule.steps', "and a short description"); ?>", '', '')
        },
        {
            selector: '.card-heading span:nth-child(1)',
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Status");?>", "<?php echo Yii::t('HelpModule.steps', "Each card has a status (pending, ongoing or completed) that will switch depending on your actions"); ?>", '', ''),
            showNext: true,
            shape: 'circle',
            timeout: 100
        },
        {
            selector: '.card-heading span:nth-child(2)',
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Deadline");?>", "<?php echo Yii::t('HelpModule.steps', "Each card has a tentative deadline"); ?>", '', ''),
            showNext: true,
            shape: 'circle',
            timeout: 100
        },
        {
            selector: 'a.btn-material i.fa-angle-down',
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Fold/Unfold");?>", "<?php echo Yii::t('HelpModule.steps', "Some Cards will be displayed folded<br/> Click on <strong>V</strong> to unfold it"); ?>", '', ''),
            event: 'click',
            shape: 'circle',
            timeout: 100,
            "skipButton" : {text: "<?php echo Yii::t('HelpModule.steps',  "GOT IT!");?>"},
        }
    ];

    /* Default option */
    enjoyhint_script_steps = enjoyhint_script_steps_with_cards;

    <?php }else {if(isset($userGroupId) && $userGroupId == INNOVATION_ADVISOR_GROUP_ID){?>

    enjoyhint_script_steps = [
        {
            //'next ul.nav.navbar-nav li a i.fa.fa-home' : "<?php echo Yii::t('HelpModule.steps', "What's Next"); ?>",
            //'next i.fa.fa-home' : "<?php echo Yii::t('HelpModule.steps', "What's Next"); ?>",
            //'next a.active': "<?php echo Yii::t('HelpModule.steps', "<strong>What\'s Next</strong> guides you through the process<br/>If you ever get lost, just click here"); ?>",
            'next a.active': createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "What's next");?>", "<?php echo Yii::t('HelpModule.steps', " This option, guides you through the process<br/>If you ever get lost, just click here");?>", '', ''),
            shape: 'circle',
            timeout: 100,
            showSkip: false
        },
        {
            selector: '.nav.navbar-nav:nth-child(2)',
            showNext: true,
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Space Options");?>", "<?php echo Yii::t('HelpModule.steps',  "<strong>Tasks:</strong> can be used to create assignments<br/><strong>Polls:</strong> can be used to ask other participants about specific things<br/><strong>Files:</strong> contains any document shared in the room<br/><strong>Calendar:</strong> shows you the calendar events for the room<br/><strong>Links:</strong> contains any link shared in the room"); ?>", '', ''),
            shape: 'rect',
            timeout: 100
        },
        {
            'next #step_container': createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "List steps");?>", "<?php echo Yii::t('HelpModule.steps', "Here you see the different steps you need to go through and your fulfilment (green line and dots). Each step is composed of several cards. You can go back to any step that has been already fulfilled by clicking on it."); ?>", '', ''),
            shape: 'rect',
            timeout: 100,
        },
        {
            selector: '.dropdown-navigation',
            showNext: true,
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Space Menu");?>", "<?php echo Yii::t('HelpModule.steps', "Here you can edit the space parameters"); ?>", '', '')
        },
        {
            selector: '.wall-entry:first',
            showNext: true,
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Cards");?>", "<?php echo Yii::t('HelpModule.steps', "Cards contain tasks that need to be completed to move the process forward"); ?>", '', '')
        },
        {
            selector: '.card-heading h1.title',
            showNext: true,
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Title");?>", "<?php echo Yii::t('HelpModule.steps', "Each Card has a title"); ?>", '', '')
        },
        {
            selector: '.card-heading p.description',
            showNext: true,
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Description");?>", "<?php echo Yii::t('HelpModule.steps', "and a short description"); ?>", '', '')
        },
        {
            selector: '.card-heading span:nth-child(1)',
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Status");?>", "<?php echo Yii::t('HelpModule.steps', "Each card has a status (pending, ongoing or completed) that will switch depending on your actions"); ?>", '', ''),
            showNext: true,
            shape: 'circle',
            timeout: 100
        },
        {
            selector: '.card-heading span:nth-child(2)',
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Deadline");?>", "<?php echo Yii::t('HelpModule.steps', "Each card has a tentative deadline"); ?>", '', ''),
            showNext: true,
            shape: 'circle',
            timeout: 100
        },
        {
            selector: 'a.btn-material i.fa-angle-down',
            description: createHtmlForInteractiveTutorial("", "<?php echo Yii::t('HelpModule.steps', "Fold/Unfold");?>", "<?php echo Yii::t('HelpModule.steps', "Some Cards will be displayed folded<br/> Click on <strong>V</strong> to unfold it"); ?>", '', ''),
            event: 'click',
            shape: 'circle',
            timeout: 100,
            "skipButton" : {text: "<?php echo Yii::t('HelpModule.steps',  "GOT IT!");?>"},
        }
    ];

    <?php }} ?>

    $(document).ready(function () {

        var checkExistCounter = 0;

        <?php if(isset($userGroupId) && $userGroupId == INNOVATOR_GROUP_ID){?>

        var checkExist = setInterval(function () {

            checkExistCounter = checkExistCounter + 100;

            if ($('.wall-entry').length || $(".emptyStreamMessage").css("display") != "none"
                || checkExistCounter > 10000) {

                clearInterval(checkExist);

                if (checkExistCounter < 10000) {

                    if ($('#accept-invite-button').length) {
                        tutorial_page_name =
                            "<?php echo InteractiveGuidedTourPage::PAGE_CARDS_PRE_ACCEPT_INVITE?>";
                        enjoyhint_script_steps = enjoyhint_script_steps_accept_invitation;
                    } else if ($('#start-button').length) {
                        tutorial_page_name =
                            "<?php echo InteractiveGuidedTourPage::PAGE_CARDS_PRE_START_BUTTON?>";
                        enjoyhint_script_steps = enjoyhint_script_steps_start_button;
                    } else if ($(".emptyStreamMessage").css("display") != "none") {
                        tutorial_page_name =
                            "<?php echo InteractiveGuidedTourPage::PAGE_CARDS_PRE_BEFORE_CARDS?>";
                        enjoyhint_script_steps = enjoyhint_script_steps_without_cards;
                    } else {
                        tutorial_page_name =
                            "<?php echo InteractiveGuidedTourPage::PAGE_CARDS_PRE_WITH_CARDS?>";
                        enjoyhint_script_steps = enjoyhint_script_steps_with_cards;
                    }
                }

                if ($.inArray(tutorial_page_name, lastInteractiveTutorialShowed) == -1) {
                    runInteractiveTutorialAndSaveState();
                }

            }

        }, 100);

        <?php }else{?>

        if ($.inArray(tutorial_page_name, lastInteractiveTutorialShowed) == -1) {
            runInteractiveTutorialAndSaveState();
        }

        <?php }?>
    });

    function runInteractiveTutorialAndSaveState() {
        enjoyhint_instance = new EnjoyHint({});
        enjoyhint_instance.setScript(enjoyhint_script_steps);
        enjoyhint_instance.runScript();

        $.ajax({
            type: "post",
            url: "<?php echo Yii::$app->urlManager->createUrl('/help/interactive-tutorial/save-state-interactive-tutorial'); ?>",
            data: {"tutorial_page_name": tutorial_page_name, "page_url": "<?php echo $page_url?>"},
            success: function (data) {
                /* Nothing to do here yet */
            }
        });
    }

</script>
