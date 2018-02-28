<?php
use yii\helpers\Url;
use yii\helpers\Html;
use humhub\modules\cfiles\controllers\BrowseController;
use humhub\models\Setting;
use yii\bootstrap\ButtonDropdown;
use humhub\modules\cfiles\widgets\DropdownButton;

?>
<?php echo Html::beginForm(null, null, ['data-target' => '#globalModal', 'id' => 'cfiles-form']); ?>
<div class="panel-default">

	<div class="panel-body">

		<div class="row files-action-menu">


					<div class="col-sm-4">
						<div id="progress" class="progress" style="display: none">
							<div class="progress-bar progress-bar-success"></div>
						</div>
						<?php
						$icon = '<i class="glyphicon glyphicon-plus"></i> ';
						$buttons = [];
						$buttons[] =
							'<span class="split-button fileinput-button btn btn-success overflow-ellipsis">'.
							$icon.
							Yii::t('CfilesModule.base', 'Add file(s)').
							'<input data-card_id="'.$card_id.'" id="fileupload"  class="fileupload" type="file" name="files[]" multiple>'.
							'</span>';
						if(!Setting::Get('disableZipSupport', 'cfiles')):
							$buttons[] =
								'<span class="fileinput-button btn btn-success overflow-ellipsis">'.
								$icon.
								Yii::t('CfilesModule.base', 'Upload ZIP').
								'<input id="zipupload" type="file" name="files[]" multiple>'.
								'</span>';
						endif;
						echo DropdownButton::widget([
								'label' => \Yii::t('CfilesModule.base', 'Upload'),
								'buttons' => $buttons,
								'icon' => $icon,
								'options' => [
									'class' => 'btn btn-success overflow-ellipsis',
								]
							]
						);
						?>
					</div>

		</div>
		<hr id="files-action-menu-divider">

	</div>
</div>
<?php echo Html::endForm(); ?>

<script type="text/javascript">
	$('.fileupload').each(function() {
		$(this).fileupload(
			{
				url : '<?=  $contentContainer->createUrl('/cards/file/index', ['fid' => $currentFolder->id]) ?>&card_id='+$(this).data('card_id'),
				dataType : 'json',
				done : function(e, data) {
					$.each(data.result.files, function(index, file) {
						$('#fileList').html(file.fileList);
						currentStream.showStream(); updateSteps();
					});
				},
				fail : function(e, data) {	},
				start : function(e, data) {	},
				progressall : function(e, data) {
					var progress = parseInt(data.loaded / data.total * 100, 10);
					if (progress != 100) {
						$('#progress').show();
						$('#progress .progress-bar').css('width', progress + '%');
					} else {
						$('#progress').hide();
						$('#fileupload').parents(".btn-group").click();
					}
				}
			}).prop('disabled', !$.support.fileInput).parent()
			.addClass($.support.fileInput ? undefined : 'disabled');

	})

</script>