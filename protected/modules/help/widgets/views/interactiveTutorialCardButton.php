<?php ?>

<span id="tutorial-card-id-<?php echo $card->id?>" class="label pull-left" style="display: none; padding: 0px; left: 4px; top: 3px; position: absolute; color: black !important; cursor: pointer; margin: 0px !important;"><i class="fa fa-info-circle" style="margin: 0px !important;"></i></span>


<script type="text/javascript">

    var card_initial_folded_state_<?php echo $card->id;?> = <?php echo $card->getCard()->one()->folded ?>;

    var steps_for_card_id_<?php echo $card->id;?>= [

        <?php if(!empty($cardInteractiveTutorialState)) {
                 $cardInteractiveTutorialState->intereractive_tutorial_json = str_replace("#CARD_ID_#", $card->id,$cardInteractiveTutorialState->intereractive_tutorial_json);
                echo $cardInteractiveTutorialState->intereractive_tutorial_json; ?>
        <?php }else{?>
                {
                    selector:'.wall_humhubmodulescardsmodelsCard_<?php echo $card->id?>',
                    showNext: true,
                    description: "<?php echo Yii::t('HelpModule.steps',  "With the Enter Company Profile card, you can create and share a profile page"); ?>",
                    shape: 'rect',
                    timeout: 100
                },
                <?php if ($card->getCard()->one()->folded == 0){?>
                {
                    selector:'#folded-card-id-<?php echo $card->id ?>',
                    event:'click',
                    showNext: false,
                    description: "<?php echo Yii::t('HelpModule.steps',  "Unfold the card"); ?>",
                    shape: 'rect',
                    timeout: 100
                }
                <?php }?>

        <?php }?>

    ];

    $('#tutorial-card-id-<?php echo $card->id?>').click(function () {
        if(enjoyhint_script_steps != null){

            enjoyhint_instance = new EnjoyHint({onStart: function(){
                if($("#folded-card-id-<?php echo $card->id;?> i").hasClass("fa-angle-up")){
                    showCardBody($("#folded-card-id-<?php echo $card->id;?>"),<?php echo $card->id;?>)
                }
            }
            });
            enjoyhint_instance.set(steps_for_card_id_<?php echo $card->id;?>);
            enjoyhint_instance.run();
        }
    });

    $('.wall_humhubmodulescardsmodelsCard_<?php echo $card->id;?>').hover(
        function(){$('#tutorial-card-id-<?php echo $card->id?>').show();},
        function(){$('#tutorial-card-id-<?php echo $card->id?>').hide();}
    );

</script>