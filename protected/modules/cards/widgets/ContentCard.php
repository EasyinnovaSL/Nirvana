<?php

namespace humhub\modules\cards\widgets;

use humhub\components\Widget;
use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\CardContent;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\models\Content;
use humhub\modules\content\models\ContentContainer;
use humhub\modules\file\models\File;
use humhub\modules\polls\models\Poll;

/**
 * PollWallEntryWidget is used to display a poll inside the stream.
 *
 * This Widget will used by the Poll Model in Method getWallOut().
 *
 * @package humhub.modules.polls.widgets
 * @since 0.5
 * @author Infoself
 */
class ContentCard extends Widget
{
    public $contentContainer;
    public $card;

    public function run()
    {
        $cardContents = CardContent::find()->orderBy(['order' => SORT_ASC])->where((array('card_id' => $this->card->id)))->all();
        if (!$cardContents) return;

        $contentEntrys = [];
        $filesEntrys    = [];
        foreach ($cardContents as $cardContent) {
            if ($content = $this->getContentRelated($cardContent->tag, $cardContent->content_related_id)) {

                if ($cardContent->tag == \humhub\modules\cfiles\models\File::className()) {
                    if ($file = File::findOne(array('object_id' => $content->id,
                        'object_model' => \humhub\modules\cfiles\models\File::className())))
                        $filesEntrys[] = $content;

                } else {

                    $contentEntrys[] = $content;
                }
            }

        }
        if (empty($contentEntrys) && empty($filesEntrys)) return;
        return $this->render('contentCard', ['contentContainer' => $this->contentContainer,
            'card' => $this->card, 'contentEntrys' => $contentEntrys, 'filesEntrys' => $filesEntrys]);
    }



    /**
     * Returns a readable calendar entry by given id
     *
     * @param int $id
     * @return CalendarEntry
     */
    protected function getContentRelated($model, $id)
    {
        return $model::find()->contentContainer($this->contentContainer)->readable()
            ->where(['content.id' => $id])->one();
    }


}

?>