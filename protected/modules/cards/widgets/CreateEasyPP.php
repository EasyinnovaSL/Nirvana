<?php
/**
 * Created by IntelliJ IDEA.
 * User: Victor Muñoz
 * Date: 30/11/2016
 * Time: 11:30
 */

namespace humhub\modules\cards\widgets;

use humhub\modules\cards\models\EasyppLinks;
use Yii;
use \yii\base\Widget;
use humhub\modules\enterprise\modules\spacetype\models\SpaceType;
use humhub\modules\cards\models\UserCard;

/**
 * SpaceInviteButtonWidget
 *
 * @author Victor Muñoz
 * @package humhub.modules_core.space.widgets
 * @since 0.11
 */
class CreateEasyPP extends Widget
{
    public $space;
    public $card_id;
    public $user;
    public $password;
    public $url;
    public $url2;
    public $contentContainer;
    public $type;
    public $linkCreated;
    public $innovator;
    public $status;

    public function run()
    {
        $this->url = 'http://www.easypp.eu/';

        $this->type = "BR";
        switch ($this->space->space_type_id)
        {
            case 2: $this->type = "BO";
                break;
            case 3: $this->type = "BR";
                break;
            case 4: $this->type = "TO";
                break;
            case 5: $this->type = "TR";
                break;
            case 6: $this->type = "RPP";
                break;
        }

        $card = UserCard::findOne(["card_id" => $this->card_id]);
        $status = $card->card_status;
        $this->linkCreated = $card->card_status == "ongoing";

        $easypp_links = EasyppLinks::findOne(["space_id" => $this->space->id]);
        if ($this->innovator == 1) {
            if ($easypp_links != null) {
                $this->linkCreated = true;
                $this->url = $easypp_links->innovator_link;
            } else {
                $this->linkCreated = false;
            }
        } else if ($this->linkCreated) {
            $this->url2 = $easypp_links->advisor_link;
        }

        if ($status != "completed") {
            if ($this->linkCreated || $this->innovator != 1) {
                return $this->render('createEasyPP', array(
                    'space' => $this->space,
                    'type' => $this->type,
                    'card_id' => $this->card_id,
                    'link_created' => $this->linkCreated,
                    'contentContainer' => $this->contentContainer,
                    'user' => $this->user,
                    'password' => $this->password,
                    'url' => $this->url,
                    'url2' => $this->url2,
                    'innovator' => $this->innovator
                ));
            }
        }
    }

}
