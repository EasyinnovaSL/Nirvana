<?php
  use yii\helpers\Html;
  use yii\helpers\Url;
?>


<div class="user-nda-agreement">
	<?php foreach($users as $user): ?>
		<div class="row">
		  <div class="col-md-12">
		    <div class="form-group">
		      <?php
			  $user_stat = $user['status'];
			  if ($user['user_role_id'] == 3) $user_stat = 'observer';
			  echo $user['firstname']; ?> <?php echo $user['lastname']; ?> <span class="label label-<?php echo $user_stat; ?>"><?php echo $user_stat; ?></span>
		    </div>
		  </div>
		</div>
	<?php endforeach; ?>
</div>


<style>
	.user-nda-agreement .label-pending {
		background: #6fdbe8;
	}
	.user-nda-agreement .label-observer {
		background: #bebebe;
	}
	.user-nda-agreement .label-signed {
		background: #4CAF50;
	}
</style>
