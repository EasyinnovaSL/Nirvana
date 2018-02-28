<?php

use yii\helpers\Html;
?>



<?php echo Html::textArea("message", '', array('id' => 'contentForm_message'.$id, 'class' => 'form-control autosize contentForm alwaysshow', 'rows' => '1', 'placeholder' => Yii::t("PostModule.widgets_views_postForm", "What's on your mind?"))); ?>

<?php echo Html::hiddenInput("card_id", $card_id); ?>

<?php

/* Modify textarea for mention input */
echo \humhub\widgets\RichTextEditor::widget(array(
    'id' => 'contentForm_message'.$id,
));
?>
