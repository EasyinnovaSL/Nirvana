<select name="nir" onchange="jQuery('#goToSpace').attr('href', jQuery(this).find('option:selected').data('url'))">
    <option value="" selected><?= Yii::t("CompaniesModule.modals", 'Select NIR') ?> </option>
    <?php foreach ($nirs as $nir):?>
        <option data-url="<?= $nir->space->getUrl()?>" value="<?= $nir->space->id ?>"> <?= $nir->space->name ?>
            <?php foreach ($nir->companies as $company_space): $company = $company_space->getCompany()->one();?> <?= $company->company_name ?>
            <?php endforeach; ?>
        </option>
    <?php endforeach; ?>
</select>
<?php if ($show_go) : ?>
    <a id="goToSpace" href="#">Go to Space</a>
<?php endif; ?>