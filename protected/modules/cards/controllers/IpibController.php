<?php
/**
 * Created by IntelliJ IDEA.
 * User: Victor Muñoz
 * Date: 24/01/2017
 * Time: 13:45
 */

namespace humhub\modules\cards\controllers;

use Yii;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\cards\behaviors\StepFlow;

class IpibController extends ContentContainerController
{
    public $apitoken = "6WtrX3nd-7Qzapq9F6L8";

    public function behaviors()
    {
        return array(
            StepFlow::className()
        );
    }

    public function actions()
    {
        return array(
            'stream' => array(
                'class' => \humhub\modules\cards\components\StreamAction::className(),
                'mode' => \humhub\modules\cards\components\StreamAction::MODE_NORMAL,
                'contentContainer' => $this->contentContainer
            ),
        );
    }

    public function actionGetcities()
    {
        Yii::$app->response->format = 'json';

        $q = Yii::$app->request->get('q');
        $json = file_get_contents('https://ipib.ci.moez.fraunhofer.de/api/nirvana/v1/cities/search?q='.$q.'&api_token='.$this->apitoken);
        $obj = json_decode($json);

        return $obj;
    }

    public function actionGetipc()
    {
        Yii::$app->response->format = 'json';

        $q = Yii::$app->request->get('q');
        $json = file_get_contents('https://ipib.ci.moez.fraunhofer.de/api/nirvana/v1/ipc_classes/search?q='.$q.'&api_token='.$this->apitoken);
        $obj = json_decode($json);

        return $obj;
    }

    public function actionGetproviders()
    {
        Yii::$app->response->format = 'json';

        $city = Yii::$app->request->get('city');
        $distance = Yii::$app->request->get('distance');
        $ipc = Yii::$app->request->get('ipc');
        $params = 'city_slug='.urlencode($city);
        if ($distance) $params .= '&distance='.urlencode($distance);
        $params .= '&ipc_class_name='.urlencode($ipc);
        $json = file_get_contents('https://ipib.ci.moez.fraunhofer.de/api/nirvana/v1/service_provider/search?'.$params.'&api_token='.$this->apitoken);
        $obj = json_decode($json);

        return $obj;
    }

}