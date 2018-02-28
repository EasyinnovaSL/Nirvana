<select>
<?php foreach ($companies as $company_space): $company = $company_space->getCompany()->one();?>
    <option value="<?= $company->id ?>"> <?= $company->company_name ?></option>
<?php endforeach; ?>
</select>