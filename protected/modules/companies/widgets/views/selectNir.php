<div class="row">
    <div class="col-md-3" style="padding-right: 0px;padding-left: 30px;">
        <?php echo Yii::t("CompaniesModule.base","Partner Search Room"); ?>
    </div>
    <div class="col-md-3" style="padding-left: 23px;">
        <?php echo Yii::t("CompaniesModule.base","NIR"); ?>
    </div>
</div>
<div class="col-md-2">
    <?php echo $contentContainer->name; ?>
</div>
<div class="col-md-1">
    <i class="fa fa-arrow-right" aria-hidden="true"></i>
</div>
<div class="col-md-3">
    <?php foreach ($nirs as $nir):?>
        <a href="<?= $nir->space->getUrl()?>"> <?= $nir->space->name ?>
            <?php foreach ($nir->companies as $company_space): $company = $company_space->getCompany()->one();?> <?= $company->company_name ?> <br>
            <?php endforeach; ?>
        </a>
    <?php endforeach; ?>
</div>
