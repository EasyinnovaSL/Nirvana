<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use humhub\models\Setting;
use humhub\modules\space\models\Space;
use humhub\modules\space\permissions\CreatePublicSpace;
use humhub\modules\space\permissions\CreatePrivateSpace;
?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <?php $form = ActiveForm::begin(); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">
                <?php echo Yii::t('EnterpriseModule.spacetype', '<strong>Create</strong> new %typeTitle%', ['%typeTitle%' => $this->context->getTypeTitle($model)]); ?>
            </h4>
        </div>
        <div class="modal-body">
            <hr>
            <br>
            <?= humhub\modules\space\widgets\SpaceNameColorInput::widget(['form' => $form, 'model' => $model])?>
      
            <?php echo $form->field($model, 'description')->textarea(['placeholder' => Yii::t('SpaceModule.views_create_create', 'Description'), 'rows' => '3']); ?>

            <a data-toggle="collapse" id="access-settings-link" href="#collapse-access-settings"
               style="font-size: 11px;"><i
                    class="fa fa-caret-right"></i> <?php echo Yii::t('SpaceModule.views_create_create', 'Advanced access settings'); ?>
            </a>

            <?php
            /**
             * Temporary until 1.0 release - after release controller will provide these variables
             */
            $visibilityOptions = [];
            if (Setting::Get('allowGuestAccess', 'authentication_internal') && Yii::$app->user->permissionmanager->can(new CreatePublicSpace)) {
                $visibilityOptions[Space::VISIBILITY_ALL] = Yii::t('SpaceModule.base', 'Public (Members & Guests)');
            }
            if (Yii::$app->user->permissionmanager->can(new CreatePublicSpace)) {
                $visibilityOptions[Space::VISIBILITY_REGISTERED_ONLY] = Yii::t('SpaceModule.base', 'Public (Members only)');
            }
            if (Yii::$app->user->permissionmanager->can(new CreatePrivateSpace())) {
                $visibilityOptions[Space::VISIBILITY_NONE] = Yii::t('SpaceModule.base', 'Private (Invisible)');
            }

            $joinPolicyOptions = [
                Space::JOIN_POLICY_NONE => Yii::t('SpaceModule.base', 'Only by invite'),
                Space::JOIN_POLICY_APPLICATION => Yii::t('SpaceModule.base', 'Invite and request'),
                Space::JOIN_POLICY_FREE => Yii::t('SpaceModule.base', 'Everyone can enter')
            ];
            ?>

            <div id="collapse-access-settings" class="panel-collapse collapse">
                <br/>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'join_policy')->radioList($joinPolicyOptions); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'visibility')->radioList($visibilityOptions); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class=" modal-footer">
            <hr/>
            <br/>
            <?php
            echo \humhub\widgets\AjaxButton::widget([
                'label' => Yii::t('SpaceModule.views_create_create', 'Next'),
                'ajaxOptions' => [
                    'type' => 'POST',
                    'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                    'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); }'),
                    'url' => Url::to(['/enterprise/spacetype/create-space/create', 'type_id' => $model->space_type_id]),
                ],
                'htmlOptions' => [
                    'class' => 'btn btn-primary',
                    'id' => 'space-create-submit-button',
                ]
            ]);
            ?>

            <?php echo \humhub\widgets\LoaderWidget::widget(['id' => 'create-loader', 'cssClass' => 'loader-modal hidden']); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>


<script type="text/javascript">

    // Replace the standard checkbox and radio buttons
    $('.modal-dialog').find(':checkbox, :radio').flatelements();

    // show Tooltips on elements inside the views, which have the class 'tt'
    $('.tt').tooltip({html: false});

    // Shake modal after wrong validation
<?php if ($model->hasErrors()) { ?>
        $('.modal-dialog').removeClass('fadeIn');
        $('.modal-dialog').addClass('shake');
<?php } ?>

    $('#collapse-access-settings').on('show.bs.collapse', function () {
        // change link arrow
        $('#access-settings-link i').removeClass('fa-caret-right');
        $('#access-settings-link i').addClass('fa-caret-down');
    });

    $('#collapse-access-settings').on('hide.bs.collapse', function () {
        // change link arrow
        $('#access-settings-link i').removeClass('fa-caret-down');
        $('#access-settings-link i').addClass('fa-caret-right');
    })

    // prevent enter key and simulate ajax button submit click
    $(document).ready(function () {
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                $('#space-create-submit-button').click();
            }
        });

        $('#space-name').focus();
    });

</script>