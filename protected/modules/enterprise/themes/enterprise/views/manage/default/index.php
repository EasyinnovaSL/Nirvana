<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use humhub\modules\space\models\Space;
use humhub\modules\space\modules\manage\widgets\DefaultMenu;

$this->registerJsFile('@web/resources/space/colorpicker/js/bootstrap-colorpicker-modified.js');
$this->registerCssFile('@web/resources/space/colorpicker/css/bootstrap-colorpicker.min.css');
$this->registerJsFile('@web/resources/space/spaceHeaderImageUpload.js');
$this->registerJsVar('profileImageUploaderUrl', $model->createUrl('/space/manage/image/upload'));
$this->registerJsVar('profileHeaderUploaderUrl', $model->createUrl('/space/manage/image/banner-upload'));
?>


<div class="panel panel-default">
    <div class="panel-heading"><?php echo Yii::t('SpaceModule.manage', '<strong>General</strong> settings'); ?></div>
    <?= DefaultMenu::widget(['space' => $model]); ?>
    <div class="panel-body">

        <strong><?php echo Yii::t('SpaceModule.manage', 'Image'); ?></strong>

        <div class="image-upload-container profile-user-photo-container"
             style="width: 140px; height: 140px; margin-top: 5px;">

            <?php
            /* Get original profile image URL */

            $profileImageExt = pathinfo($model->getProfileImage()->getUrl(), PATHINFO_EXTENSION);

            $profileImageOrig = preg_replace('/.[^.]*$/', '', $model->getProfileImage()->getUrl());
            $defaultImage = (basename($model->getProfileImage()->getUrl()) == 'default_space.jpg' || basename($model->getProfileImage()->getUrl()) == 'default_space.jpg?cacheId=0') ? true : false;
            $profileImageOrig = $profileImageOrig . '_org.' . $profileImageExt;

            if (!$defaultImage) {
                ?>

                <!-- profile image output-->
                <a data-toggle="lightbox" data-gallery="" href="<?php echo $profileImageOrig; ?>#.jpeg"
                   data-footer='<button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo Yii::t('SpaceModule.widgets_views_profileHeader', 'Close'); ?></button>'>
                       <?php echo \humhub\modules\space\widgets\Image::widget(['space' => $model, 'width' => 140]); ?>
                </a>


            <?php } else { ?>

                <?php echo \humhub\modules\space\widgets\Image::widget(['space' => $model, 'width' => 140]); ?>

            <?php } ?>

            <!-- check if the current user is the profile owner and can change the images -->
            <?php if ($model->isAdmin()) { ?>
                <form class="fileupload" id="profilefileupload" action="" method="POST" enctype="multipart/form-data"
                      style="position: absolute; top: 0; left: 0; opacity: 0; height: 140px; width: 140px;">
                    <input type="file" name="spacefiles[]">
                </form>

                <div class="image-upload-loader" id="profile-image-upload-loader" style="padding-top: 60px;">
                    <div class="progress image-upload-progess-bar" id="profile-image-upload-bar">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="00"
                             aria-valuemin="0"
                             aria-valuemax="100" style="width: 0%;">
                        </div>
                    </div>
                </div>

                <div class="image-upload-buttons" id="profile-image-upload-buttons">
                    <a href="#" onclick="javascript:$('#profilefileupload input').click();" class="btn btn-info btn-sm"><i
                            class="fa fa-cloud-upload"></i></a>
                    <a id="profile-image-upload-edit-button"
                       style="<?php
                       if (!$model->getProfileImage()->hasImage()) {
                           echo 'display: none;';
                       }
                       ?>"
                       href="<?php echo $model->createUrl('/space/manage/image/crop'); ?>"
                       class="btn btn-info btn-sm" data-target="#globalModal"><i
                            class="fa fa-edit"></i></a>
                        <?php
                        echo humhub\widgets\ModalConfirm::widget(array(
                            'uniqueID' => 'modal_profileimagedelete',
                            'linkOutput' => 'a',
                            'title' => Yii::t('SpaceModule.widgets_views_deleteImage', '<strong>Confirm</strong> image deleting'),
                            'message' => Yii::t('SpaceModule.widgets_views_deleteImage', 'Do you really want to delete your profile image?'),
                            'buttonTrue' => Yii::t('SpaceModule.widgets_views_deleteImage', 'Delete'),
                            'buttonFalse' => Yii::t('SpaceModule.widgets_views_deleteImage', 'Cancel'),
                            'linkContent' => '<i class="fa fa-times"></i>',
                            'cssClass' => 'btn btn-danger btn-sm',
                            'style' => $model->getProfileImage()->hasImage() ? '' : 'display: none;',
                            'linkHref' => $model->createUrl("/space/manage/image/delete", array('type' => 'profile')),
                            'confirmJS' => 'function(jsonResp) { resetProfileImage(jsonResp); }'
                        ));
                        ?>
                </div>
            <?php } ?>
        </div>
        <br>


        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div
                class="col-md-8"> <?php echo $form->field($model, 'name')->textInput(['id' => 'space-name', 'placeholder' => Yii::t('SpaceModule.views_create_create', 'space name'), 'maxlength' => 45]); ?></div>
            <div class="col-md-4"><strong><?php echo Yii::t('SpaceModule.manage', 'Color'); ?></strong>

                <div class="input-group space-color-chooser-edit" style="margin-top: 5px;">

                    <?= Html::activeTextInput($model, 'color', ['class' => 'form-control', 'id' => 'space-color-picker-edit', 'value' => $model->color]); ?>
                    <span class="input-group-addon"><i></i></span>
                </div>
                <br></div>
        </div>

        <?php echo $form->field($model, 'description')->textarea(['rows' => 6]); ?>

        <?php if ($model->hasAttribute('website')): ?>
            <?php echo $form->field($model, 'website')->textInput(['maxlength' => 45]); ?>
        <?php endif; ?>

        <?php echo $form->field($model, 'tags')->textInput(['maxlength' => 200]); ?>

        <?php echo Html::submitButton(Yii::t('SpaceModule.views_admin_edit', 'Save'), array('class' => 'btn btn-primary')); ?>

        <?php echo \humhub\widgets\DataSaved::widget(); ?>


        <div class="pull-right">
            <?php if ($model->isSpaceOwner()) : ?>
                <?php echo Html::a(Yii::t('SpaceModule.views_admin_edit', 'Delete'), $model->createUrl('delete'), array('class' => 'btn btn-danger', 'data-post' => 'POST')); ?>
            <?php endif; ?>
        </div>

        <?php ActiveForm::end(); ?>


    </div>

</div>

<!-- start: Error modal -->
<div class="modal" id="uploadErrorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-extra-small animated pulse">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"
                    id="myModalLabel"><?php echo Yii::t('SpaceModule.widgets_views_profileHeader', '<strong>Something</strong> went wrong'); ?></h4>
            </div>
            <div class="modal-body text-center">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"
                        data-dismiss="modal"><?php echo Yii::t('SpaceModule.widgets_views_profileHeader', 'Ok'); ?></button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    // prevent enter key and simulate ajax button submit click
    $(document).ready(function () {

        $('.space-color-chooser-edit').colorpicker({
            format: 'hex',
            color: '<?= $model->color; ?>',
            horizontal: false,
            component: '.input-group-addon',
            input: '#space-color-picker-edit',
        });
    });
</script>


