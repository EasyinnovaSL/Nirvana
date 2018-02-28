<?php

namespace humhub\modules\cards\widgets;

use humhub\modules\cards\models\StepUserSpace;
use Yii;
use humhub\components\Widget;

class MySteps extends Widget
{
    public $user_id;
    public $space_id;
    public $space;

    public function run()
    {
        $query = StepUserSpace::find();
        $query->joinWith('step', true, 'INNER JOIN');
        $query->joinWith('space', true, 'INNER JOIN');
        $query->where(['step_user_space.user_id' => $this->user_id, 'space.id' => $this->space_id]);
        $steps = $query->all();

        $count_step = count($steps);

        if ($count_step === 0) {
            return;
        }

        return $this->render('mySteps', array(
            'steps' => $steps,
            'space' => $this->space,
            'widthStep' => (100/$count_step)
        ));
    }

}

?>