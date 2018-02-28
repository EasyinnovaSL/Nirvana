<?php

use humhub\modules\cards\widgets\ExternalContent;
use humhub\modules\cards\widgets\LinkShare;
use humhub\modules\cards\widgets\NewMeeting;
use humhub\modules\cards\widgets\NewPoll;
use humhub\modules\space\widgets\InviteButton;
use humhub\modules\cards\widgets\CardFile;
use humhub\modules\cards\widgets\CreateEasyPP;
use humhub\modules\cards\widgets\SearchLink;
use humhub\modules\cards\widgets\ExternalLink;
use humhub\modules\cards\widgets\Ipib;
use humhub\modules\loginUsers\models\ExtraDataUser;
use humhub\modules\cards\models\EasyppProfile;
use humhub\modules\cards\widgets\ProfileStatus;

if (!function_exists('decryptPassword')) {
    function decryptPassword($password, $key)
    {
        $data = base64_decode($password);
        $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
        $decrypted = rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $key, true),
                substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
                MCRYPT_MODE_CBC,
                $iv
            ),
            "\0"
        );
        return $decrypted;
    }
}

$userextradataeen = ExtraDataUser::find()->where(['user_id' => Yii::$app->user->id, 'source_type_id' => 1])->one();
$usereen = null;
$decryptedeen = null;
if ($userextradataeen != null && $userextradataeen->username != null && $userextradataeen->password != null) {
    $usereen = $userextradataeen->username;
    $decryptedeen = decryptPassword($userextradataeen->password, $userextradataeen->username);
}

$userextradataeasypp = ExtraDataUser::find()->where(['user_id' => Yii::$app->user->id, 'source_type_id' => 2])->one();
$usereasypp = null;
$decryptedeasypp = null;
if ($userextradataeasypp != null && $userextradataeasypp->username != null && $userextradataeasypp->password != null) {
    $usereasypp = $userextradataeasypp->username;
    $decryptedeasypp = decryptPassword($userextradataeasypp->password, $userextradataeasypp->username);
}

switch ($option) {
    case 2:
        echo InviteButton::widget(['space' => $contentContainer], ['sortOrder' => 10]);
        break;
    case 3:
        echo NewPoll::widget(['space' => $contentContainer, 'card_id' => $card->id]);
        break;
    case 5:
        $rightSide = $card->getCard()->one()->card_skip;
        if ($rightSide) {
            ?><div id="divformMeeting" class="formMeeting"><?php
        }
        echo NewMeeting::widget(['space' => $contentContainer, 'card_id' => $card->id]);
        if ($rightSide) {
            ?><script>if (typeof moveCardToRight === "function") moveCardToRight(".layout-content-container .formMeeting", "unique4");</script></div><?php
        }
        break;
    case 7:
        echo CardFile::widget(['space' => $contentContainer, 'card_id' => $card->id]);
        break;
    case 8:
        // Remove done button
        ?> <script>$("#child-card-id-<?php echo $card->id; ?> .btn-completed").remove();</script>  <?php

        echo CreateEasyPP::widget(['space' => $contentContainer, 'card_id' => $card->id, 'contentContainer' => $contentContainer,
            'user' => $usereasypp, 'password' => $decryptedeasypp]);
        echo LinkShare::widget(['space' => $contentContainer, 'card_id' => $card->id]);
        break;
    case 15:
        echo ExternalContent::widget(['space' => $contentContainer, 'card_id' => $card->id,
            'login_url' => 'http://een.ec.europa.eu/tools/Account/LogOn',
            'user' => $usereen, 'password' => $decryptedeen,
            'destination_url' => 'http://een.ec.europa.eu/tools/PRO/Profile/MyProfiles#OnHold',
            'frame_id' => 'frame1', 'card' => $card, 'contentContainer' => $contentContainer
        ]);
        break;
    case 16:
        $rightSide = $card->getCard()->one()->card_skip;
        if ($rightSide) {
            ?><div id="divformPotentialPartners" class="formPotentialPartners"><?php
        }

        echo ExternalContent::widget(['space' => $contentContainer, 'card_id' => $card->id,
            'login_url' => 'http://een.ec.europa.eu/tools/Account/LogOn',
            'user' => $usereen, 'password' => $decryptedeen,
            'destination_url' => 'http://een.ec.europa.eu/tools/SearchCenter/Search/ProfileSimpleSearch#mainContentBody',
            'frame_id' => 'frame2', 'card' => $card, 'contentContainer' => $contentContainer
        ]);

        if ($rightSide) {
            ?><script>if (typeof moveCardToRight === "function") moveCardToRight(".layout-content-container .formPotentialPartners", "unique5");</script></div><?php
        }
        break;
    case 17:
        $dest_url = 'http://een.ec.europa.eu/tools/CDM/EOI/EOIsReceived';
        $profile = EasyppProfile::find()->where(['space_id' => $contentContainer->id])->one();
        if ($profile) {
            $dest_url .= "?PartnerReceivedEOI-filter=ProfileReference~startswith~%27" . $profile->profile
                . "%27&CustomersReceivedEOI-filter=ProfileReference~startswith~%27" . $profile->profile
                . "%27&ArchivedReceivedEOI-filter=ProfileReference~startswith~%27" . $profile->profile
                . "%27)";
        }
        echo ExternalContent::widget(['space' => $contentContainer, 'card_id' => $card->id,
            'login_url' => 'http://een.ec.europa.eu/tools/Account/LogOn',
            'user' => $usereen, 'password' => $decryptedeen,
            'destination_url' => $dest_url,
            'destination_url2' => $dest_url . '#mainContentBody',
            'frame_id' => 'frame3', 'card' => $card, 'contentContainer' => $contentContainer
        ]);
        break;
    case 27:
        echo SearchLink::widget(['space' => $contentContainer, 'card_id' => $card->id,
            'url' => 'https://www.linknovate.com/search/?query=']);
        break;
    case 28:
        echo ExternalLink::widget(['space' => $contentContainer, 'card_id' => $card->id,
            'user' => '', 'password' => '',
            'url' => 'https://platform.iplytics.com/login']);
        break;
    case 29:
        echo Ipib::widget(['space' => $contentContainer, 'card_id' => $card->id, 'contentContainer' => $contentContainer]);
        break;
    case 30:
        echo ProfileStatus::widget(['space' => $contentContainer, 'card_id' => $card->id, 'submitted' => false, 'online' => false]);
        break;
    case 31:
        echo CreateEasyPP::widget(['space' => $contentContainer, 'card_id' => $card->id, 'contentContainer' => $contentContainer, 'innovator' => 1]);

}
