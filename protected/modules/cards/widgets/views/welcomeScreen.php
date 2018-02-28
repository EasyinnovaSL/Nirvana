<?php
use yii\helpers\Html;
use  humhub\modules\space\models\Membership;
?>
<?php
/* Membership status 1 represents and invited user */
 $checkMembershipState = Membership::find()->where(['user_id' => Yii::$app->user->id, 'space_id' => $space->id, 'status'=> 1])->exists();

if ($workflow_id == 1): ?>
<div class="wall-entry" id="wallEntry_27">


    <div class="panel panel-default wall_humhubmodulespollsmodelsPoll_1">
        <div class="panel-body">

            <div class="media">

                <div class="media-body">

                  <p id="text-for-user"><?= Yii::t("CardsModule.welcome", 'Welcome to NIR-VANA’s Partner Search Room,' ) ?> </p>
                  <p><?= Yii::t("CardsModule.welcome", 'You have joined a Partner Search Room for '.$space->name.' where you will interact with your innovation adviser '.$profile->firstname.' '.$profile->lastname.'. You will be guided through the process through some cards with tasks that will move the process forward.' ) ?>
                    <?= Yii::t("CardsModule.welcome", 'need to be done. Some will be mandatory and have a deadline, while some others will be dismissible.' ) ?></p>

                  <?php
                      echo \humhub\modules\cards\widgets\MySteps::widget(array(
                        'user_id' 	    => Yii::$app->user->id,
                    	  'space_id' 		=> $space->id
                      ));
                  ?>

                  <p><?= Yii::t("CardsModule.welcome", 'At the end of your process you will select potential partners and invite them into a private and IP protected Networking Innovation Room (NIR) to discuss your collaboration further. You decide who will get access to the room.' ) ?> </p>



                    <?php if(!$checkMembershipState){ ?>
                        <?php echo Html::a(Yii::t("CardsModule.welcome", 'Start'), $space->createUrl('/cards/card/show', array('next_innovator' => true)), ['id'=>'start-button', 'class' => 'btn btn-primary']); ?>
                    <?php }else{?>

                        <p><strong><?php echo Yii::t("CardsModule.welcome", 'Please accept the invite to start the process.' ) ?></strong></p>

                        <!-- Accept or deny button -->
                        <div id="invite-options-button" class="btn-group dropup">
                            <?php echo Html::a(Yii::t('SpaceModule.widgets_views_membershipButton', 'Accept Invite'), $space->createUrl('/space/membership/invite-accept'), array('id'=>'accept-invite-button', 'class' => 'btn btn-info btn-sm', 'data-method' => 'POST')); ?>
                            <button id="buttonToDropDown" type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #555 !important;">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><?php echo Html::a(Yii::t('SpaceModule.widgets_views_membershipButton', 'Deny Invite'), $space->createUrl('/space/membership/revoke-membership'), array('data-method' => 'POST')); ?></li>
                            </ul>
                        </div>

                    <?php }?>

                </div>

  </div>


        </div>

    </div>

</div>
    <?php elseif ($workflow_id = 2): ?>

    <div class="wall-entry" id="wallEntry_27">


        <div class="panel panel-default wall_humhubmodulespollsmodelsPoll_1">
            <div class="panel-body">

                <div class="media">

                    <div class="media-body">

                        <p id="text-for-user"><?= Yii::t("CardsModule.welcome", 'Welcome to NIR-VANA’s Partner Search Room,' ) ?> </p>
                        <p><?= Yii::t("CardsModule.welcome", 'You have joined a Partner Search Room for '.$space->name.' where you will interact with your innovation adviser '.$profile->firstname.' '.$profile->lastname.'. You will be guided through the process through some cards with tasks that will move the process forward.' ) ?>
                            <?= Yii::t("CardsModule.welcome", 'need to be done. Some will be mandatory and have a deadline, while some others will be dismissible.' ) ?></p>

                        <?php
                        echo \humhub\modules\cards\widgets\MySteps::widget(array(
                            'user_id' 	    => Yii::$app->user->id,
                            'space_id' 		=> $space->id
                        ));
                        ?>

                        <p><?= Yii::t("CardsModule.welcome", 'At the end of your process you will select potential partners and invite them into a private and IP protected Networking Innovation Room (NIR) to discuss your collaboration further. You decide who will get access to the room.' ) ?> </p>



                        <?php if(!$checkMembershipState){ ?>
                            <?php echo Html::a(Yii::t("CardsModule.welcome", 'Start'), $space->createUrl('/cards/card/show', array('next_innovator' => true)), ['id'=>'start-button', 'class' => 'btn btn-primary']); ?>
                        <?php }else{?>

                            <p><strong><?php echo Yii::t("CardsModule.welcome", 'Please accept the invite to start the process.' ) ?></strong></p>

                            <!-- Accept or deny button -->
                            <div id="invite-options-button" class="btn-group dropup">
                                <?php echo Html::a(Yii::t('SpaceModule.widgets_views_membershipButton', 'Accept Invite'), $space->createUrl('/space/membership/invite-accept'), array('id'=>'accept-invite-button','class' => 'btn btn-info btn-sm', 'data-method' => 'POST')); ?>
                                <button id="buttonToDropDown" type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #555 !important;">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><?php echo Html::a(Yii::t('SpaceModule.widgets_views_membershipButton', 'Deny Invite'), $space->createUrl('/space/membership/revoke-membership'), array('data-method' => 'POST')); ?></li>
                                </ul>
                            </div>

                        <?php }?>





                    </div>


                </div>


            </div>

        </div>

    </div>

<?php endif; ?>
