<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\loginUsers\authclient;

/**
 * @inheritdoc
 */
class Linkedin extends \yii\authclient\clients\LinkedIn
{

    /**
     * @inheritdoc
     */
    protected function defaultViewOptions()
    {
        return [
            'popupWidth' => 860,
            'popupHeight' => 480,
            'cssIcon' => 'fa fa-linkedin',
            'buttonBackgroundColor' => '#395697',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function defaultNormalizeUserAttributeMap()
    {

        return [
            'email' => 'email-address',
            'firstname' => 'first-name',
            'lastname' => 'last-name',
            'username' => function ($attributes) {
                if (!isset($attributes['first-name'])) {
                    return '';
                }else{
                    if (!isset($attributes['last-name'])) {
                        return $attributes['first-name'];
                    }else{
                        return $attributes['first-name'].' '.$attributes['last-name'];
                    }
                }
            },
            'name' => function ($attributes) {
                if (!isset($attributes['first-name'])) {
                    return '';
                }else{
                    if (!isset($attributes['last-name'])) {
                        return $attributes['first-name'];
                    }else{
                        return $attributes['first-name'].' '.$attributes['last-name'];
                    }
                }
            }

        ];


    }

}
