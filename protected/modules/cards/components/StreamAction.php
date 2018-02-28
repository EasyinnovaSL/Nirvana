<?php

namespace humhub\modules\cards\components;

use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\Cards;
use humhub\modules\cards\models\UserCard;
use Yii;
use humhub\modules\content\components\actions\ContentContainerStream;
use humhub\modules\polls\models\Poll;
use yii\db\Query;

class StreamAction extends ContentContainerStream
{

    public function setupFilters()
    {

        $space = $this->contentContainer->getPrimaryKey();

        $this->activeQuery->andWhere(['content.object_model' => Card::className()]);

        $this->activeQuery->leftJoin('user_card',
            'content.object_id=user_card.card_id AND user_card.user_id = :userId',
            ['userId' => $this->user->id]);

        $this->activeQuery->andWhere(['user_card.user_id' => $this->user->id]);

        $this->activeQuery->leftJoin('card',
            'content.object_id=card.id');

        $this->activeQuery->leftJoin('card_content',
            'card_content.card_id=card.id');

        $this->activeQuery->leftJoin('cards',
            'card.card_id=cards.id');
        $this->activeQuery->andWhere(['IS', 'cards.card_parent_id', new \yii\db\Expression('NULL')]);

        $this->activeQuery->leftJoin('step_user_space',
            'step_user_space.step_id=cards.step_id AND step_user_space.user_id = :userId AND step_user_space.space_id = :spaceId',
            ['userId' => $this->user->id, 'spaceId' => $space]);

        $this->activeQuery->andWhere(['card.hide' => 0]);

        if(Yii::$app->request->get('step_id')) {
            $this->activeQuery->andWhere(['step_user_space.step_id' => Yii::$app->request->get('step_id')]);
        } else {
            $this->activeQuery->andWhere(['step_user_space.status' => 'pending']);
        }


        $this->activeQuery->andWhere(['or',
            ['cards.content_required' => false],
            ['and',
            ['cards.content_required' => true],
            ['exists',
            (new Query())->select('id')->from('card_content')->where('card_id = card.id')]
            ]
            ]);

        if (in_array('card_complete', $this->filters)) {
            $this->activeQuery->andWhere(['user_card.card_status' => UserCard::STATUS_COMPLETED]);
        } elseif (in_array('card_pending', $this->filters)) {
            $this->activeQuery->andWhere(['user_card.card_status' => UserCard::STATUS_PENDING]);
        } elseif (in_array('card_dismiss', $this->filters)) {
            $this->activeQuery->andWhere(['user_card.card_status' => UserCard::STATUS_DISMISSED]);
        } elseif (in_array('card_archived', $this->filters)) {
            $this->activeQuery->andWhere(['user_card.card_status' => UserCard::STATUS_PENDING]);
        }

        $this->activeQuery->orderBy("");

        $this->activeQuery->addOrderBy('cards.card_order ASC');

        $this->activeQuery->limit(1000);

    }

}

?>
