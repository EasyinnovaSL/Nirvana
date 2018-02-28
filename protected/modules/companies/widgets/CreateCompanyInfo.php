<?php

namespace humhub\modules\companies\widgets;

use humhub\components\Widget;
use humhub\modules\companies\models\Company;
use humhub\modules\companies\models\CompanySpace;


class CreateCompanyInfo extends Widget
{
    public $guid;
    public $card_id;
    public $action;
    public $space;

    /**
     * @inheritdoc
     */
    public function run()
    {

        $innovator = $this->action;

        if ($innovator) {
            $companies = Company::find()->leftJoin('company_space',
                'company_space.company_id=company.id')
                ->where(['company_space.space_id' => $this->space->id,
                    'company_space.submitted' => 1])->all();
        } else {
            $companies = Company::find()->leftJoin('company_space',
                'company_space.company_id=company.id')
                ->where(['company_space.space_id' => $this->space->id])->all();
        }
        $spaceStats = CompanySpace::find()->where(['company_space.space_id' => $this->space->id])->all();

      return $this->render('company', array(
        'companies' => $companies,
        'card_id' => $this->card_id,
        'actions' => $this->action,
        'spaceStatus' => $spaceStats,
        'space' => $this->space
      ));
    }

}

?>
