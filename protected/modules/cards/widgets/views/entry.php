<?php

use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\UserCard;
use humhub\modules\cards\widgets\CardExtend;
use humhub\modules\cards\widgets\CardStatus;
use humhub\modules\cards\widgets\ContentCard;
use humhub\modules\cards\widgets\DeadLine;
use humhub\modules\cards\widgets\DismissButton;
use humhub\modules\cards\widgets\CompletedButton;
use humhub\modules\cards\widgets\NewPoll;
use humhub\modules\cards\widgets\SwitchCards;
use humhub\modules\space\widgets\InviteButton;
use yii\helpers\Html;
use humhub\modules\help\widgets\InteractiveTutorialCardButton;
use humhub\modules\help\widgets\InteractiveTutorialLoadChildCardJson;

?>




<?php $stat='';
        if ($card && $card->getStatus()) $stat=$card->getStatus()->card_status;

echo Html::beginForm();
?>

    <div class="card-heading">

        <?php
            echo InteractiveTutorialCardButton::widget(array('card' => $card, 'contentContainer' => $contentContainer));
        ?>

         <span class="label label-<?php echo $stat?> pull-right"><?php echo $stat ?></span>
        <?php
        echo DeadLine::widget(array('card' => $card, 'contentContainer' => $contentContainer));
        ?>
        <i class="fa circle circle-<?php echo $stat?> <?php print humhub\widgets\RichText::widget(['text' => $card->getCard()->one()->icon]); ?>"></i>
      <h1 class="title">  <?php print humhub\widgets\RichText::widget(['text' => $card->getCard()->one()->title]); ?> </h1>
        <p class="description"><?php print humhub\widgets\RichText::widget(['text' => $card->getCard()->one()->description]); ?> </p>

    </div>

<script>
    $(document).ready(function () {
        $('.wall_humhubmodulescardsmodelsCard_<?php print $card->id?>').addClass("card-<?php echo $stat ?>");
    });

</script>
<?php if ($card->getStatus() && $stat != UserCard::STATUS_DISMISSED): ?>
    <div class="card-body <?php echo $card->id?>" <?php if ($card->getStatus() && $stat != UserCard::STATUS_ONGOING && $card->getCard()->one()->folded == 0): ?>

     style="display:none;" <?php endif; ?>>

<?php
echo SwitchCards::widget(array('card' => $card, 'contentContainer' => $contentContainer));
echo CardExtend::widget(['object' => $card]);

echo "<script>
function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}

$('#company-website').focusout(function() {
    //var pattern= /\b[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/ig;
    //var result = pattern.test( $('#company-website').val() );
    //if(isUrlValid($('#company-website').val())){
    //    var pattern= /(.*[^\.])/i;
    //    var result = pattern.test( $('#company-website').val() );
    //}
    if(!isUrlValid($('#company-website').val())){
        //$('#company-website').val('');
        $('#company-website').parent().find('.help-block').text('". Yii::t('CompaniesModule.buttons','Website format not correct')."');
        $('#company-website').parent().find('.help-block').css('cssText', 'color: red !important;');
    }else{
        $('#company-website').parent().find('.help-block').text('');
    }
});
$('#company-contact_email').focusout(function() {
    var pattern= /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var result = pattern.test($('#company-contact_email').val());
    if(!result){
        //$('#company-contact_email').val('');
        $('#company-contact_email').parent().find('.help-block').text('". Yii::t('CompaniesModule.buttons','Email format not correct')."');
        $('#company-contact_email').parent().find('.help-block').css('cssText', 'color: red !important;');
    }else{
        $('#company-contact_email').parent().find('.help-block').text('');
    }
});
$('#company-company_linkedin').focusout(function() {
    //var pattern= /\b[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/ig;
    //var result = pattern.test( $('#company-company_linkedin').val() );
    if(!isUrlValid($('#company-company_linkedin').val())){
        //$('#company-company_linkedin').val('');
        $('#company-company_linkedin').parent().find('.help-block').text('". Yii::t('CompaniesModule.buttons','Website format not correct')."');
        $('#company-company_linkedin').parent().find('.help-block').css('cssText', 'color: red !important;');
    }else{
        $('#company-company_linkedin').parent().find('.help-block').text('');
    }
});
$('#company-contact_linkedin').focusout(function() {
    //var pattern= /\b[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/ig;
    //var result = pattern.test( $('#company-contact_linkedin').val() );
    if(!isUrlValid($('#company-contact_linkedin').val())){
        //$('#company-contact_linkedin').val('');
        $('#company-contact_linkedin').parent().find('.help-block').text('". Yii::t('CompaniesModule.buttons','Website format not correct')."');
        $('#company-contact_linkedin').parent().find('.help-block').css('cssText', 'color: red !important;');
    }else{
        $('#company-contact_linkedin').parent().find('.help-block').text('');
    }
});
</script>
";

echo ContentCard::widget(array('card' => $card, 'contentContainer' => $contentContainer));

?>

    <div class="cards">
        <?php foreach ($card->getChilds() as $c_):
            $statuschild=$c_->getStatus()->card_status;
            echo InteractiveTutorialLoadChildCardJson::widget(array('card' => $card,'childCard' => $c_, 'childCardStatus' => $statuschild, 'contentContainer' => $contentContainer));?>
            
            <div id="child-card-id-<?php echo $c_->id;?>" class="panel-child card-child card-<?php echo $statuschild?>">
                <div class="card-heading">
                    <span class="label label-<?php echo $statuschild?> pull-right"><?php echo $statuschild ?></span>
                    <i class="fa circle circle-<?php echo $statuschild?> <?php print humhub\widgets\RichText::widget(['text' => $c_->getCard()->one()->icon]); ?>"></i>
                    <h1 class="title">  <?php print humhub\widgets\RichText::widget(['text' => $c_->getCard()->one()->title]); ?> </h1>
                    <p class="description"><?php print humhub\widgets\RichText::widget(['text' => $c_->getCard()->one()->description]); ?> </p>
                </div>
                <?php if ($statuschild != UserCard::STATUS_DISMISSED): ?>


                <div class="card-body">
                    <?=  SwitchCards::widget(array('card' => $c_, 'contentContainer' => $contentContainer)); ?>
                    <?=  CardExtend::widget(['object' => $c_]); ?>
                    <?=  ContentCard::widget(array('card' => $c_, 'contentContainer' => $contentContainer)); ?>

                   <div class="action_right"> <?php
                    echo DismissButton::widget(array('card' => $c_, 'contentContainer' => $contentContainer, 'styleClass'=> 'btn-dismiss-child'));
                       echo CompletedButton::widget(array('card' => $c_, 'contentContainer' => $contentContainer));
                       ?></div>
                </div>
                <?php endif; ?>
            </div>

		<?php endforeach; ?>
    </div>

        <div class="action_right"> <?php
            echo DismissButton::widget(array('card' => $card, 'contentContainer' => $contentContainer, 'styleClass'=> 'btn-dismiss'));
            echo CompletedButton::widget(array('card' => $card, 'contentContainer' => $contentContainer));
            ?></div>


    </div>

    <?php if ($card->getCard()->one()->folded != 2): ?>
    <a id="folded-card-id-<?php echo $card->id ?>" href="javascript:void(0)" onclick="javascript:showCardBody(jQuery(this),<?php echo $card->id ?>)" class="btn-material btn-danger-material btn-fab-material">
    <i class="fa  <?php echo ($card->getStatus() && $stat != UserCard::STATUS_ONGOING && $card->getCard()->one()->folded == 0 )?  'fa-angle-down':  'fa-angle-up' ?>"></i></a>
    <?php endif; ?>

<?php endif; ?>

<?php echo Html::endForm(); ?>

<script type="text/javascript">
    jQuery(document).ready( function () {
        currentStream.loadMore = function () {};

        // Delete humhub entry header
        $(".panel-body").children(".media").children(".media-body").remove();
        $(".panel-body").children(".media").children(".media-heading").remove();
        $(".panel-body").children(".media").children(".pull-left").children(".user-image").remove();
        $(".panel-body").children(".media").children(".nav").remove();
        $(".panel-body").children(".media").children("hr").remove();
    })
</script>
