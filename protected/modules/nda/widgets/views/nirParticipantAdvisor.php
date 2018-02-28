<?php
  use yii\helpers\Html;
  use yii\helpers\Url;
  use yii\widgets\ActiveForm;
?>

<style>
  .radio-role-advisor {
    margin: 20px 0px 20px 0px;
  }
</style>

<p>
  Would you like your advisor to have full access to the contents being shared in the NIR?
</p>

<div class="clearfix radio-role-advisor">
    <div class="radio">
        <label>
            <?php echo Html::radio("roleAdvisor", "", array('value' => 1, 'checked' => true)); ?>
            Si
        </label>
    </div>
    <div class="radio">
        <label>
            <?php echo Html::radio("roleAdvisor", "", array('value' => 0, 'checked' => false)); ?>
            No
        </label>
    </div>
  </div>
</div>

<p>
  If you select Yes, the advisor will see everything you comment or share in the NIR
</p>
<p>
  If you select No, the advisor will only be informed about your progress   in the NIR but will have.
</p>
