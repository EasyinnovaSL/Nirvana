<?php
/**
 * Created by Victor Muñoz.
 * User: easy
 * Date: 28/11/2016
 * Time: 13:09
 */

?>

<!-- Div for the login form -->
<div id="divform<?php echo $frame_id; ?>"></div>

<!-- Launch button -->
<?php
echo \humhub\widgets\AjaxButton::widget([
    'label' => Yii::t("CardsModule.buttons", 'Launch'),
    'ajaxOptions' => [
        'type' => 'POST',
        'beforeSend' => new yii\web\JsExpression('function(html){ }'),
        'success' => new yii\web\JsExpression('function(html){ launch'.$frame_id.'(); currentStream.showStream(); updateSteps(); }'),
        'url' => $contentContainer->createUrl('/cards/card/ongoing', array('card_id' => $card->id)),
    ],
    'htmlOptions' => [
        'class' => 'btn btn-primary',
        'id' => 'btnform'.$frame_id
    ]
]);
?>

<!-- Frame to put the destination url content -->
<div id='<?php echo $frame_id; ?>' class="frameHidden"><iframe name='i<?php echo $frame_id; ?>' id='i<?php echo $frame_id; ?>' frameborder='0' width='100%' height='100%'></iframe></div>

<script type="text/javascript">
    // Add the login form via jquery
    var count<?php echo $frame_id; ?> = 3;
    var sform = "<form id='login<?php echo $frame_id; ?>' target='i<?php echo $frame_id; ?>' method='post' action='<?php echo $login_url; ?>'>";
    sform += "<input name='UserName' type='hidden' value='<?php echo $user; ?>'>";
    sform += "<input name='Password' type='hidden' value='<?php echo $password; ?>'>";
    sform += "</form>";
    $("#divform<?php echo $frame_id; ?>").append(sform);

    // Close button (un-fullscreenize frame)
    function close<?php echo $frame_id; ?>() {
        $("#btnClose<?php echo $frame_id; ?>").remove();
        var element = $("#<?php echo $frame_id; ?>").detach();
        $(element).removeClass("modalDiv2");
        $("#btn<?php echo $frame_id; ?>").after(element);
        $("#modalDiv").remove();
    }

    // Load content to iframe and "fullscreenize" it)
    function launch<?php echo $frame_id; ?>() {
        var element = $("#<?php echo $frame_id; ?>").detach();
        $(element).addClass("modalDiv2");
        $("body").prepend(element);
        $("body").prepend("<div class='modal-backgroundX' id='modalDiv'></div>");
        $("#<?php echo $frame_id; ?>").prepend("<a class='btn btn-primary topRightButtonX' id='btnClose<?php echo $frame_id; ?>' onclick='close<?php echo $frame_id; ?>();'>Close</a>");
        window.scrollTo(0, 0);

        // Submit the login form -> sends the login form to the login url, and displays the result page (once logged in) in the iframe
        $("#login<?php echo $frame_id; ?>").submit();

        // Frame onload event (once logged in go to the destination url/s)
        var iframe<?php echo $frame_id; ?> = document.getElementById('i<?php echo $frame_id; ?>');
        iframe<?php echo $frame_id; ?>.onload = function() {
            // Set the frame src to the destination url
            console.log("going to <?php echo $destination_url; ?>");
            if (iframe<?php echo $frame_id; ?>.src != "<?php echo $destination_url; ?>") {
                if (count<?php echo $frame_id; ?>-- > 0) {
                    iframe<?php echo $frame_id; ?>.src = "<?php echo $destination_url; ?>";
                }
            } else {
                // If it is set it means the destination page has been loaded, so we can show the frame
                $("#<?php echo $frame_id; ?>").show();

                // And go to the second destination url if specified
                <?php if ($destination_url2 != null) { ?>
                if (count<?php echo $frame_id; ?>-- > 0) {
                    iframe<?php echo $frame_id; ?>.src = "<?php echo $destination_url2; ?>";
                }
                <?php } ?>
            }
        }
    }
</script>