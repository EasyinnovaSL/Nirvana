<?php
  use yii\helpers\Html;
?>

<style>
.data-saved.model-selected {
  padding: 0px;
  margin-top: 10px;
  color: #777;
}
.data-saved.model-selected i {
  color: #6fdbe8;
}
</style>
<?php if($nda_model_chose && $nda_model_chose[0]->nda_model->name): ?>
<div class="data-saved model-selected"><i class="fa fa-check-circle"></i> <?php echo $nda_model_chose[0]->nda_model->name; ?> selected</div>
<?php endif; ?>


<?php if(!$posts): ?>
  <br />
  <?php echo Html::textArea("message", '', array('id' => 'contentForm_message', 'class' => 'form-control autosize contentForm', 'rows' => '4', 'placeholder' => Yii::t("PostModule.widgets_views_postForm", "What's on your mind?"))); ?>

  <div class="contentForm_options">

      <hr>

      <div class="btn_container">

        <?php echo \humhub\widgets\LoaderWidget::widget(['id' => 'postform-loader', 'cssClass' => 'loader-postform hidden']); ?>

        <?php
        echo \humhub\widgets\AjaxButton::widget([
            'label' => 'Submit',
            'ajaxOptions' => [
                'url' => $contentContainer->createUrl($submitUrl),
                'type' => 'POST',
                'dataType' => 'json',
                'beforeSend' => "function() { $('.contentForm').removeClass('error'); $('#contentFormError').hide(); $('#contentFormError').empty(); }",
                'beforeSend' => 'function(){ $("#contentFormError").hide(); $("#contentFormError li").remove(); $(".contentForm_options .btn").hide(); $("#postform-loader").removeClass("hidden"); }',
                'success' => "function(response) { console.log(response); handleResponse(response);}"
            ],
            'htmlOptions' => [
                'id' => "post_submit_button",
                'data-action' => 'post_create',
                'class' => 'btn btn-info',
                'type' => 'submit'
        ]]);

        // Creates Uploading Button
        echo humhub\modules\file\widgets\FileUploadButton::widget(array(
            'uploaderId' => 'contentFormFiles',
            'fileListFieldName' => 'fileList',
        ));

        ?>
        <script>
            $('#fileUploaderButton_contentFormFiles').bind('fileuploaddone', function (e, data) {
                $('.btn_container').show();
            });
            $('#fileUploaderButton_contentFormFiles').bind('fileuploadprogressall', function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                if (progress != 100) {
                    // Fix: remove focus from upload button to hide tooltip
                    $('#post_submit_button').focus();
                    // hide form buttons
                    $('.btn_container').hide();
                }
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
                $('#contentForm_visibility').prop( "checked", true );
                $('#contentForm_visibility_entry').html('<i class="fa fa-lock"></i> <?php echo Yii::t('ContentModule.widgets_views_contentForm', 'Make private'); ?>');
                $('.label-public').removeClass('hidden');
            }

            function setPrivateVisibility() {
                $('#contentForm_visibility').prop( "checked", false );
                $('#contentForm_visibility_entry').html('<i class="fa fa-unlock"></i> <?php echo Yii::t('ContentModule.widgets_views_contentForm', 'Make public'); ?>');
                $('.label-public').addClass('hidden');
            }

            function handleResponse(response) {
                if (!response.errors) {
                    // application.modules_core.wall function
                    currentStream.prependEntry(response.wallEntryId);

                    // Reset Form (Empty State)
                    jQuery('.contentForm_options').hide();
                    $('.contentForm').filter(':text').val('');
                    $('.contentForm').filter('textarea').val('').trigger('autosize.resize');
                    $('.contentForm').attr('checked', false);
                    $('.userInput').remove(); // used by UserPickerWidget
                    $('#notifyUserContainer').addClass('hidden');
                    $('#notifyUserInput').val('');

                    setDefaultVisibility();

                    $('#contentFrom_files').val('');
                    $('#public').attr('checked', false);
                    $('#contentForm_message_contenteditable').html('<?php echo Html::encode(Yii::t("ContentModule.widgets_views_contentForm", "What's on your mind?")); ?>');
                    $('#contentForm_message_contenteditable').addClass('atwho-placeholder');

                    $('#contentFormBody').find('.atwho-input').trigger('clear');

                    // Notify FileUploadButtonWidget to clear (by providing uploaderId)
                    resetUploader('contentFormFiles');
                } else {
                    $('#contentFormError').show();
                    $.each(response.errors, function (fieldName, errorMessage) {
                        // Mark Fields as Error
                        fieldId = 'contentForm_' + fieldName;
                        $('#' + fieldId).addClass('error');
                        $.each(errorMessage, function (key, msg) {
                            $('#contentFormError').append('<li><i class=\"icon-warning-sign\"></i> ' + msg + '</li>');
                        });
                    });
                }
                $('.contentForm_options .btn').show();
                $('#postform-loader').addClass('hidden');
            }

          </script>
      </div>
  </div>

  <?php
    // Creates a list of already uploaded Files
    echo \humhub\modules\file\widgets\FileUploadList::widget(array(
        'uploaderId' => 'contentFormFiles'
    ));
  ?>

  <?php echo Html::hiddenInput("card_id", $card_id); ?>

<?php else: ?>

  <?php foreach ($posts as $post) : ?>

    <div class="content" id="comment_editarea_<?php echo $post->id; ?>">
        <?php echo humhub\modules\file\widgets\ShowFiles::widget(array('object' => $post)); ?>
    </div>

    <div class="wall-entry " id="post-comment-<?php echo $post->id; ?>">
        <div class="wall-entry-controls">
            <?php echo \humhub\modules\comment\widgets\CommentLink::widget(array('object' => $post)); ?>
        </div>
        <?php echo \humhub\modules\comment\widgets\Comments::widget(array('object' => $post)); ?>
    </div>
    <script type="text/javascript">
        $('#post-comment-<?php echo $post->id; ?>').on('shown.bs.collapse', function () {
            $('#newCommentForm_humhubmodulestasksmodelsTask_<?php echo $post->id; ?>_contenteditable').focus();
        })
    </script>
  <?php endforeach; ?>

<?php endif; ?>
