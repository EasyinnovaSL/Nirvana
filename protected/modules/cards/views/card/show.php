<?php

humhub\modules\cards\Assets::register($this);
$this->registerJsVar('showsteps', $contentContainer->createUrl('/cards/card/show-steps'));
if ($welcomeScreen)  {
    echo \humhub\modules\cards\widgets\WelcomeScreen::widget(array('space' => $contentContainer));
} else {
?>
    <div id="step_container" class="panel">
<?php
    echo \humhub\modules\cards\widgets\MySteps::widget(array('user_id' => $user_id, 'space_id' => $space_id,
        'space' => $contentContainer));
?>
    </div>
<?php
    echo \humhub\modules\content\widgets\Stream::widget(array(
        'contentContainer' => $contentContainer,
        'streamAction' => '/cards/card/stream',
        'showFilters' => true,
        'streamActionParams' => array(
            'from' => '',
            'limit' => 1000,
            'step_id' => Yii::$app->request->get('step_id')),
        'filters' => [
            'filter_card_complete' => "Completed",
            'filter_card_pending' => "Pending",
            'filter_card_dismiss' => "Dismissed",
            'filter_card_archived' => "Archived"
        ]
    ));
}

?>

<script type="text/javascript">
    $(document).ready( function () {

        $('#globalModal').on('hidden.bs.modal', function () {
            currentStream.showStream(); updateSteps();
        })

        // Delete humhub entry header
      //  $(".panel-body").children(".media").children(".media-body").remove();
        //$(".panel-body .media").children(".pull-left").remove();

      //  $(".panel-body .media-heading").remove();
      //  $(".panel-body .user-image").remove();
     //   $(".panel-body .media").children(".nav").remove();
     //   $(".panel-body .media").children("hr").remove();
     //   console.log('HI');

    });
</script>