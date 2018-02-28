<?php
use yii\helpers\Html;
use yii\helpers\Url;
use humhub\widgets\RichText;

use humhub\modules\content\components\ContentContainerController;

?>


<div class="form-horizontal">
    <div class="cards">
        <?php $idActual = 0;
        $totalStatus = count($spaceStatus);
        foreach ($companies as $company):
            $i = 0;
            $status = 'pending';
            $trobat = false;
            while ($i < $totalStatus && !$trobat) {
                if ($company->id == $spaceStatus[$i]->company_id) {
                    $trobat = true;
                    $reason=$spaceStatus[$i]->reason;
                    if($reason=="null"){
                        $reason="";
                    }
                    switch ($spaceStatus[$i]->status) {
                        case 0:
                            $status = 'pending';
                            break;
                        case 1:
                            $status = 'dismissed';
                            break;
                        case 2:
                            $status = 'completed';
                            break;
                    }
                }
                $i++;
            }

            ?>

            <div class="card fold panel card-<?php echo $status ?>"
                 id="card_<?php echo $idActual ?>" style="height: 120px;">
            <span class="label label-<?php echo $status ?> pull-right"
                  style="position: absolute;top: -1px;right: 0px;text-transform: uppercase;">
                <?php switch ($status) {
                    case "pending":
                        echo "pending";
                        break;
                    case "dismissed":
                        echo "rejected";
                        break;
                    case "completed":
                        echo "accepted";
                        break;
                } ?>
            </span>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        Company name
                    </label>

                    <div class="col-sm-9">
                        <p class="form-control-static">
                            <?php if ($company["company_linkedin"]): ?>
                                <a href="<?php echo $company["company_linkedin"]; ?>"><?php echo $company["company_name"]; ?></a>
                            <?php else: ?>
                                <?php echo $company["company_name"]; ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        Website
                    </label>

                    <div class="col-sm-9">
                        <p class="form-control-static">
                            <a href="<?php echo $company["website"]; ?>"><?php echo $company["website"]; ?></a>
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        Contact name
                    </label>

                    <div class="col-sm-9">
                        <p class="form-control-static">
                            <?php if ($company["contact_linkedin"]): ?>
                                <a href="<?php echo $company["contact_linkedin"]; ?>"><?php echo $company["contact_name"]; ?></a>
                            <?php else: ?>
                                <?php echo $company["contact_name"]; ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        Contact email
                    </label>

                    <div class="col-sm-9">
                        <p class="form-control-static"><?php echo $company["contact_email"]; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        Cooperation looking for
                    </label>

                    <div class="col-sm-9">
                        <p class="form-control-static"><?php echo $company["cooperation_looking_for"]; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        Missing or unclear info
                    </label>

                    <div class="col-sm-9">
                        <p class="form-control-static"><?php echo $company["missing_info"]; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        Company detail
                    </label>

                    <div class="col-sm-9">
                        <p class="form-control-static"><?php echo $company["company_details"]; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        Advisor remark
                    </label>

                    <div class="col-sm-9">
                        <p class="form-control-static"><?php echo $company["advisor_remarks"]; ?></p>
                    </div>
                </div>

                <br/>

                <?php if ($actions): ?>

                    <?php if ($status=="dismissed" || $status=="pending"): ?>

                        <?php if ($status=="dismissed"): ?>
                            <div class="form-group">
                                <span class="col-sm-3 control-label" style="padding-top: 0px;font-weight: bold;">Reject reason:</span>
                                <div class="col-sm-9">
                                    <div class="col-sm-8" style="padding-left: 0px;">
                                        <?php echo $reason; ?>
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                        <div class="form-group">
                            <span class="col-sm-3 control-label" style="font-weight: bold;"></span>
                            <div class="col-sm-9">
                                <div class="col-sm-8" style="padding-left: 0px;">
                                </div>
                                <div class="col-sm-4" style="padding-left: 0px;">

                                    <?php
                                    echo Html::a('Reject company',
                                        $space->createUrl('/companies/nir/dismis',
                                            array('space_id' => $space->id, 'company_id' => $company->id,'reason' => $reason)),
                                        array('class' => 'btn btn-default buttonCardToRight', 'data-target' => '#globalModal'));
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <span class="col-sm-3 control-label"></span>
                        <div class="col-sm-9">
                            <div class="col-sm-12">
                                <?php
                                echo Html::a('Create private room (NIR)',
                                    $space->createUrl('/companies/nir/create',
                                        array('space_id' => $space->id, 'company_id' => $company->id)),
                                    array('class' => 'btn btn-default buttonCardToRight', 'data-target' => '#globalModal'));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-sm-3 control-label"></span>
                        <div class="col-sm-9">
                            <div class="col-sm-12">
                                <div style="width: 70%;"></div>
                                <?php
                                echo Html::a('Add to existing private room (NIR)',
                                    $space->createUrl('/companies/nir/add-to',
                                        array('space_id' => $space->id, 'company_id' => $company->id)),
                                    array('class' => 'btn btn-default buttonCardToRight', 'data-target' => '#globalModal'));
                                ?>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <?php if ($status=="dismissed"):
                        echo "<label style='padding-top: 0px;' class='col-sm-3 control-label'>Reject reason:</label> " . $reason;
                    endif; ?>
                <?php endif; ?>
                <a href="javascript:void(0)" onclick="switchCard(<?php echo $idActual ?>)"
                   class="btn-material btn-danger-material btn-fab-material toggleLink">
                    <i class="fa fa-angle-down arrow"></i>
                </a>
            </div>

            <?php $idActual++;
        endforeach;
        if ($idActual == 0) {
            ?>
            <p>Your Innovation Advisor has not proposed any partner yet</p>
            <?php
        }

        if (!$actions) {
          echo \humhub\widgets\AjaxButton::widget([
              'label' => Yii::t('SpaceModule.views_create_create', 'Share'),
              'ajaxOptions' => [
                  'type' => 'POST',
                  'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                  'success' => new yii\web\JsExpression('function(html){ $("#globalModalCompany").html(html); currentStream.showStream(); updateSteps(); }'),
                  'url' => $space->createUrl('/companies/form/send', array('space_id' => $space->id, 'card_id' => $card_id)),
              ],
              'htmlOptions' => [
                  'class' => 'btn btn-primary',
                  'id' => 'company-form-send-button',
              ]
          ]);
        }
        ?>
    </div>

</div>
<script>
    function reject(idCard){
        reason=encodeURI($('#reject-reason_'+idCard).val());
        hrefOLD=$("#linkID_"+idCard+" a").attr('href');
        hrefNEW=hrefOLD+"&reason="+reason;
        $("#linkID_"+idCard+" a").attr("href", hrefNEW);
        $("#linkID_"+idCard+" a").click();
    }
    function switchCard(idCard) {

        $('#card_' + idCard).toggleClass('fold');

        if ($('#card_' + idCard).hasClass("fold")) {
            $('#card_' + idCard).animate({height: "120px"}, 400);// initial
        } else {
            $('#card_' + idCard).animate({height: "100%"}, 400);// initial
        }

        $('#card_' + idCard + ' .toggleLink .arrow').toggleClass('fa-angle-down');
        $('#card_' + idCard + ' .toggleLink .arrow').toggleClass('fa-angle-up');
        $(".rejectClass").click(function(){
            setTimeout(function(){ $("#globalModal").click(); }, 2000);
        });
    }
</script>
