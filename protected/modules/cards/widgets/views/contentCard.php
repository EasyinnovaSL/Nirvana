<?php
use humhub\modules\file\widgets\ShowFiles;

foreach ($contentEntrys as $customEntry){
	echo $customEntry->getWallEntryWidget()->run();
?>
	<script type="text/javascript">

		jQuery(document).ready( function() {
//			$('button[id^=PollAnswerButton_]')
			$('#PollAnswerButton_<?= $customEntry->id ?>').off()
			$('#PollAnswerButton_<?= $customEntry->id ?>').click(function() {
				$.ajax({
					"type":"POST",
					"success":function(json) {
//						$('#wallEntry_'+json.wallEntryId).html(parseHtml(json.output));
						currentStream.showStream(); updateSteps();
					},
					"url":"<?= $contentContainer->createUrl('/polls/poll/create', ['pollId' => $customEntry->id]) ?>",
					"data":$('#PollAnswerButton_').closest('form').serialize()
				});
				return false;
			})
		})
	</script>


	<?php
}


foreach ($filesEntrys as $fileEntry)
	echo \humhub\modules\cards\widgets\ShowCardFiles::widget(array('object' =>$fileEntry));

?>
