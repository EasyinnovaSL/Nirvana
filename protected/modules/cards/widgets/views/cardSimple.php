<?php

use yii\helpers\Html;
use humhub\models\Setting;
use \humhub\modules\file\widgets\FileUploadList;
?>

<div class="wall-entry" id="wallEntry_27">


    <div class="panel panel-default wall_humhubmodulespollsmodelsPoll_1">
        <div class="panel-body">

            <div class="media">


                <a href="/index.php?r=user%2Fprofile&amp;uguid=bb169071-faf7-42aa-aa0f-f9217bdbccaa" class="pull-left">
                    <img class="media-object img-rounded user-image user-bb169071-faf7-42aa-aa0f-f9217bdbccaa" alt="40x40" data-src="holder.js/40x40" style="width: 40px; height: 40px;" src="/uploads/profile_image/bb169071-faf7-42aa-aa0f-f9217bdbccaa.jpg?m=1478684858" width="40" height="40">
                </a>

                <!-- Show space image, if you are outside from a space -->


                <div class="media-body">

                    <?= FileUploadList::widget(['uploaderId' => 2]); ?>
                    <!-- show username with link and creation time-->
                    <h4 class="media-heading"><a href="/index.php?r=user%2Fprofile&amp;uguid=bb169071-faf7-42aa-aa0f-f9217bdbccaa">Jordi F</a>
                        <small>

                            <!-- show profile name -->

                            <span class="time" title="Nov 10, 2016 - 6:52 PM">about 11 hours ago</span>

                            <!-- show space name -->





                        </small>
                    </h4>
                    <h5>System Administration</h5>

                </div>

                <div style="float: left;"><?= $left_but ?></div>
                <div style="float: right;">a</div>

  </div>


        </div>

    </div>

</div>