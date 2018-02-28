<?php

use yii\helpers\Html;
use yii\helpers\Url;
use humhub\modules\space\models\Space;
?>



<?php if(empty($wallEntry)): ?>
	<div class="panel panel-default">
    <div class="panel-body" id="contentFormBody_<?php echo $id; ?>">

        <?php echo Html::beginForm('', 'POST'); ?>

        <ul id="contentFormError_<?php echo $id; ?>">
        </ul>

        <?php echo $form; ?>

        <div id="notifyUserContainer_<?php echo $id; ?>" class="form-group hidden" style="margin-top: 15px;">
            <input type="text" value="" id="notifyUserInput_<?php echo $id; ?>" name="notifyUserInput"/>

            <?php
            $userSearchUrl = Url::toRoute(['/user/search/json', 'keyword' => '-keywordPlaceholder-']);
            if ($contentContainer instanceof Space) {
                $userSearchUrl = $contentContainer->createUrl('/space/membership/search', array('keyword' => '-keywordPlaceholder-'));
            }

            /* add UserPickerWidget to notify members */
            echo \humhub\modules\user\widgets\UserPicker::widget(array(
                'inputId' => 'notifyUserInput',
                'userSearchUrl' => $userSearchUrl,
                'maxUsers' => 10,
                'userGuid' => Yii::$app->user->guid,
                'placeholderText' => Yii::t('ContentModule.widgets_views_contentForm', 'Add a member to notify'),
                'focus' => true,
            ));
            ?>
        </div>

        <?php
        echo Html::hiddenInput("containerGuid", $contentContainer->guid);
        echo Html::hiddenInput("containerClass", get_class($contentContainer));
        ?>

        <div class="contentForm_options_<?php echo $id; ?>">

            <hr>

            <div class="btn_container btn_container_<?php echo $id; ?>">

                <?php echo \humhub\widgets\LoaderWidget::widget(['id' => 'postform-loader_'.$id, 'cssClass' => 'loader-postform hidden']); ?>

                <?php
                echo \humhub\widgets\AjaxButton::widget([
                    'label' => $submitButtonText,
                    'ajaxOptions' => [
                        'url' => $submitUrl,
                        'type' => 'POST',
                        'dataType' => 'json',
                        'beforeSend' => "function() { $('.contentForm_".$id."').removeClass('error'); $('#contentFormError_".$id."').hide(); $('#contentFormError_".$id."').empty(); }",
                        'beforeSend' => 'function(){ $("#contentFormError_'.$id.'").hide(); $("#contentFormError_'.$id.' li").remove(); $(".contentForm_options_'.$id.' .btn").hide(); $("#postform-loader_'.$id.'").removeClass("hidden"); }',
											'success' => "function(response) { currentStream.showStream(); updateSteps();}"
                    ],
                    'htmlOptions' => [
                        'id' => "post_submit_button_".$id,
                        'data-action' => 'post_create',
                        'class' => 'btn btn-info',
                        'type' => 'submit'
                ]]);
                ?>
                <?php
                // Creates Uploading Button
                echo humhub\modules\file\widgets\FileUploadButton::widget(array(
                    'uploaderId' => 'contentFormFiles_'.$id,
                    'fileListFieldName' => 'fileList',
                ));
                ?>
                <script>
                    $('#fileUploaderButton_contentFormFiles_<?php echo $id; ?>').bind('fileuploaddone', function (e, data) {
                        $('.btn_container_<?php echo $id; ?>').show();
                    });
                    $('#fileUploaderButton_contentFormFiles_<?php echo $id; ?>').bind('fileuploadprogressall', function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        if (progress != 100) {
                            // Fix: remove focus from upload button to hide tooltip
                            $('#post_submit_button_<?php echo $id; ?>').focus();
                            // hide form buttons
                            $('.btn_container_<?php echo $id; ?>').hide();
                        }
                    });</script>


                <!-- public checkbox -->
                <?php echo Html::checkbox("visibility", "", array('id' => 'contentForm_visibility_'.$id, 'class' => 'contentForm_'.$id.' hidden')); ?>

                <!-- content sharing -->
                <div class="pull-right">

                    <span class="label label-success label-public hidden"><?php echo Yii::t('ContentModule.widgets_views_contentForm', 'Public'); ?></span>

                    <ul class="nav nav-pills preferences" style="right: 0; top: 5px;">
                        <li class="dropdown">
                            <a class="dropdown-toggle" style="padding: 5px 10px;" data-toggle="dropdown" href="#"><i
                                    class="fa fa-cogs"></i></a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:notifyUser();"><i
                                            class="fa fa-bell"></i> <?php echo Yii::t('ContentModule.widgets_views_contentForm', 'Notify members'); ?>
                                    </a>
                                </li>
                                <?php if ($canSwitchVisibility): ?>
                                    <li>
                                        <a id="contentForm_visibility_entry_<?php echo $id; ?>" href="javascript:changeVisibility();"><i
                                                class="fa fa-unlock"></i> <?php echo Yii::t('ContentModule.widgets_views_contentForm', 'Make public'); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>


                </div>

            </div>

            <?php
            // Creates a list of already uploaded Files
            echo \humhub\modules\file\widgets\FileUploadList::widget(array(
                'uploaderId' => 'contentFormFiles_'.$id
            ));
            ?>

        </div>
        <!-- /contentForm_Options -->
        <?php echo Html::endForm(); ?>
    </div>
    <!-- /panel body -->
</div> <!-- /panel -->

<div class="clearFloats"></div>

<script type="text/javascript">

    // Hide options by default
    jQuery('.contentForm_options_<?php echo $id; ?>').hide();
    $('#contentFormError_<?php echo $id; ?>').hide();
    // Remove info text from the textinput
    jQuery('#contentFormBody_<?php echo $id; ?>').click(function () {

        // Hide options by default
        jQuery('.contentForm_options_<?php echo $id; ?>').fadeIn();
    });

    setDefaultVisibility();

    function setDefaultVisibility() {
        <?php if ($defaultVisibility == humhub\modules\content\models\Content::VISIBILITY_PRIVATE) : ?>
            setPrivateVisibility();
        <?php endif ;?>

        <?php if ($defaultVisibility == humhub\modules\content\models\Content::VISIBILITY_PUBLIC) : ?>
            setPublicVisibility();
        <?php endif ;?>
    }

    function setPublicVisibility() {
        $('#contentForm_visibility_<?php echo $id; ?>').prop( "checked", true );
        $('#contentForm_visibility_entry_<?php echo $id; ?>').html('<i class="fa fa-lock"></i> <?php echo Yii::t('ContentModule.widgets_views_contentForm', 'Make private'); ?>');
        $('.label-public').removeClass('hidden');
    }

    function setPrivateVisibility() {
        $('#contentForm_visibility_<?php echo $id; ?>').prop( "checked", false );
        $('#contentForm_visibility_entry_<?php echo $id; ?>').html('<i class="fa fa-unlock"></i> <?php echo Yii::t('ContentModule.widgets_views_contentForm', 'Make public'); ?>');
        $('.label-public').addClass('hidden');
    }

    function changeVisibility() {
        if (!$('#contentForm_visibility_<?php echo $id; ?>').prop('checked')) {
            setPublicVisibility();
        } else {
            setPrivateVisibility();
        }
    }

    function notifyUser() {
        $('#notifyUserContainer_<?php echo $id; ?>').removeClass('hidden');
        $('#notifyUserInput_tag_input_field_<?php echo $id; ?>').focus();
    }

    function handleResponse(response) {
        if (!response.errors) {
            // application.modules_core.wall function
            currentStream.prependEntry(response.wallEntryId);

            // Reset Form (Empty State)
            jQuery('.contentForm_options_<?php echo $id; ?>').hide();
            $('.contentForm_<?php echo $id; ?>').filter(':text').val('');
            $('.contentForm_<?php echo $id; ?>').filter('textarea').val('').trigger('autosize.resize');
            $('.contentForm_<?php echo $id; ?>').attr('checked', false);
            $('.userInput').remove(); // used by UserPickerWidget
            $('#notifyUserContainer_<?php echo $id; ?>').addClass('hidden');
            $('#notifyUserInput_<?php echo $id; ?>').val('');

            setDefaultVisibility();

            $('#contentFrom_files_<?php echo $id; ?>').val('');
            $('#public_<?php echo $id; ?>').attr('checked', false);
            $('#contentForm_message_contenteditable_<?php echo $id; ?>').html('<?php echo Html::encode(Yii::t("ContentModule.widgets_views_contentForm", "What's on your mind?")); ?>');
            $('#contentForm_message_contenteditable_<?php echo $id; ?>').addClass('atwho-placeholder');

            $('#contentFormBody_<?php echo $id; ?>').find('.atwho-input').trigger('clear');

            // Notify FileUploadButtonWidget to clear (by providing uploaderId)
            resetUploader('contentFormFiles_<?php echo $id; ?>');
        } else {
            $('#contentFormError_<?php echo $id; ?>').show();
            $.each(response.errors, function (fieldName, errorMessage) {
                // Mark Fields as Error
                fieldId = 'contentForm_' + fieldName + '_<?php echo $id; ?>';
                $('#' + fieldId).addClass('error');
                $.each(errorMessage, function (key, msg) {
                    $('#contentFormError_<?php echo $id; ?>').append('<li><i class=\"icon-warning-sign\"></i> ' + msg + '</li>');
                });
            });
        }
        $('.contentForm_options_<?php echo $id; ?> .btn').show();
        $('#postform-loader_<?php echo $id; ?>').addClass('hidden');
    }
</script>
<?php else: ?>

	<div class="wall-entry" id="task-comment-<?php echo $id; ?>">
		<div class="wall-entry-controls">
	    	<?php echo \humhub\modules\comment\widgets\CommentLink::widget(array('object' => $post)); ?>
	    </div>
	</div>
	<?php echo \humhub\modules\comment\widgets\Comments::widget(['object' => $post]); ?>
	
<?php endif; ?>
