<?php

namespace humhub\modules\nda\controllers;

use Yii;
use yii\web\HttpException;
use yii\helpers\Html;
use humhub\modules\cards\behaviors\StepFlow;
use humhub\modules\cards\models\StepUserSpace;
use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\Cards;
use humhub\modules\cards\models\UserCard;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\nda\models\NdaModel;
use humhub\modules\nda\models\NdaAgreement;
use humhub\modules\nda\models\NdaModelChoose;
use humhub\modules\nda\models\NdaModelObligatory;
use humhub\modules\space\models\Space;
use humhub\modules\post\models\Post;
use humhub\modules\cards\models\CardContent;
use humhub\modules\nda\models\CardRestriction;
/**
 * Default controller for the `example` module
 */
class NdaModelController extends ContentContainerController
{

    public function behaviors()
    {
        return array(
            StepFlow::className()
        );
    }

    public function actionObligatory()
    {
        $obligatory   = Yii::$app->request->post('ndaModelObligatory');
        $space_id     = Yii::$app->request->get('space_id');
        $card_id      = Yii::$app->request->get('card_id');

        $ndaModelObligatory = NdaModelObligatory::findOne(['space_id' => $space_id]);

        if(is_null($ndaModelObligatory) && $obligatory == 1){
          $addNdaModelObligatory = new NdaModelObligatory();
          $addNdaModelObligatory->space_id = $space_id;

          if($addNdaModelObligatory->save()){
            $card = Card::findOne($card_id);
            $cards_related = $card->getRelatedHideCards();

            foreach ($cards_related as $card_related) {
              Card::updateHideCard($card_related);
            }

            StepFlow::updateFlowStatus($card_id, StepUserSpace::STATUS_COMPLETED);

            return true;
          }

        }else{

          $card = Card::findOne($card_id);

          StepFlow::updateFlowStatus($card_id, StepUserSpace::STATUS_COMPLETED);

          $cardsRestriction = \humhub\modules\cards\models\CardRestriction::find()->where(['card_restriction_completed_id' => $card->card_id])->all();


          $card_restriction_id_array = [];
          foreach ($cardsRestriction as $cardRestriction) $card_restriction_id_array[] = $cardRestriction->card_id;

          $query = UserCard::find();
          $query->joinWith('card', true, 'INNER JOIN');
          $query->where(['in','card.card_id',$card_restriction_id_array])->where(['card.space_id' => $space_id]);
          $cards = $query->all();

          foreach ($cards as $card_related) StepFlow::updateFlowStatus($card_related->card->id, StepUserSpace::STATUS_COMPLETED, $card_related->user_id);

          return true;

        }

        return false;
    }

    public function actionChose()
    {
        $space_id = \Yii::$app->request->get('space_id');
        $card_id = \Yii::$app->request->get('card_id');
        $nda_model_id = \Yii::$app->request->post('ndaChooseModelList');
        $nda_model_chose = NdaModelChoose::findOne(['space_id' => $space_id]);

        if(!$nda_model_chose){
          $newNdaModelChoose = new NdaModelChoose();
          $newNdaModelChoose->space_id = $space_id;
          $newNdaModelChoose->nda_model_id = $nda_model_id;
          $newNdaModelChoose->save();
        }else{
          $newNdaModelChoose = NdaModelChoose::findOne(['space_id' => $space_id]);
          $newNdaModelChoose->nda_model_id = $nda_model_id;
          $newNdaModelChoose->update();
        }

        $card = Card::findOne($card_id);
        $cards_related = $card->getRelatedHideCards();

        foreach ($cards_related as $card_related) {
          Card::updateHideCard($card_related);

            /*$card = Cards::findOne($card_related->card_id);

            $discussion_cards = (new \yii\db\Query())
                ->select('*')
                ->from('card')
                ->innerJoin('cards', 'cards.id = card.card_id')
                ->where(['card.space_id' => $space_id, "cards.card_type_id" => $card->card_type_id])
                ->all();

            foreach ($discussion_cards as $related_discussion_card) {
                Card::updateHideCard($related_discussion_card);
            }*/

        }

        $card_id = Yii::$app->request->get('card_id');
        StepFlow::updateFlowStatus($card_id, StepUserSpace::STATUS_COMPLETED);
    }

    public function actionViewModel()
    {
        $nda_model = NdaModel::findOne(['id' => \Yii::$app->request->post('ndaChooseModelList')]);

        if ($nda_model == null) {
            throw new HttpException(404, Yii::t('FileModule.controllers_FileController', 'Could not find requested file!'));
        }

        if (!file_exists($nda_model->getStoredFilePath($nda_model->pdf))) {
            throw new HttpException(404, Yii::t('FileModule.controllers_FileController', 'Could not find requested file!'));
        }

        return $nda_model->pdf;

    }


    public function actionPost()
    {
        // Check createPost Permission
        if (!$this->contentContainer->permissionManager->can(new \humhub\modules\post\permissions\CreatePost())) {
            return [];
        }

        $card_id = Yii::$app->request->post('card_id');

        $card = Card::findOne($card_id);

        $post = new Post();
        $post->message = \Yii::$app->request->post('message');

        $r_ = \humhub\modules\content\widgets\WallCreateContentForm::create($post, $this->contentContainer);

        if (isset($r_['wallEntryId'])) {
            //$newContentRelated = new CardContent();
            //$newContentRelated->card_id = $card_id;
            //$newContentRelated->content_related_id = $post->getContent()->one()->id;
            //$newContentRelated->tag = Post::className();
            //$newContentRelated->save();

            StepFlow::CardContentRelated($card_id, $post->getContent()->one()->id, Post::className());

            $cards_related = $card->getRelatedHideCards();

            foreach ($cards_related as $card_related) {
              Card::updateHideCard($card_related);
            }

            /*$cards_related = $card->getChildRelated();

            foreach ($cards_related as $card_related) {

              $newContentRelated = new CardContent();
              $newContentRelated->card_id = $card_related->id;
              $newContentRelated->content_related_id = $post->getContent()->one()->id;
              $newContentRelated->tag = Post::className();
              $newContentRelated->save();

            }*/

        }

        return $r_;

    }

    public function actionConfirm()
    {

        $space_id     = \Yii::$app->request->get('space_id');
        $nda_model_id = \Yii::$app->request->post('ndaConfirmModelList');

        $space = Space::findOne(['id' => $space_id]);

        foreach($space->getMembershipUser()->all() as $user) {
          $model = new NdaAgreement();
          $model->nda_model_id = (int)$nda_model_id;
          $model->space_id = (int)$space_id;
          $model->status = 'pending';
          $model->user_id = (int)$user->id;


          if($model->validate()){
            $model->save();
          }

        }

        $card_id = Yii::$app->request->get('card_id');

        $card = Card::findOne($card_id);
        $cards_related = $card->getRelatedHideCards();

        foreach ($cards_related as $card_related) {
          Card::updateHideCard($card_related);
        }

        StepFlow::updateFlowStatus($card_id, StepUserSpace::STATUS_COMPLETED);

    }


    public function actionSign()
    {

        $space_id = \Yii::$app->request->get('space_id');
        $user_id  = \Yii::$app->user->id;

        $ndaagreement = NdaAgreement::findOne(['space_id' => $space_id, 'user_id' => $user_id]);
        $ndaagreement->status = 'signed';

        if($ndaagreement->update()){
          $card_id = Yii::$app->request->get('card_id');
          StepFlow::updateFlowStatus($card_id, StepUserSpace::STATUS_COMPLETED);

            $pending = (new \yii\db\Query())
                ->select('nda_agreement.status as status, space_user_role.user_role_id as user_role_id')
                ->from('nda_agreement')
                ->innerJoin('user', 'nda_agreement.user_id = user.id')
                ->innerJoin('profile', 'profile.user_id = user.id')
                ->innerJoin('space_user_role', 'user.id = space_user_role.user_id')
                ->where(['nda_agreement.space_id' => $space_id, 'space_user_role.space_id' => $space_id])
                ->all();

            // TODO: millorable
            $nda_signed_all = true;
            foreach($pending as $user) {
                $user_stat = $user['status'];
                if ($user['user_role_id'] == 3) $user_stat = 'observer';
                if ($user_stat == 'pending') {
                    $nda_signed_all = false;
                    break;
                }
            }

          //$nda_signed_all = is_null(NdaAgreement::findOne(['space_id' => $space_id, 'status' => 'pending']));

          if($nda_signed_all){

            //obtener ID cartas "estaticamente" y actualizar el estado de todas las relacionadas
            //Más adelante se creará una tercera tabla para indicar las relaciones entre cartas
            $query = UserCard::find();
            $query->joinWith('card', true, 'INNER JOIN');
            $query->where(['in','card.card_id',[86, 90, 94]])->where(['card.space_id' => $space_id]);
            $cards = $query->all();

            foreach ($cards as $card_related) {
              StepFlow::updateFlowStatus($card_related->card->id, StepUserSpace::STATUS_COMPLETED, $card_related->user_id);
            }

          }


        }

    }





}