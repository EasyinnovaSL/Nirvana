<?php
?>
<ul class="steps clearfix">
    <?php foreach($steps as $step): ?>

        <li class="step <?php echo $step["status"]; ?>" style="width: <?php echo $widthStep ?>%;">
            <div class="step-content">
                <?php if($step["status"] == "completed"  ): ?>
                  <a href="<?= $space->createUrl('/cards/card/show', array('step_id' => $step->getStep()->one()->id)) ?>">
                <?php elseif ($step["status"] == "pending"  ): ?>
                  <a href="<?= $space->createUrl('/cards/card/show') ?>">
                <?php endif; ?>
                <span>
                  <?php echo $step['step']['step_name']; ?>
                </span>

                <?php if($step["status"] == "completed"): ?>
                  <i class="fa fa-circle "></i>
                <?php else: ?>

                  <?php if($step["status"] == "pending"): ?>
                      <i class="fa fa-circle-o"></i>
                  <?php else: ?>
                      <i class="fa fa-circle "></i>
                  <?php endif; ?>

                <?php endif; ?>

                <?php if($step["status"] == "completed" || $step["status"] == "pending") : ?></a><?php endif; ?>

            </div>
        </li>

    <?php endforeach; ?>
</ul>
