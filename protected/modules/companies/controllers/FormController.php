<?php

namespace humhub\modules\companies\controllers;

use humhub\modules\cards\behaviors\StepFlow;
use humhub\modules\cards\models\UserCard;
use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\Cards;
use humhub\modules\cards\models\CardContent;
use humhub\modules\cards\models\StepUserSpace;
use humhub\modules\space\models\Space;
use humhub\modules\tasks\models\Task;
use Yii;
use yii\web\HttpException;
use humhub\components\Controller;
use humhub\modules\companies\models\Company;
use humhub\modules\companies\models\CompanySpace;
use humhub\modules\companies\models\CompanyCard;
use humhub\modules\companies\widgets\CompanyPicker;

/**
 * ViewController displays the companies form
 *
 * @package humhub.modules.companies.controllers
 * @author infoself
 */
class FormController extends Controller
{

    public function behaviors()
    {
        return array(
            StepFlow::className()
        );
    }

    public function actionSubmit()
    {
        $space = Space::find()->where(['id' => Yii::$app->request->get('space_id')])->one();


    }

    public function actionCreate($space = null)
    {
        $model = $this->createFormModel();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {

            $space = Space::find()->where(['id' => Yii::$app->request->get('space_id')])->one();

            // Save company
            $company_space = new CompanySpace();
            $company_space->company_id = $model->id;
            $company_space->space_id = $space->id;
            $company_space->save();

            // Update card status
            if ($card_id = Yii::$app->request->post('card_id')) {
                /*$card_content = CardContent::findAll(array('card_id' => $card_id));

                if (!$card_content) {
                    //Create Task for Innovator
                    $newTask = new Task();
                    $newTask->title = "Your Task: Inspect potential partners and start or add to a private space (NIR) if needed";
                    $newTask->content->container = $space;
                    $newTask->status = 1;
                    $newTask->max_users = 0;
                    $newTask->validate();
                    $newTask->save();

                    StepFlow::CardContentRelatedOnly($card_id, $newTask->getContent()->one()->id, Task::className());

                    StepFlow::updateFlowStatus($card_id, StepUserSpace::STATUS_ONGOING);
                }*/

                // Set child card to ongoing
                $card = Card::findOne($card_id);
                if ($card->getChilds()) {
                    foreach ($card->getChilds() as $child) {
                        StepFlow::updateFlowStatus($child->id, StepUserSpace::STATUS_ONGOING);
                    }
                }
            }

            Yii::$app->getSession()->setFlash('data-saved',
                Yii::t('AdminModule.controllers_SettingController', 'Saved'));
            //return $this->htmlRedirect($space->getUrl());
            return $this->renderAjax('save');
        } else {
            $space =
                ($space == null) ? Space::find()
                    ->where(['id' => Yii::$app->request->get('space_id')])->one() : $space;

            return $this->render('@humhub/modules/companies/widgets/views/form', [
                'model' => $model,
                'space' => $space,
                'card_id' => Yii::$app->request->post('card_id')
            ]);
        }
    }

    public function actionSend()
    {
        $space_id = Yii::$app->request->get('space_id');
        $companies = Company::find()->leftJoin('company_space',
            'company_space.company_id=company.id')
            ->where(['company_space.space_id' => $space_id,
                'company_space.submitted' => 0])->all();
        foreach($companies as $company) {
            $company_space = CompanySpace::findOne(['company_id' => $company->id, 'space_id' => $space_id]);
            $company_space->submitted = true;
            $company_space->save();
        }

        $card_id = Yii::$app->request->get('card_id');
        $card = Card::findOne(['id' => $card_id]);
        $card_def = Cards::findOne(['id' => $card->card_id]);
        $cards_related = Card::find()->leftJoin('cards','card.card_id=cards.id')->where(['card.space_id' => $space_id,
            'cards.related_card' => $card_def->card_parent_id])->all();
        foreach ($cards_related as $card_related) {
            $user_card = UserCard::findOne(['card_id' => $card_related->id]);
            StepFlow::updateFlowStatus($card_related->id, UserCard::STATUS_ONGOING, $user_card->user_id);
        }

    }

    public function actionSearchCompany()
    {

      $companyInfo = [];

        foreach(Company::find()->filterWhere(['LIKE', 'company_name', Yii::$app->request->get('keyword')])->all() as $company) {
        $companyInfo[$company->id]['id'] = $company->id;
        $companyInfo[$company->id]['company_name'] = $company->company_name;
        $companyInfo[$company->id]['company_linkedin'] = $company->company_linkedin;
        $companyInfo[$company->id]['website'] = $company->website;
        $companyInfo[$company->id]['contact_name'] = $company->contact_name;
        $companyInfo[$company->id]['contact_email'] = $company->contact_email;
        $companyInfo[$company->id]['contact_linkedin'] = $company->contact_linkedin;
      }

      return json_encode($companyInfo);
    }

    /**
     * Creates an empty company model
     *
     * @return Space
     */
    protected function createFormModel()
    {
        $model = new Company();
        return $model;
    }

}
