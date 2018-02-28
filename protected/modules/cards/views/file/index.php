<?php
use yii\helpers\Url;
use yii\helpers\Html;
use humhub\modules\cfiles\controllers\BrowseController;
use humhub\models\Setting;
use yii\bootstrap\ButtonDropdown;
use humhub\modules\cfiles\widgets\DropdownButton;

$bundle = \humhub\modules\cfiles\Assets::register($this);
$this->registerJsVar('cfilesUploadUrl', $contentContainer->createUrl('/cfiles/upload', [
    'fid' => $currentFolder->id
]));
$this->registerJsVar('cfilesZipUploadUrl', $contentContainer->createUrl('/cfiles/zip/upload-archive', [
    'fid' => $currentFolder->id
]));
$this->registerJsVar('cfilesDeleteUrl', $contentContainer->createUrl('/cfiles/delete', [
    'fid' => $currentFolder->id
]));
$this->registerJsVar('cfilesEditFolderUrl', $contentContainer->createUrl('/cfiles/edit', [
    'id' => '--folderId--'
]));
$this->registerJsVar('cfilesDownloadArchiveUrl', $contentContainer->createUrl('/cfiles/zip/download-archive', [
    'fid' => '--folderId--'
]));
$this->registerJsVar('cfilesMoveUrl', $contentContainer->createUrl('/cfiles/move', [
    'init' => 1
]));

?>
<?php echo Html::beginForm(null, null, ['data-target' => '#globalModal', 'id' => 'cfiles-form']); ?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel">Enviar Fichero</h4>
        </div>
        <div class="modal-body">

<div class="panel panel-default">

    <div class="panel-body">

        <div class="row files-action-menu">
                <?php if($this->context->canWrite()): ?>
                    <div class="col-sm-4">
                        <div id="progress" class="progress"
                             style="display: none">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <?php
                        $icon = '<i class="glyphicon glyphicon-plus"></i> ';
                        $buttons = [];
                        $buttons[] =
                            '<span class="split-button fileinput-button btn btn-success overflow-ellipsis">'.
                            $icon.
                            Yii::t('CfilesModule.base', 'Add file(s)').
                            '<input id="fileupload" type="file" name="files[]">'.
                            '</span>';
                        if(!Setting::Get('disableZipSupport', 'cfiles')):
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
                <?php endif; ?>
        </div>
        <hr id="files-action-menu-divider">
        <div class="row">
        </div>
    </div>
</div>
<?php echo Html::endForm(); ?>

<ul id="contextMenuFolder" class="contextMenu dropdown-menu" role="menu"
    style="display: none">
    <li><a tabindex="-1" href="#" data-action='download'><?php echo Yii::t('CfilesModule.base', 'Open');?></a></li>
    <li role="separator" class="divider"></li>
    <?php if($this->context->canWrite()): ?>
        <li><a tabindex="-1" href="#" data-action='edit'><?php echo Yii::t('CfilesModule.base', 'Edit');?></a></li>
        <li><a tabindex="-1" href="#" data-action='delete'><?php echo Yii::t('CfilesModule.base', 'Delete');?></a></li>
        <li><a tabindex="-1" href="#" data-action='move-files'><?php echo Yii::t('CfilesModule.base', 'Move');?></a></li>
    <?php endif; ?>
    <?php if(!Setting::Get('disableZipSupport', 'cfiles')): ?>
        <li><a tabindex="-1" href="#" data-action='zip'><?php echo Yii::t('CfilesModule.base', 'Download ZIP');?></a></li>
    <?php endif; ?>
</ul>

<ul id="contextMenuFile" class="contextMenu dropdown-menu" role="menu"
    style="display: none">
    <li><a tabindex="-1" href="#" data-action='download'><?php echo Yii::t('CfilesModule.base', 'Download');?></a></li>
    <?php if($this->context->action->id == "all-posted-files"): ?>
        <li role="separator" class="divider"></li>
        <li><a tabindex="-1" href="#" data-action='show-post'><?php echo Yii::t('CfilesModule.base', 'Show Post');?></a></li>
    <?php elseif($this->context->canWrite()): ?>
        <li role="separator" class="divider"></li>
        <li><a tabindex="-1" href="#" data-action='delete'><?php echo Yii::t('CfilesModule.base', 'Delete');?></a></li>
        <li><a tabindex="-1" href="#" data-action='move-files'><?php echo Yii::t('CfilesModule.base', 'Move');?></a></li>
    <?php endif; ?>
</ul>

<ul id="contextMenuImage" class="contextMenu dropdown-menu" role="menu"
    style="display: none">
    <li><a tabindex="-1" href="#" data-action='download'><?php echo Yii::t('CfilesModule.base', 'Download');?></a></li>
    <li role="separator" class="divider"></li>
    <li><a tabindex="-1" href="#" data-action='show-image'><?php echo Yii::t('CfilesModule.base', 'Show');?></a></li>
    <?php if($this->context->action->id == "all-posted-files"): ?>
        <li><a tabindex="-1" href="#" data-action='show-post'><?php echo Yii::t('CfilesModule.base', 'Show Post');?></a></li>
    <?php elseif($this->context->canWrite()): ?>
        <li><a tabindex="-1" href="#" data-action='delete'><?php echo Yii::t('CfilesModule.base', 'Delete');?></a></li>
        <li><a tabindex="-1" href="#" data-action='move-files'><?php echo Yii::t('CfilesModule.base', 'Move');?></a></li>
    <?php endif; ?>
</ul>

<ul id="contextMenuAllPostedFiles" class="contextMenu dropdown-menu"
    role="menu" style="display: none">
    <li><a tabindex="-1" href="#" data-action='download'><?php echo Yii::t('CfilesModule.base', 'Open');?></a></li>
    <li><a tabindex="-1" href="#" data-action='zip'><?php echo Yii::t('CfilesModule.base', 'Download ZIP');?></a></li>
</ul>

<div id="hiddenLogContainer" style="display: none">
    <div class="alert alert-danger" style="display: none">
        <ul>
        </ul>
    </div>
    <div class="alert alert-warning" style="display: none">
        <ul>
        </ul>
    </div>
    <div class="alert alert-info" style="display: none">
        <ul>
        </ul>
    </div>
</div>

        </div>

    </div>

</div>


<script type="text/javascript">


</script>