<?php

use humhub\modules\loginUsers\models\ExtraDataUser;

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

switch ($option) {
    case 9:
        /*$login_url = 'http://een.ec.europa.eu/tools/Account/LogOn';
        $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        $ckfile = tempnam ("/tmp", "CURLCOOKIE");
        $post = array(
            'UserName' =>$usereen,
            'Password' =>$decryptedeen
        );
        $post_data = http_build_query($post);
        $ch = curl_init($login_url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
        $result = curl_exec($ch);

        $dest_url = 'http://een.ec.europa.eu/tools/CDM/EOI/EOIsReceived';
        $profile = EasyppProfile::find()->where(['space_id' => $contentContainer->id])->one();
        if ($profile) {
            $dest_url .= "?PartnerReceivedEOI-filter=ProfileReference~startswith~%27" . $profile->profile
                . "%27&CustomersReceivedEOI-filter=ProfileReference~startswith~%27" . $profile->profile
                . "%27&ArchivedReceivedEOI-filter=ProfileReference~startswith~%27" . $profile->profile
                . "%27)";
        }

        curl_setopt($ch, CURLOPT_URL, $dest_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
        $result = curl_exec($ch);
        curl_close($ch);*/

        echo \humhub\modules\companies\widgets\CreateFormCompany::widget(['space' => $contentContainer, 'card_id' => $card->id]);
        break;
    case 10:
        echo \humhub\modules\companies\widgets\CreateCompanyInfo::widget(['space' => $contentContainer,
            'card_id' => $card->id, 'action' => false]);
        break;
    case 11:
        echo \humhub\modules\companies\widgets\CreateCompanyInfo::widget(['space' => $contentContainer,
            'card_id' => $card->id, 'action' => true]);
        break;
    case 12:
        echo \humhub\modules\companies\widgets\SelectNir::widget(['contentContainer' => $contentContainer,
            'card_id' => $card->id, 'show_go' => true]);
        break;
    case 13:
        echo \humhub\modules\companies\widgets\CloseNir::widget(['contentContainer' => $contentContainer,
            'is_innovator' => false ,'card_id' => $card->id,]);
        break;
    case 14:
        echo \humhub\modules\companies\widgets\CloseNir::widget(['contentContainer' => $contentContainer,
            'is_innovator' => true,  'card_id' => $card->id,]);
        break;
    case 18:
        echo \humhub\modules\companies\widgets\ChooseTypeAdvisor::widget(['contentContainer' => $contentContainer,
            'canChange' => false,  'card_id' => $card->id,]);
        break;
    case 19:
        echo \humhub\modules\companies\widgets\ChooseTypeAdvisor::widget(['contentContainer' => $contentContainer,
            'canChange' => true,  'card_id' => $card->id,]);
        break;
}
