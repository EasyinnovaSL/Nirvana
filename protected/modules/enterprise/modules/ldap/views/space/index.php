<?php

use yii\helpers\Url;
use yii\helpers\Html;
use humhub\widgets\GridView;
use humhub\modules\space\modules\manage\widgets\MemberMenu;
?>
<?= MemberMenu::widget(['space' => $space]); ?>
<br />
<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo Yii::t('EnterpriseModule.ldap', '<strong>LDAP</strong> member mapping'); ?>
    </div>
    <div class="panel-body">
        <p class="pull-right">
            <?php echo Html::a(Yii::t('EnterpriseModule.ldap', "Create new mapping"), $space->createUrl('edit'), array('class' => 'btn btn-primary')); ?>
        </p>
        <br>
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-hover'],
            'columns' => [
                'dn',
                [
                    'header' => 'Actions',
                    'class' => 'yii\grid\ActionColumn',
                    'options' => ['width' => '80px'],
                    'buttons' => [
                        'update' => function($url, $model) use ($space) {
                            return Html::a('<i class="fa fa-pencil"></i>', $space->createUrl('edit', ['id' => $model->id]), ['class' => 'btn btn-primary btn-xs tt']);
                        },
                                'view' => function() {
                            return;
                        },
                                'delete' => function() {
                            return;
                        },
                            ],
                        ],
                ]]);
                ?>        
    </div>
</div>
