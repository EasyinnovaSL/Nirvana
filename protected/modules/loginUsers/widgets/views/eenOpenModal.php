<?php

use \yii\helpers\Url;
use humhub\modules\loginUsers\models\ExtraDataUser;
use humhub\modules\user\models\GroupUser;

if (!Yii::$app->user->isGuest) {

    /* Check if the user is innovator Advisor */
    $userGroup = GroupUser::find()->where(['user_id' => Yii::$app->user->id])->one();

    if ($userGroup != null && $userGroup->group_id == INNOVATION_ADVISOR_GROUP_ID) {

        /* Check if the user has dismissed the modal */
        $user = ExtraDataUser::find()->where(['user_id' => Yii::$app->user->id, 'source_type_id' => 1])->one();
        if ($user == null || $user->dismissed == 0) { ?>

            <a id="eenLinkForm" style="display: none;"
               href="<?php echo Url::toRoute(['/loginUsers/een/open-een-form']); ?>"
               class="btn btn-enter" data-target="#globalModal"></a>

            <!-- Menu Toggle Script -->
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#eenLinkForm").click();
                });
            </script>

        <?php } else {
            /* Check EasyPP */
            $user = ExtraDataUser::find()->where(['user_id' => Yii::$app->user->id, 'source_type_id' => 2])->one();
            if ($user == null || $user->dismissed == 0) { ?>

                <a id="eenLinkForm" style="display: none;"
                   href="<?php echo Url::toRoute(['/loginUsers/een/open-easypp-form']); ?>"
                   class="btn btn-enter" data-target="#globalModal"></a>

                <!-- Menu Toggle Script -->
                <script type="text/javascript">
                    $(document).ready(function () {
                        $("#eenLinkForm").click();
                    });
                </script>

            <?php }
        }
    }
}?>